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
                            <img src="{{ asset('storage/' . $auctionItem->image) }}" class="img-fluid"
                                style="max-width: 539px; height: 590px;" alt="{{ $auctionItem->title }}">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 col-12">
                        <div class="product-details-content">
                            <h1>{{ $auctionItem->title }}</h1>
                            <p>{{ $auctionItem->description }}</p>
                            <h4>Starting Bid: Rp.{{ number_format($auctionItem->starting_bid, 0, ',', '.') }}</h4>
                            <h4>Current Bid:
                                Rp.{{ $auctionItem->current_bid ? number_format($auctionItem->current_bid, 0, ',', '.') : 'No bids yet' }}
                            </h4>
                            <h3>Auction Ends: {{ $auctionItem->auction_end->format('F j, Y, g:i a') }}</h3>

                            @auth
                                @if ($auctionEnded)
                                    @if ($isHighestBidder)
                                        {{-- Auction ended and the current user is the highest bidder --}}
                                        <form action="{{ route('checkoutauction', $auctionItem->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                                        </form>
                                    @else
                                        <p>The auction has ended. The highest bidder can add this item to their cart.</p>
                                    @endif
                                @else
                                    {{-- Auction ongoing, bid form --}}
                                    <form action="{{ route('bids.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="auction_item_id" value="{{ $auctionItem->id }}">
                                        <div class="form-group">
                                            <label for="amount">Your Bid:</label>
                                            <input type="number" name="amount" id="amount" class="form-control"
                                                min="{{ $auctionItem->current_bid ? $auctionItem->current_bid + 1 : $auctionItem->starting_bid }}"
                                                step="0.01" required>
                                        </div>
                                        <button type="submit" class="btn btn-dark btn-rounded">
                                            <h4 style="color: whitesmoke;">Place Bid</h4>
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            @guest
                                <p><a href="{{ route('login') }}">Log in</a> to place a bid.</p>
                            @endguest

                            <h3>Bidding History</h3>
                            <ul>
                                @foreach ($auctionItem->bids->sortByDesc('created_at')->take(10) as $bid)
                                    <li>{{ $bid->user->name }}:
                                        Rp.{{ number_format($bid->amount, 0, ',', '.') }}
                                        ({{ $bid->created_at->format('F j, Y, g:i a') }})
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- Debugging output
<p>Current Time: {{ now() }}</p>
<p>Auction End Time: {{ $auctionItem->auction_end }}</p>
<p>Highest Bid: {{ $auctionItem->bids()->max('amount') }}</p>
<p>Highest Bidder User ID:
    {{ $auctionItem->bids()->where('amount', $auctionItem->bids()->max('amount'))->first()->user_id ?? 'No bids' }}</p>
<p>Authenticated User ID: {{ Auth::id() }}</p>
<p>Auction Ended: {{ $auctionItem->auction_end < now() ? 'Yes' : 'No' }}</p>
<p>Is Highest Bidder:
    {{ Auth::id() == $auctionItem->bids()->where('amount', $auctionItem->bids()->max('amount'))->first()->user_id ?? false ? 'Yes' : 'No' }}
</p> --}}
