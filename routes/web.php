<?php

use App\Http\Controllers\OrderController;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/item-detail',  [OrderController::class, 'detail'])->name('itemDetail');
Route::get('/order', [OrderController::class, 'orderForm'])->name('order');
Route::post('/order/checkout', [OrderController::class, 'userOrderCreate'])->name('user#checkout');
Route::get('/confirmation', [OrderController::class, 'confirmationDetail'])->name('confirm#detail');
