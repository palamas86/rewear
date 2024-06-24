<?php
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');

Auth::routes();
Route::post('/checkout/group', [CheckoutController::class, 'groupCheckout'])->name('checkout.group');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact', 'HomeController@contact')->name('contact');


Route::get('/products/search', 'ProductController@search')->name('products.search');
Route::resource('products', 'ProductController');

Route::get('/add-to-cart/{product}', 'CartController@add')->name('cart.add')->middleware('auth');
Route::get('/cart', 'CartController@index')->name('cart.index')->middleware('auth');
Route::get('/cart/destroy/{itemId}', 'CartController@destroy')->name('cart.destroy')->middleware('auth');
Route::get('/cart/update/{itemId}', 'CartController@update')->name('cart.update')->middleware('auth');
Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout')->middleware('auth');
Route::get('/cart/apply-coupon', 'CartController@applyCoupon')->name('cart.coupon')->middleware('auth');

Route::resource('orders', 'OrderController')->only('store')->middleware('auth');

Route::resource('shops', 'ShopController')->middleware('auth');


Route::get('paypal/checkout/{order}', 'PayPalController@getExpressCheckout')->name('paypal.checkout');
Route::get('paypal/checkout-success/{order}', 'PayPalController@getExpressCheckoutSuccess')->name('paypal.success');
Route::get('paypal/checkout-cancel', 'PayPalController@cancelPage')->name('paypal.cancel');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/order/pay/{suborder}', 'SubOrderController@pay')->name('order.pay');
});


Route::group(['prefix' => 'seller', 'middleware' => 'auth', 'as' => 'seller.', 'namespace' => 'Seller'], function () {

    Route::redirect('/', 'seller/orders');

    Route::resource('/orders', 'OrderController');

    Route::get('/orders/delivered/{suborder}', 'OrderController@markDelivered')->name('order.delivered');
});

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');

    Route::post('/wishlist/items/{product}', [WishlistItemController::class, 'store'])->name('wishlist.items.store');
    Route::delete('/wishlist/items/{wishlistItem}', [WishlistItemController::class, 'destroy'])->name('wishlist.items.destroy');
});
Route::post('/checkout/group', [CheckoutController::class, 'groupCheckout'])->name('checkout.group');
// routes/web.php

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

Route::put('/profile/update', 'ProfileController@update')->name('profile.update');
Route::get('/auction', [AuctionController::class, 'index'])->name('auction.index');
Route::get('/auction/{id}', [AuctionController::class, 'show'])->name('auction.show');

Route::post('/bids', [BidController::class, 'store'])->name('bids.store');





Route::get('/auction/{id}/checkout', [AuctionController::class, 'checkoutAuction'])->name('checkoutauction');

Route::post('/auction/{id}/process-payment', [AuctionController::class, 'processPayment'])->name('auction.processPayment');

