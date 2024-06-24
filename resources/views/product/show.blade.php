@extends('layouts.front')
@section('content')
    <div class="pl-200 pr-200 overflow clearfix">

        <div class="categori-menu-slider-wrapper clearfix">
            <div class="categories-menu">

                <div class="category-heading">
                    <h3> All Departments <i class="pe-7s-angle-down"></i></h3>
                </div>

                @include('_category-list')

            </div>

            <div class="menu-slider-wrapper">

                <div class="row">
                    <div class="col-md-12 col-lg-7 col-12">
                        <div class="product-details-5 pr-70">
                            <a href="{{ route('products.show', $product) }}">
                                @if (!empty($product->cover_img))
                                    <img src="{{ asset('storage/' . $product->cover_img) }}" alt="" width="539"
                                        height="590">
                                @else
                                    <img src="/assets/img/product/electro/1.jpg" alt="">
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 col-12">
                        <div class="product-details-content">
                            <h3>{{ $product->name }}</h3>
                            {{-- <div class="rating-number">
                                <div class="quick-view-rating">
                                    <i class="pe-7s-star red-star"></i>
                                    <i class="pe-7s-star red-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                                <div class="quick-view-number">
                                    <span>2 Ratting (S)</span>
                                </div>
                            </div> --}}
                            <div class="details-price">
                                <span>Rp.{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <p>{!! $product->description !!}</p>

                            <div class="quickview-plus-minus">

                                <div class="quickview-btn-cart">
                                    <a class="btn-hover-black" href="{{ route('cart.add', $product) }}">add to cart</a>
                                </div>

                            </div>
                            <a class="animate-left" title="Wishlist" href="#"
                                href="{{ route('products.show', $product) }}">{{ $product->name }}>
                                <form action="{{ route('wishlist.items.store', $product) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add to Wishlist</button>
                                </form>
                            </a>
                            {{-- <div class="product-share">
                                <ul>
                                    <li class="categories-title">Share :</li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-pinterest"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="icofont icofont-social-flikr"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>


                </div>


            </div>

        </div>
        {{-- reviews section

        @include('product._reviews') --}}
    </div>
    {{-- <div class="product-details ptb-100 pb-90">
        <div class="container">


        </div>
    </div> --}}



    <!-- related product area start -->
    {{-- @include('product._related-product') --}}
@endsection
