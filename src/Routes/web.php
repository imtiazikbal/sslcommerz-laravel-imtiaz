<?php

use Imtiaz\Sslcommerz\Sslcommerz;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;


// Route::get('/payment', function () {
   
//    $tran_id = uniqid();
//    $amount = 100;
//    $user_email = 'yCfJt@example.com';
//    $profile = 'Test Profile';
//    return Sslcommerz::InitiatePayment($profile, $amount, $tran_id, $user_email);
// });

// SSL Commerz
Route::get('/sslcommerz/initiate-payment', [SslCommerzPaymentController::class, 'initiatePaymentWithSSLCommerz']);
Route::get('/sslcommerz/generate-token', [SslCommerzPaymentController::class, 'generateToken']);
Route::get('/PaymentSuccess', [SslCommerzPaymentController::class, 'PaymentSuccess'])->name('ssl.success');
Route::get('/PaymentFail', [SslCommerzPaymentController::class, 'PaymentFail'])->name('ssl.fail');
Route::get('/PaymentCancel', [SslCommerzPaymentController::class, 'PaymentCancel'])->name('ssl.cancel');


