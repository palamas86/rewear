@extends('layouts.front')


@section('content')
    <div class="electro-product-wrapper wrapper-padding pt-95 pb-45">
        <div class="container-fluid">
            <div class="shop-bar pb-60">
                <div class="shop-found-selector">
                    <div class="shop-found">
                        <p><span>{{ $products->total() }}</span> Products Found </p>
                    </div>

                </div>

            </div>

            <div class="top-product-style">

                <div>

                    <div id="electro1">
                        <div class="custom-row-2">

                            @foreach ($products as $product)
                                @include('product._single_product')
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
