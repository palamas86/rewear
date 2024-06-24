<div class="custom-col-style-2 custom-col-4">
    <div class="product-wrapper product-border mb-24">
        <div class="product-img-3">
            <a href="{{ route('products.show', $product) }}">
                @if (!empty($product->cover_img))
                    <img src="{{ asset('storage/' . $product->cover_img) }}" alt="" height="362" width="340">
                @else
                    <img src="/assets/img/product/electro/1.jpg" alt="">
                @endif
            </a>
            <div class="product-action-right">
                <a class="animate-right" href="{{ route('products.show', $product) }}" title="View">
                    <i class="pe-7s-look"></i>
                </a>
                <a class="animate-top" title="Add To Cart" href="{{ route('cart.add', $product->id) }}">
                    <i class="pe-7s-cart"></i>
                </a>

                <a class="animate-left btn" title="Add to Wishlist" href="{{ route('wishlist.items.store', $product) }}"
                    onclick="event.preventDefault(); document.getElementById('addToWishlistForm_{{ $product->id }}').submit();">
                    <i class="pe-7s-like"></i>
                </a>

                <form id="addToWishlistForm_{{ $product->id }}" action="{{ route('wishlist.items.store', $product) }}"
                    method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </div>
        <div class="product-content-4 text-center">
            {{-- <div class="product-rating-4">
                <i class="icofont icofont-star yellow"></i>
                <i class="icofont icofont-star yellow"></i>
                <i class="icofont icofont-star yellow"></i>
                <i class="icofont icofont-star yellow"></i>
                <i class="icofont icofont-star"></i>
            </div> --}}
            <h4><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></h4>
            {{-- <span>{{ $product->description }}</span> --}}
            <h5>Rp.{{ number_format($product->price, 0, ',', '.') }}</h5>
            <p>{{ $product->shop->owner->name ?? 'n/a' }}</p>
        </div>
    </div>
</div>
