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

        // Create order directly
        $total = str_replace(',', '', Cart::total());
        $order = new Order([
            'user_id' => $user->id,
            'status' => 'processing',
            'total' => $total,
            'session_id' => uniqid('bypass_', true), // Fake session ID
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

    // Optionally, you can create the order here if needed

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
        return view('livewire.checkout', compact('billingDetails'));
    }
}
