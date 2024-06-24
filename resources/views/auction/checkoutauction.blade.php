@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Checkout Auction</h1>

                <div class="item-details">
                    <div class="item-image">
                        {{-- Tambahkan gambar barang yang dilelang --}}
                        <img src="{{ asset('storage/' . $auctionItem->image) }}" alt="{{ $auctionItem->title }}"
                            style="max-width: auto; height: 350px;">
                    </div>
                    <div class="item-info">
                        <h3>{{ $auctionItem->title }}</h3>
                        <ul>
                            <li><strong>Deskripsi:</strong> {{ $auctionItem->description }}</li>
                            <li><strong>Your Bid:</strong> Rp.{{ number_format($auctionItem->current_bid, 0, ',', '.') }}
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Shipping Methods --}}
                <h4>Shipping Method</h4>
                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" checked class="form-check-input shipping-method" name="shipping_method"
                            value="instant" data-price="20000">
                        Instant (Rp.20,000)
                    </label>
                </div>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input shipping-method" name="shipping_method"
                            value="same_day" data-price="15000">
                        Same Day (Rp.15,000)
                    </label>
                </div>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input shipping-method" name="shipping_method"
                            value="reguler" data-price="10000">
                        Reguler (Rp.10,000)
                    </label>
                </div>

                <div class="form-check small-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input shipping-method" name="shipping_method" value="cargo"
                            data-price="5000">
                        Cargo (Rp.5,000)
                    </label>
                </div>

                {{-- Payment Options --}}
                <h4>Payment Options</h4>

                <div class="card mb-3 payment-card">
                    <div class="card-body">
                        <h5 class="card-title">QRIS</h5>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="payment_method" value="qris">
                            <label class="form-check-label"></label>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 payment-card">
                    <div class="card-body">
                        <h5 class="card-title">Bank Transfer</h5>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="payment_method" value="bank_transfer">
                            <label class="form-check-label"></label>
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
                            <label class="form-check-label"></label>
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
                            <label class="form-check-label"></label>
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
                <div class="total-price mt-3">
                    <h4>Total: <span id="total-price">Rp.0</span></h4>
                </div>
                {{-- Form untuk proses pembayaran --}}
                <form action="{{ route('auction.processPayment', $auctionItem->id) }}" method="POST">
                    @csrf
                    {{-- Isi dengan form atau tombol yang sesuai untuk proses pembayaran --}}
                    <button type="submit" class="btn btn-primary mt-3">Process Payment</button>
                </form>

            </div>
        </div>
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
            const shippingMethods = document.querySelectorAll('.shipping-method');
            const totalPriceElement = document.getElementById('total-price');

            let currentBid = {{ $auctionItem->current_bid }};
            let shippingCost = 0;

            function calculateTotal() {
                let selectedShippingMethod = document.querySelector('input[name="shipping_method"]:checked');
                if (selectedShippingMethod) {
                    shippingCost = parseFloat(selectedShippingMethod.getAttribute('data-price'));
                } else {
                    shippingCost = 0;
                }

                let total = currentBid + shippingCost;
                totalPriceElement.textContent = 'Rp.' + total.toLocaleString('id-ID');
            }

            shippingMethods.forEach(method => {
                method.addEventListener('change', calculateTotal);
            });

            // Initial calculation on page load
            calculateTotal();

            // Handle payment method selection
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const bankTransferOptions = document.querySelectorAll('.bank-transfer-options');
            const virtualAccountOptions = document.querySelectorAll('.virtual-account-options');
            const eWalletOptions = document.querySelectorAll('.e-wallet-options');

            function handlePaymentMethodChange() {
                bankTransferOptions.forEach(option => option.style.display = 'none');
                virtualAccountOptions.forEach(option => option.style.display = 'none');
                eWalletOptions.forEach(option => option.style.display = 'none');

                const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

                if (selectedPaymentMethod === 'bank_transfer') {
                    bankTransferOptions.forEach(option => option.style.display = 'block');
                } else if (selectedPaymentMethod === 'virtual_account') {
                    virtualAccountOptions.forEach(option => option.style.display = 'block');
                } else if (selectedPaymentMethod === 'e_wallet') {
                    eWalletOptions.forEach(option => option.style.display = 'block');
                }
            }

            paymentMethods.forEach(method => {
                method.addEventListener('change', handlePaymentMethodChange);
            });

            // Initial payment method check
            handlePaymentMethodChange();
        });
    </script>
@endsection
