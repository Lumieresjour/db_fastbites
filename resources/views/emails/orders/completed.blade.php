<x-mail::message>
# Pesanan Anda telah selesai

Pesanan Anda #{{ $order->id }} telah dikirim.

Terima kasih atas pembelian Anda!

<a href="{{ url('/dashboard') }}" style="background-color: #FF5962; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">View Your Order</a>

Terimakasih,<br>
{{ config('app.name') }}
</x-mail::message>
