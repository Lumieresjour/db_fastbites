<x-app-layout>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-25">
                        <h4 class="font-semibold text-lg text-[#FF5962]">Detail Penagihan</h4>
                    </div>
                    <form method="post" action="{{route('checkout.order')}}" id="checkoutForm">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="country" :value="'Provinsi *'" />
                        @include('livewire.countries-select')
                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="billing_address" :value="'Alamat *'" />
                        <x-text-input id="billing_address" name="billing_address" type="text"
                            class="mt-1 block w-full" value="{{$billingDetails ? $billingDetails->billing_address : ''}}" required autofocus autocomplete="billing_address" />
                        <x-input-error class="mt-2" :messages="$errors->get('billing_address')" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="city" :value="'Kota *'" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                            autofocus autocomplete="city" value="{{$billingDetails ? $billingDetails->city : ''}}"/>
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="state" :value="'Kecamatan *'" />
                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full"
                            autofocus autocomplete="state" value="{{$billingDetails ? $billingDetails->state : ''}}"/>
                        <x-input-error class="mt-2" :messages="$errors->get('state')" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="zipcode" :value="'Kode Pos *'" />
                        <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full"
                            autofocus autocomplete="zipcode" value="{{$billingDetails ? $billingDetails->zipcode : ''}}"/>
                        <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="phone" :value="'Nomor Telepon *'" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            autofocus autocomplete="phone" value="{{$billingDetails ? $billingDetails->phone : ''}}"/>
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                    <div class="form-group mb-30">
                        <x-input-label for="order_notes" :value="'Catatan Tambahan'" />
                        <x-text-input id="order_notes" name="order_notes" type="text" class="mt-1 block w-full"
                            autofocus autocomplete="order_notes" placeholder="Catatan tambahan?" value="{{$billingDetails ? $billingDetails->order_notes : ''}}"/>
                    </div>
                    
                    {{-- Hidden input untuk cashback --}}
                    <input type="hidden" id="use_cashback_input" name="use_cashback" value="{{ $use_cashback ? '1' : '0' }}">
                    
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="order_review border-0">
                        <div class="mb-5">
                            <h3 class="my-2 text-lg font-semibold text-[#FF5962]">Pesanan Anda</h3>
                        </div>

                        {{-- Toggle Switch Cashback --}}
                        @if(Auth::check() && Auth::user()->cashback > 0)
                            <div class="flex items-center justify-between mb-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex flex-col">
                                    <label for="use_cashback" class="font-semibold text-[#FF5962] cursor-pointer">
                                        Gunakan Cashback
                                    </label>
                                    <span class="text-sm text-gray-600">
                                        Saldo: Rp{{ number_format(Auth::user()->cashback, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" id="use_cashback" 
                                        class="sr-only"
                                        {{ $use_cashback ? 'checked' : '' }}>
                                    <label for="use_cashback" class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <div class="toggle-bg w-12 h-6 bg-gray-300 rounded-full shadow-inner transition-colors duration-300 ease-in-out"></div>
                                            <div class="toggle-dot absolute w-5 h-5 bg-white rounded-full shadow-md transform transition-transform duration-300 ease-in-out top-0.5 left-0.5"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <style>
                                #use_cashback:checked + label .toggle-bg {
                                    background-color: #FF5962;
                                }
                                #use_cashback:checked + label .toggle-dot {
                                    transform: translateX(1.5rem);
                                }
                                .toggle-bg {
                                    transition: background-color 0.3s ease;
                                }
                                .toggle-dot {
                                    transition: transform 0.3s ease;
                                }
                            </style>
                        @endif

                        <div class="table-responsive order_table text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Produk</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $i)
                                        <tr>
                                            <td class="image product-thumbnail"><img src="{{ asset('storage/'.$i->model->image) }}" alt="#"></td>
                                            <td>
                                                <h5><a href="{{ route('product.details', $i->model->id) }}">{{ $i->model->name }}</a></h5>
                                                <span class="product-qty">x {{ $i->qty }}</span>
                                            </td>
                                            <td>Rp{{ number_format($i->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="product-subtotal" colspan="2">Rp{{ Cart::subtotal() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pajak</th>
                                        <td class="product-subtotal" colspan="2">Rp{{ Cart::tax() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pengiriman</th>
                                        <td colspan="2"><em>Gratis Ongkir</em></td>
                                    </tr>
                                    
                                    @php
                                        // Hitung total awal
                                        $cartTotal = (int) str_replace(['.', ','], '', Cart::total());
                                        $cashbackAmount = 0;
                                        $finalTotal = $cartTotal;
                                        
                                        // Jika cashback digunakan
                                        if($use_cashback && Auth::check() && Auth::user()->cashback > 0) {
                                            $cashbackAmount = min(Auth::user()->cashback, $cartTotal);
                                            $finalTotal = $cartTotal - $cashbackAmount;
                                        }
                                    @endphp
                                    
                                    @if($use_cashback && Auth::check() && Auth::user()->cashback > 0)
                                        <tr>
                                            <th>Potongan Cashback</th>
                                            <td colspan="2" class="text-green-600">
                                                - Rp{{ number_format($cashbackAmount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                    
                                    <tr>
                                        <th>Total</th>
                                        <td colspan="2" class="product-subtotal">
                                            <span class="font-xl text-[#FF5962] fw-900" id="finalTotal">
                                                Rp{{ number_format($finalTotal, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-block mt-30 bg-[#FF5962] text-white hover:bg-[#FF7A81] border-[#FF5962]" onclick="document.getElementById('checkoutForm').submit();">Lakukan Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleCheckbox = document.getElementById('use_cashback');
            const hiddenInput = document.getElementById('use_cashback_input');
            const finalTotalElement = document.getElementById('finalTotal');
            
            // Data untuk kalkulasi
            const cartTotal = {{ $cartTotal ?? 0 }};
            const userCashback = {{ Auth::check() ? Auth::user()->cashback : 0 }};
            
            if (toggleCheckbox) {
                toggleCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    hiddenInput.value = isChecked ? '1' : '0';
                    
                    let finalTotal = cartTotal;
                    let cashbackRow = document.querySelector('.cashback-row');
                    
                    if (isChecked && userCashback > 0) {
                        const cashbackAmount = Math.min(userCashback, cartTotal);
                        finalTotal = cartTotal - cashbackAmount;
                        
                        // Tambahkan baris cashback jika belum ada
                        if (!cashbackRow) {
                            const tbody = document.querySelector('.order_table tbody');
                            const totalRow = tbody.querySelector('tr:last-child');
                            
                            cashbackRow = document.createElement('tr');
                            cashbackRow.className = 'cashback-row';
                            cashbackRow.innerHTML = `
                                <th>Potongan Cashback</th>
                                <td colspan="2" class="text-green-600">
                                    - Rp${cashbackAmount.toLocaleString('id-ID')}
                                </td>
                            `;
                            tbody.insertBefore(cashbackRow, totalRow);
                        }
                    } else {
                        // Hapus baris cashback jika ada
                        if (cashbackRow) {
                            cashbackRow.remove();
                        }
                    }
                    
                    // Update total
                    finalTotalElement.textContent = `Rp${finalTotal.toLocaleString('id-ID')}`;
                });
            }
        });
    </script>
</x-app-layout>