<x-app-layout>
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        @foreach ($product->images as $img)
                                            <figure class="border-radius-10">
                                                <img src="{{ asset('storage/'.$img) }}" alt="product image">
                                            </figure>
                                        @endforeach
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails pl-15 pr-15">
                                        @foreach ($product->images as $img)
                                            <div class="border-radius-10">
                                                <img src="{{ asset('storage/'.$img) }}" alt="product image">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info">
                                    <h2 class="title-detail text-xl font-semibold pb-2">{{ $product->name }}</h2>
                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <ins><span class="text-brand" style="color: #FF5962;">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                            <ins><span class="old-price font-md ml-15">Rp{{ number_format($product->old_price, 0, ',', '.') }}</span></ins>
                                        </div>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                    <div class="short-desc mb-30">
                                        <p>{{ $product->brief_description }}</p>
                                    </div>
                                    <div class="product_sort_info font-xs mb-30">
                                        <ul>
                                            <li class="mb-10"><i class="fi-rs-crown mr-5" style="color: #FF5962;"></i> Diskon hingga 50% untuk stok makanan berlebih</li>
                                            <li class="mb-10"><i class="fi-rs-refresh mr-5" style="color: #FF5962;"></i> Ambil langsung di toko atau kirim via ojek online
                                            </li>
                                            <li><i class="fi-rs-credit-card mr-5" style="color: #FF5962;"></i> Bayar via e-wallet atau COD</li>
                                        </ul>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                    <div class="detail-extralink">
                                        <div class="product-extra-link2">
                                            <form action="{{ route('cart.add') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="button button-add-to-cart" style="background-color: #FF5962;">
                                                    Add to cart</button>
                                            </form>
                                        </div>
                                    </div>
                                    <ul class="product-meta font-xs color-grey mt-50">
                                        <li class="mb-5"><a href="#">{{ $product->SKU }}</a></li>
                                        <li class="mb-5">Tags:
                                            @foreach ($product->categories as $index => $cat)
                                                <a href="/?{{ http_build_query(array_merge(request()->query(), ['category' => $cat->slug])) }}"
                                                    el="tag" style="color: #FF5962;">{{ $cat->name }}</a>
                                                @if ($index !== count($product->categories) - 1)
                                                    ,
                                                @endif
                                            @endforeach
                                        </li>
                                        <li>Availability:
                                            @if ($product->stock_status === 'instock')
                                                <span class="in-stock text-success ml-5">{{ $product->quantity }}
                                                    Stok Tersedia!</span>
                                            @else
                                                <span class="out-stock text-danger ml-5">Stok Habis!</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description">Deskripsi</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="default-sizes">
                                        {!!$product->description!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
    
    <style>
        .text-brand {
            color: #FF5962 !important;
        }
        .primary-color {
            color: #FF5962;
        }
        .button-add-to-cart {
            background-color: #FF5962 !important;
            /* Keep original border-color */
        }
        .nav-link.active {
            color: #FF5962 !important;
            /* Keep original border color */
        }
        a:hover {
            color: #FF5962;
        }
    </style>
</x-app-layout>