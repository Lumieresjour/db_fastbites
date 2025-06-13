<?php

namespace App\Http\Livewire;

use App\Mail\OrderReceived;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\InvoiceService;
use Livewire\Component;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Checkout extends Component
{
    public $use_cashback = false;
    public $cashback_amount = 0;
    public $final_total = 0;
    public $cart_total = 0;

    public function mount()
    {
        $this->use_cashback = request()->has('use_cashback');
        $this->calculateTotals();
    }

    public function updatedUseCashback($value)
    {
        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        $user = auth()->user();
        if ($user) {
            // Get cart total without formatting
            $this->cart_total = (float) str_replace(['.', ','], '', Cart::total());
            
            // Calculate cashback amount
            if ($this->use_cashback && $user->cashback > 0) {
                $this->cashback_amount = min($user->cashback, $this->cart_total);
            } else {
                $this->cashback_amount = 0;
            }
            
            // Calculate final total
            $this->final_total = $this->cart_total - $this->cashback_amount;
        }
    }

    public function getCartTotal()
    {
        return Cart::total();
    }

    public function success(Request $request, InvoiceService $invoiceService)
    {
        $sessionId = $request->get('session_id');

        // Find order by session_id (works for both Stripe and bypass)
        $order = Order::where('session_id', $sessionId)->first();
        if (!$order) {
            throw new NotFoundHttpException();
        }

        // Only update status if still pending
        if ($order->status === 'pending') {
            $order->status = 'processing';
            $order->save();
        }

        // Send order received email
        Mail::to($order->user->email)->send(new OrderReceived($order, $invoiceService->createInvoice($order)));
        Cart::destroy();

        // No Stripe customer, so just pass order/user info
        return view('livewire.success', ['customer' => $order->user]);
    }

    public function cancel()
    {
        return redirect()->route('home')->with('success', 'Your order has been canceled.');
    }

    public function makeOrder(Request $request)
    {
        $validatedRequest = $request->validate([
            'country' => 'required',
            'billing_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'zipcode' => 'required|numeric',
            'order_notes' => '',
        ]);

        $user = Auth::user();
        if ($user->billingDetails === null) {
            $user->billingDetails()->create($validatedRequest);
        } else {
            $user->billingDetails()->update($validatedRequest);
        }

        // Calculate totals
        $cartTotal = (float) str_replace(['.', ','], '', Cart::total());
        $cashbackUsed = 0;
        
        // Check if cashback should be used
        if ($this->use_cashback && $user->cashback > 0) {
            $cashbackUsed = min($user->cashback, $cartTotal);
            // Reset user's cashback balance to 0
            $user->cashback = 0;
            $user->save();
            
            // Add logging
            \Log::info('Cashback reset attempt', [
                'user_id' => $user->id,
                'old_cashback' => $user->getOriginal('cashback'),
                'new_cashback' => $user->cashback,
                'cashback_used' => $cashbackUsed
            ]);
        } else {
            // Reset cashback to 0 even if not used
            $user->cashback = 0;
            $user->save();
            
            \Log::info('Cashback reset (not used)', [
                'user_id' => $user->id,
                'old_cashback' => $user->getOriginal('cashback'),
                'new_cashback' => $user->cashback
            ]);
        }

        $finalTotal = $cartTotal - $cashbackUsed;

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'processing',
            'total' => $finalTotal,
            'session_id' => uniqid('bypass_', true),
            'cashback_used' => $cashbackUsed,
        ]);

        // Create order items
        foreach (Cart::content() as $item) {
            $price = (float) str_replace(['.', ','], '', $item->price);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
                'price' => $price
            ]);
        }

        Cart::destroy();

        return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
    }

    public function render()
    {
        if (Cart::count() <= 0) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $billingDetails = $user->billingDetails;
        return view('livewire.checkout', [
            'billingDetails' => $billingDetails,
            'use_cashback' => $this->use_cashback,
            'cashback_amount' => $this->cashback_amount,
            'final_total' => $this->final_total,
            'cart_total' => $this->cart_total
        ]);
    }
}
