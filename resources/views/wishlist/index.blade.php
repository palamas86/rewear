@extends('layouts.front')

@section('content')
    <div class="container">
        <h1>My Wishlist</h1>

        <div class="wishlist-items-grid">
            @if ($wishlist && $wishlist->items->count())
                @foreach ($wishlist->items as $item)
                    <div class="wishlist-item">
                        <div class="product-wrapper product-border mb-24">
                            <div class="product-info">
                                <h3>{{ $item->product->name }}</h3>

                                <span class="product-price">Price: {{ $item->product->price }}</span>
                                <img src="{{ asset('storage/' . $item->product->cover_img) }}"
                                    alt="{{ $item->product->name }}" class="product-image">
                                <form action="{{ route('wishlist.items.destroy', $item) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                                <form action="{{ route('cart.add', $item->product) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No items in wishlist.</p>
            @endif
        </div>
    </div>

    <style>
        .wishlist-items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            /* 4 columns, responsive */
            gap: 20px;
            /* spacing between items */
        }

        .wishlist-item {
            width: 100%;
        }

        .product-info {
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            text-align: center;
        }

        .product-image {
            max-width: 100%;
            height: auto;
        }

        .btn {
            margin-top: 10px;
        }
    </style>
@endsection
