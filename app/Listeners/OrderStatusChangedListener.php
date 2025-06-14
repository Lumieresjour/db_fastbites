<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderStatusChanged;

class OrderStatusChangedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChanged $event): void
    {
        $order = $event->order;
        $user = $order->user;
        
        if (!$user) {
            return;
        }

        if ($order->status === 'completed') {
            if ($order->cashback_used == 0) {
                $user->increment('cashback', 5000);
            }
        } elseif ($order->status === 'canceled') {
            // Return the cashback that was used in this order
            if ($order->cashback_used > 0) {
                $user->increment('cashback', $order->cashback_used);
                
                \Log::info('Cashback returned due to order cancellation', [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'cashback_returned' => $order->cashback_used
                ]);
            }
        }
    }
}
