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

    public function mount()
    {
        $this->use_cashback = request()->has('use_cashback');
    }

    public function updatedUseCashback($value)
    {
        $user = auth()->user();
        if ($user) {
            $cartTotal = (float) str_replace(['$', ','], '', Cart::total());
            $max = min($user->cashback, $cartTotal);
            $this->use_cashback = $value;
        }
    }

    public function getCartTotal()
    {
        // Ganti dengan logika total belanja Anda
        return \Cart::total();
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

        $cartTotal = (int) str_replace('.', '', \Cart::total());
        $cashbackUsed = ($this->use_cashback && $user->cashback > 0) ? min($user->cashback, $cartTotal) : 0;
        $finalTotal = $cartTotal - $cashbackUsed;

        if ($cashbackUsed > 0) {
            $user->decrement('cashback', $cashbackUsed);
        }

        // Create order directly
        $order = new Order([
            'user_id' => $user->id,
            'status' => 'processing',
            'total' => $finalTotal,
            'session_id' => uniqid('bypass_', true), // Fake session ID
            'cashback_used' => $cashbackUsed,
        ]);
        $order->save();

        foreach (Cart::content() as $item) {
            $price = str_replace(',', '', $item->price);
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
                'price' => $price
            ]);
            $orderItem->save();
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
            'use_cashback' => $this->use_cashback
        ]);
    }
}
