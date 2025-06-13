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
        if ($order->status === 'completed') {
            $user = $order->user;
            if ($user) {
                $user->increment('cashback', 5000);
            }
        }
    }
}
