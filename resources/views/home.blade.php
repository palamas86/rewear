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
                <div class="menu-style-3 menu-hover text-center">
                    @include('_navbar')
                </div>
                <div class="slider-area">
                    @include('_slider')
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="electronic-banner-area">
        <div class="custom-row-2">
            @include('_dummy-product')
            @include('_dummy-product')
            @include('_dummy-product')
        </div>
    </div> --}}

    <div class="electro-product-wrapper wrapper-padding pt-95 pb-45">
        <div class="container-fluid">
            <div class="section-title-4 text-center mb-40">
                <h2>new items</h2>
            </div>
            <div class="top-product-style">
                <div>
                    <div id="electro1">
                        <div class="custom-row-2">
                            @foreach ($allProducts as $product)
                                @include('product._single_product')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .owl-nav .owl-prev,
        .owl-nav .owl-next {
            background-color: #000;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>

    <script>
        $(document).ready(function() {
            $(".slider-active").owlCarousel({
                items: 1,
                loop: true,
                nav: true,
                navText: ["<div class='owl-prev'>&#9664;</div>", "<div class='owl-next'>&#9654;</div>"]
            });
        });
    </script>
@endsection
