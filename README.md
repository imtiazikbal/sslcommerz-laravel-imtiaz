SSLCommerz Laravel Integration Package



sslcommerz-laravel-imtiaz is a Laravel package that provides a seamless integration with the SSLCommerz payment gateway. This package simplifies initiating payments, handling callbacks, and managing transaction statuses directly within your Laravel application.



Features
Easy integration with SSLCommerz.
Configuration via environment variables.
Pre-defined routes for handling payment callbacks.
Example controllers and methods for payment initiation and status management.


Requirements
PHP 7.3 or higher
Laravel 7.x or higher


Installation
To install the package, follow these steps:

Require the package via Composer:

Copy code
composer require imtiaz/sslcommerz-laravel-imtiaz
Publish the package assets:

This command publishes the configuration file, controllers, and routes provided by the package.


Copy code
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider"
To publish specific resources, you can use the following tags:

Controllers: --tag="controllers"
Config: --tag="config"
Routes: --tag="routes"
Example:

bash
Copy code
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider" --tag="controllers"
Configuration
After publishing the configuration file, you can find it at config/sslcommerz.php. Update the file with your SSLCommerz credentials and URLs.

Add the following environment variables to your .env file:


.env
Copy code
SSLCOMMERZ_PAYMENT_URL=https://sandbox.sslcommerz.com/gwprocess/v4/api.php
SSLCOMMERZ_STORE_ID=your_store_id
SSLCOMMERZ_STORE_PASSWORD=your_store_password
SSLCOMMERZ_IPN_URL=http://yourdomain.com/api/PaymentIPN
SSLCOMMERZ_SUCCESS_URL=http://yourdomain.com/PaymentSuccess
SSLCOMMERZ_CANCEL_URL=http://yourdomain.com/PaymentCancel
SSLCOMMERZ_FAIL_URL=http://yourdomain.com/PaymentFail
Replace your_store_id and your_store_password with your actual SSLCommerz credentials.


Usage
Controllers
The package provides a default controller SslCommerzPaymentController located in App\Http\Controllers. This controller handles the payment initiation and status responses. You can customize this controller as per your application requirements.

Routes
The package registers routes for handling payment responses. You can publish and customize these routes as needed. They are defined in the routes/mypackage-web.php file. By default, these routes are:

php
Copy code
Route::get('/sslcommerz/initiate-payment', [SslCommerzPaymentController::class, 'initiatePaymentWithSSLCommerz']);
Route::get('/sslcommerz/generate-token', [SslCommerzPaymentController::class, 'generateToken']);
Route::get('/PaymentSuccess', [SslCommerzPaymentController::class, 'PaymentSuccess'])->name('ssl.success');
Route::get('/PaymentFail', [SslCommerzPaymentController::class, 'PaymentFail'])->name('ssl.fail');
Route::get('/PaymentCancel', [SslCommerzPaymentController::class, 'PaymentCancel'])->name('ssl.cancel');
Example Controller Methods
Initiate Payment


php
Copy code
public function initiatePaymentWithSSLCommerz(Request $request)
{
    DB::beginTransaction();
    try {
        $tran_id = uniqid();
        $payable = 100; // Amount to be paid
        $user_email = 'test@example.com';
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
Handle Payment Success
php
Copy code
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
Handle Payment Failure
php
Copy code
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
Handle Payment Cancellation
php
Copy code
public function PaymentCancel(Request $request)
{
    try {
        SSLCommerz::PaymentCancel($request->query('tran_id'));
        return response()->json([
            'status' => 404,
            'message' => 'Payment Cancelled.',
        ]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
Handle Instant Payment Notification (IPN)
php
Copy code
public function PaymentIPN(Request $request)
{
    SSLCommerz::PaymentIPN($request->input('tran_id'), $request->input('status'), $request->input('val_id'));
}
Customization
Controllers: You can customize or extend the provided controller to suit your specific needs.
Routes: Modify the routes as necessary to fit into your application’s routing structure.
Configuration: Adjust the configuration settings to match your environment and SSLCommerz settings.
Publishing Assets
You can use the artisan command to publish the package’s assets into your application:

Publish all resources:

bash
Copy code
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider"
Publish only controllers:

bash
Copy code
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider" --tag="controllers"
Publish configuration file:

bash
Copy code
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider" --tag="config"
Publish routes file:

bash
Copy code
php artisan vendor:publish --provider="Imtiaz\Sslcommerz\SslcommerzServiceProvider" --tag="routes"
Testing
To ensure everything is working correctly, perform the following steps after setting up your environment:

Initiate a Payment:
Access the URL for initiating a payment and verify that the payment gateway is correctly invoked.

http
Copy code
http://yourdomain.com/sslcommerz/initiate-payment
Check Payment Status:
Simulate success, failure, and cancellation scenarios and ensure your callback routes are correctly handling these responses.

Support
For any issues or questions, please create an issue on the GitHub Issues page.

Contributing
We welcome contributions to this package. Please see CONTRIBUTING.md for details on how to contribute.

License
This package is open-sourced software licensed under the MIT license.

Acknowledgements
Special thanks to SSLCommerz for their excellent payment gateway service.

Notes for Customization
Update URLs and Names: Replace placeholders like yourdomain.com, your_store_id, your_store_password, and GitHub links with your actual values.
Include Badges: Add badges for version, downloads, and license for better presentation.
Extend and Modify: Add any additional sections that might be relevant to your users, like advanced usage, FAQ, or troubleshooting.
This documentation is designed to be placed in your GitHub repository’s README.md file, providing a clear and structured guide for users to install, configure, and use the sslcommerz-laravel-imtiaz package in their Laravel applications.





