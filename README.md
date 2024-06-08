# sslcommerz-laravel-imtiaz

```php
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider" --tag="controllers"


```php
<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Imtiaz\Sslcommerz\Sslcommerz;
use Illuminate\Support\Facades\DB;

class SslCommerzPaymentController extends Controller
{
    public function initiatePaymentWithSSLCommerz(Request $request)
    {

        DB::beginTransaction();
        try {

            // here you can configure your logic
            $tran_id = uniqid();
            $payable = 100;
            $user_email = 'yCfJt@example.com';
            $profile = 'Test Profile';
            $paymentMethod = SSLCommerz::InitiatePayment($profile, $payable, $tran_id, $user_email);

            DB::commit();
            return response()->json([
                'status' => 200,
                'data' => $paymentMethod,
                'message' => 'Payment initiated successfully',
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function PaymentSuccess(Request $request)
    {
        try {
            SSLCommerz::PaymentSuccess($request->query('tran_id'));
            return response()->json([
                'status' => 200,
                'message' => 'Payment status updated successfully.',
            ]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);

        }
    }

    public function PaymentFail(Request $request)
    {
        try {
            SSLCommerz::PaymentFail($request->query('tran_id'));
            return response()->json([
                'status' => 404,
                'message' => 'Payment Failed.',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function PaymentCancel(Request $request)
    {
        try {

            SSLCommerz::PaymentCancel($request->query('tran_id'));
            // return redirect('/Profile');
            return response()->json([
                'status' => 404,
                'message' => 'Payment Cancel.',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function PaymentIPN(Request $request)
    {
        SSLCommerz::PaymentIPN($request->input('tran_id'), $request->input('status'), $request->input('val_id'));

    }
}

```php

SSLCOMMERZ_PAYMENT_URL=https://sandbox.sslcommerz.com/gwprocess/v4/api.php
SSLCOMMERZ_STORE_ID=apple65b1ecb16ed3f
SSLCOMMERZ_STORE_PASSWORD=apple65b1ecb16ed3f@ssl
SSLCOMMERZ_IPN_URL=http://127.0.0.1:8000/api/PaymentIPN
SSLCOMMERZ_SUCCESS_URL=http://127.0.0.1:8000/PaymentSuccess
SSLCOMMERZ_CANCEL_URL=http://127.0.0.1:8000/PaymentCancel
SSLCOMMERZ_FAIL_URL=http://127.0.0.1:8000/PaymentFail


```php

// SSL Commerz
Route::get('/sslcommerz/initiate-payment', [SslCommerzPaymentController::class, 'initiatePaymentWithSSLCommerz']);
Route::get('/sslcommerz/generate-token', [SslCommerzPaymentController::class, 'generateToken']);
Route::get('/PaymentSuccess', [SslCommerzPaymentController::class, 'PaymentSuccess'])->name('ssl.success');
Route::get('/PaymentFail', [SslCommerzPaymentController::class, 'PaymentFail'])->name('ssl.fail');
Route::get('/PaymentCancel', [SslCommerzPaymentController::class, 'PaymentCancel'])->name('ssl.cancel');


