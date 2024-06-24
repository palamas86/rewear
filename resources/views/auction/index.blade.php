@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="categori-headings" style="background-color: #2B2B2B; text-align: center">
            <h3 style="color: #F3F3F3; margin-left:10px;">Auctions</h1>
        </div>

        <div class="row">
            @foreach ($auctionItems as $item)
                <div class="custom-col-style-2 custom-col-4">
                    <div class="product-wrapper product-border mb-24" style="height: auto; width: 340px;">
                        <div class="product-img-3">
                            <a href="{{ route('auction.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                    style="height: 362px; width: 340px;">
                            </a>
                            <div class="product-action-right">
                                <a class="animate-right" href="{{ route('auction.show', $item->id) }}" title="View">
                                    <i class="pe-7s-look"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content-4 text-center">
                            <h4><a href="{{ route('auction.show', $item->id) }}">{{ $item->title }}</a></h4>

                            {{-- Display Current Bid Price --}}
                            @if ($item->bids->isNotEmpty())
                                <p>Current Bid: Rp.{{ number_format($item->bids->max('amount'), 0, ',', '.') }}</p>
                            @else
                                <p>No bids yet</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
