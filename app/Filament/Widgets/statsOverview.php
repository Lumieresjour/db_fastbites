<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class statsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $unshippedOrders = Order::where('status', '!=', 'completed')->count();
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalSalesLast30Days = Order::where('status', 'completed')->where('created_at', '>=', now()->subDays(30))->sum('total');
        return [
            Card::make('Last 30 Days', 'Rp'.$totalSalesLast30Days)
            ->description('Total sales for the last 30 days')
            ->color('success')
            ->icon('heroicon-o-cash'),
            Card::make('Total Sales', 'Rp'.$totalSales)
            ->description('Total income from completed orders')
            ->color('success')
            ->icon('heroicon-o-cash'),
            Card::make('Pesanan yang Belum Dikirim', $unshippedOrders)
              ->description('Orders that have not been shipped yet')
              ->color('danger')
              ->icon('heroicon-o-truck'),
        ];
    }
}