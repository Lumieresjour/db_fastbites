<x-mail::message>
    <div style="background-color: #f7fafc; ">
        <div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 4px; overflow: hidden;">
            <div style="padding: 20px;">
                <h1 style="font-size: 24px; font-weight: bold; color: #FF5962; margin-bottom: 16px;">Terima kasih atas Pembelian Anda!</h1>
                <h3>Order: #{{$order->id}}</h3>
                <p style="color: #4a5568; margin-bottom: 16px;">
                    Kami telah menerima pesanan Anda dan sedang diproses. Anda akan segera menerima email konfirmasi dengan detail pesanan Anda.
                </p>
                <p style="color: #4a5568; margin-bottom: 16px;">
                    Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi tim dukungan kami.
                </p>
                <a href="{{ url('/dashboard') }}" style="background-color: #FF5962; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block;">View Your Order</a>
            </div>
            <div style="background-color: #f7fafc; padding: 10px; border-raduis: 10px; display: flex; justify-content: space-between; align-items: center;">
                <p style="color: #4a5568;">
                    TerimaKasih, {{$order->user->name}}<br>
                    {{ config('app.name') }}
                </p>
            </div>
            <a href="#" style="color: #FF5962; text-decoration: none;">FastBites Contact Support</a>
        </div>
    </div>
</x-mail::message>
