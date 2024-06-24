@extends('layouts.front')

@section('content')
    <div class="container">
        <h2>Checkout</h2>
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <form action="{{ route('orders.store') }}" method="post" id="checkout-form">
            @csrf

            @foreach ($groupedItems as $shopId => $items)
                @php
                    $shop = \App\Shop::find($shopId);
                @endphp

                <h3>{{ $shop ? $shop->name : 'Unknown Shop' }}</h3>

                @foreach ($items as $item)
                    <div class="item-details">
                        <div class="item-image">
                            <a href="{{ route('products.show', $item['id']) }}">
                                @if (isset($item['attributes']['cover_img']))
                                    <img src="{{ asset('storage/' . $item['attributes']['cover_img']) }}"
                                        alt="{{ $item['name'] }}" height="100" width="100">
                                @else
                                    <img src="{{ asset('storage/default-image.jpg') }}" alt="Default Image" height="100"
                                        width="100">
                                @endif
                            </a>
                        </div>
                        <div class="item-name">
                            <a href="{{ route('products.show', $item['id']) }}">{{ $item['name'] }}</a>
                        </div>
                        <div class="item-price">
                            <span>Rp.{{ number_format($item['price'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach

                <h4>Shipping Method</h4>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" checked class="form-check-input shipping-method"
                            name="shipping_method[{{ $shopId }}]" value="instant" data-price="20000">
                        Instant (Rp.20,000)
                    </label>
                </div>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input shipping-method"
                            name="shipping_method[{{ $shopId }}]" value="same_day" data-price="15000">
                        Same Day (Rp.15,000)
                    </label>
                </div>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input shipping-method"
                            name="shipping_method[{{ $shopId }}]" value="reguler" data-price="10000">
                        Reguler (Rp.10,000)
                    </label>
                </div>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input shipping-method"
                            name="shipping_method[{{ $shopId }}]" value="cargo" data-price="5000">
                        Cargo (Rp.5,000)
                    </label>
                </div>

                <hr>
            @endforeach

            <div class="form-group">
                <label for="shipping_fullname">Full Name</label>
                <input type="text" name="shipping_fullname" id="shipping_fullname" class="form-control"
                    value="{{ auth()->user()->name }}">
            </div>

            <div class="form-group">
                <label for="shipping_address">Full Address</label>
                <input type="text" name="shipping_address" id="shipping_address" class="form-control"
                    value="{{ old('shipping_address', auth()->user()->address) }}">
            </div>

            <div class="form-group">
                <label for="shipping_phone">Mobile</label>
                <input type="text" name="shipping_phone" id="shipping_phone" class="form-control"
                    value="{{ old('shipping_phone', auth()->user()->phone) }}">
            </div>

            <h4>Payment Options</h4>

            <div class="card mb-3 payment-card">
                <div class="card-body">
                    <h5 class="card-title">Cash on Delivery</h5>
                    <div class="form-check">
                        <input type="radio" checked class="form-check-input" name="payment_method"
                            value="cash_on_delivery">
                        <label class="form-check-label">Cash on Delivery</label>
                    </div>
                </div>
            </div>

            <div class="card mb-3 payment-card">
                <div class="card-body">
                    <h5 class="card-title">QRIS</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="payment_method" value="qris">
                        <label class="form-check-label">QRIS</label>
                    </div>
                </div>
            </div>

            <div class="card mb-3 payment-card">
                <div class="card-body">
                    <h5 class="card-title">Bank Transfer</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="payment_method" value="bank_transfer">
                        <label class="form-check-label">Bank Transfer</label>
                    </div>
                    <div class="form-check bank-transfer-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="bank_transfer_method" value="bca">
                        <label class="form-check-label">BCA</label>
                    </div>
                    <div class="form-check bank-transfer-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="bank_transfer_method" value="mandiri">
                        <label class="form-check-label">Mandiri</label>
                    </div>
                    <div class="form-check bank-transfer-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="bank_transfer_method" value="bni">
                        <label class="form-check-label">BNI</label>
                    </div>
                </div>
            </div>

            <div class="card mb-3 payment-card">
                <div class="card-body">
                    <h5 class="card-title">Virtual Account</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="payment_method" value="virtual_account">
                        <label class="form-check-label">Virtual Account</label>
                    </div>
                    <div class="form-check virtual-account-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="virtual_account_method" value="bca_va">
                        <label class="form-check-label">BCA Virtual Account</label>
                    </div>
                    <div class="form-check virtual-account-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="virtual_account_method" value="mandiri_va">
                        <label class="form-check-label">Mandiri Virtual Account</label>
                    </div>
                    <div class="form-check virtual-account-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="virtual_account_method" value="bni_va">
                        <label class="form-check-label">BNI Virtual Account</label>
                    </div>
                </div>
            </div>

            <div class="card mb-3 payment-card">
                <div class="card-body">
                    <h5 class="card-title">E-Wallet</h5>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="payment_method" value="e_wallet">
                        <label class="form-check-label">E-Wallet</label>
                    </div>
                    <div class="form-check e-wallet-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="e_wallet_method" value="gopay">
                        <label class="form-check-label">GOPAY</label>
                    </div>
                    <div class="form-check e-wallet-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="e_wallet_method" value="ovo">
                        <label class="form-check-label">OVO</label>
                    </div>
                    <div class="form-check e-wallet-options" style="display: none; margin-left: 20px;">
                        <input type="radio" class="form-check-input" name="e_wallet_method" value="dana">
                        <label class="form-check-label">DANA</label>
                    </div>
                </div>
            </div>

            <div class="total-price">
                <h4>Total: <span id="total-price">Rp.0</span></h4>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Place Order</button>
        </form>
    </div>
    <style>
        .item-details {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .item-image img {
            margin-right: 10px;
        }

        .item-name a {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .item-price {
            margin-left: auto;
            font-size: 16px;
            color: #333;
        }

        .form-check.small-check .form-check-label {
            font-size: 0.875rem;
        }

        .form-check.small-check .form-check-input {
            transform: scale(0.5);
        }

        .payment-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
        }

        .payment-card .form-check-input {
            transform: scale(0.5);
        }

        .payment-card .card-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');
            const shippingMethods = form.querySelectorAll('.shipping-method');
            const totalPriceElement = document.getElementById('total-price');
            const bankTransferRadio = form.querySelector('input[name="payment_method"][value="bank_transfer"]');
            const bankTransferOptions = form.querySelectorAll('.bank-transfer-options');
            const virtualAccountRadio = form.querySelector('input[name="payment_method"][value="virtual_account"]');
            const virtualAccountOptions = form.querySelectorAll('.virtual-account-options');
            const eWalletRadio = form.querySelector('input[name="payment_method"][value="e_wallet"]');
            const eWalletOptions = form.querySelectorAll('.e-wallet-options');
            const paymentMethods = form.querySelectorAll('input[name="payment_method"]');

            let total = 0;

            function calculateTotal() {
                let subtotal = 0;
                let shippingTotal = 0;

                @foreach ($groupedItems as $shopId => $items)
                    @foreach ($items as $item)
                        subtotal += {{ $item['price'] }};
                    @endforeach
                @endforeach

                shippingMethods.forEach(method => {
                    if (method.checked) {
                        shippingTotal += parseFloat(method.getAttribute('data-price'));
                    }
                });

                total = subtotal + shippingTotal;
                totalPriceElement.textContent = 'Rp.' + total.toLocaleString('id-ID');
            }

            shippingMethods.forEach(method => {
                method.addEventListener('change', calculateTotal);
            });

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (bankTransferRadio.checked) {
                        bankTransferOptions.forEach(option => {
                            option.style.display = 'block';
                        });
                    } else {
                        bankTransferOptions.forEach(option => {
                            option.style.display = 'none';
                        });
                    }

                    if (virtualAccountRadio.checked) {
                        virtualAccountOptions.forEach(option => {
                            option.style.display = 'block';
                        });
                    } else {
                        virtualAccountOptions.forEach(option => {
                            option.style.display = 'none';
                        });
                    }

                    if (eWalletRadio.checked) {
                        eWalletOptions.forEach(option => {
                            option.style.display = 'block';
                        });
                    } else {
                        eWalletOptions.forEach(option => {
                            option.style.display = 'none';
                        });
                    }
                });
            });

            calculateTotal(); // Initial calculation
        });
    </script>
@endsection
