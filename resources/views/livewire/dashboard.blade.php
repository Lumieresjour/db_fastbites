<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Pesanan Anda</h1>

        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="text-left font-bold border-b-2">
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Nama Produk</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Tanggal Pesanan</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="px-4 py-2 flex items-center">
                            @php
                                $quantity = 0;
                            @endphp
                            @foreach ($order->orderItems as $item)
                            @php
                                $quantity += $item->quantity
                            @endphp
                                <a href="{{ route('product.details', $item->product->id) }}"><img
                                        src="{{ asset('storage/'.$item->product->image) }}" class="w-20 h-20 mr-4 rounded"></a>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                           <ul >
                            @foreach ($order->orderItems as $item)
                                <li>
                                    <a href="{{ route('product.details', $item->product->id) }}">
                                      -  {{ $item->product->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        </td>
                        <td class="px-4 py-2">{{ $order->status }}</td>
                        <td class="px-4 py-2">
                            @if($order->cashback_used > 0)
                                <div class="text-gray-500 line-through">Rp{{ number_format($order->total + $order->cashback_used, 0, ',', '.') }}</div>
                                <div class="text-[#FF5962]">Rp{{ number_format($order->total, 0, ',', '.') }}</div>
                                <div class="text-sm text-green-600">- Rp{{ number_format($order->cashback_used, 0, ',', '.') }} (Cashback)</div>
                            @else
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $order->created_at->format('F j, Y') }}</td>
                        <td class="px-4 py-2">{{ $quantity }}</td>
                        <td class="px-4 py-2">
                            <a href="{{route('invoice', $order)}}" class="bg-[#FF5962] text-white px-4 py-2 font-semibold rounded-full">
                                Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
</x-app-layout>
