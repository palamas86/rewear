<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h1 class="cart-heading">Cart</h1>
                <div class="table-content table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>remove</th>
                                <th>store</th>
                                <th>images</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cartItems = collect($cartItems);
                            @endphp
                            @php
                                $groupedItems = $cartItems->groupBy(function ($item) {
                                    return $item['attributes']['shop_id'] ?? null;
                                });
                            @endphp

                            @foreach ($groupedItems as $shopId => $items)
                                @php
                                    $shop = \App\Shop::find($shopId);
                                @endphp
                                <tr>
                                    <td colspan="6">
                                        <p>{{ $shop ? $shop->name : 'Unknown Shop' }}</h1>
                                    </td>
                                </tr>
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="product-remove">
                                            <a href="{{ route('cart.destroy', $item['id']) }}"><i
                                                    class="pe-7s-close"></i></a>
                                        </td>
                                        <td class="product-shop">
                                            <p>{{ $shop ? $shop->name : 'Unknown Shop' }}</p>
                                        </td>
                                        <td class="product-thumbnail">
                                            <a href="{{ route('products.show', $item['id']) }}">
                                                @if (isset($item['attributes']['cover_img']))
                                                    <img src="{{ asset('storage/' . $item['attributes']['cover_img']) }}"
                                                        alt="{{ $item['name'] }}" height="100" width="100">
                                                @else
                                                    <img src="{{ asset('storage/default-image.jpg') }}"
                                                        alt="Default Image" height="100" width="100">
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product-name"><a href="#">{{ $item['name'] }}</a></td>
                                        <td class="product-price-cart">
                                            <span
                                                class="amount">Rp.{{ Cart::session(auth()->id())->get($item['id'])->getPriceSum() }}</span>
                                        </td>
                                        <td class="product-quantity">
                                            <livewire:cart-update-form :item="$item" :key="$item['id']" />
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="cart-page-total">
                    <h2>Cart totals</h2>
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($cartItems as $item)
                        <p class="subtotal-item">
                            <span class="item-name">{{ $item['name'] }}</span>
                            <span
                                class="item-price">Rp.{{ number_format(Cart::session(auth()->id())->get($item['id'])->getPriceSum(),0,',','.') }}</span>
                        </p>

                        @php
                            $subtotal += Cart::session(auth()->id())
                                ->get($item['id'])
                                ->getPriceSum();
                        @endphp
                    @endforeach
                    <p class="subtotal-item">
                        <li>Total<span>Rp.{{ number_format($subtotal, 0, ',', '.') }}</span></li>
                    </p>
                    <a href="{{ route('cart.checkout') }}">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .subtotal-item {
        margin-bottom: 10px;
        /* Atur margin bottom sesuai kebutuhan */
        font-size: 16px;
        /* Atur ukuran font sesuai kebutuhan */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .item-name {
        flex: 1;
        /* Membuat nama item menempati sebagian besar space yang tersedia */
    }

    .item-price {
        margin-left: 1px;
        /* Atur margin left agar harga terpisah dari nama item */
        white-space: nowrap;
        /* Mencegah pemisahan harga menjadi dua baris */
    }
</style>
