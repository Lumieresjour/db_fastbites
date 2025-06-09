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
            Card::make('Last 30 Days', 'Rp'.number_format($totalSalesLast30Days, 0, ',', '.'))
            ->description('Total sales for the last 30 days')
            ->color('success')
            ->icon('heroicon-o-currency-dollar'),
            Card::make('Total Sales', 'Rp'.number_format($totalSales, 0, ',', '.'))
            ->description('Total income from completed orders')
            ->color('success')
            ->icon('heroicon-o-currency-dollar'),
            Card::make('Unshipped Orders', $unshippedOrders)
              ->description('Orders that have not been shipped yet')
              ->color('danger')
              ->icon('heroicon-o-inbox'),
        ];
    }
}