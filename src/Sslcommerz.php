<?php 
namespace Imtiaz\Sslcommerz;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Sslcommerz{
   
        public static function InitiatePayment($profile, $payable, $tran_id, $user_email)
        {
            try {               
                $response = Http::asForm()->post(config('sslcommerz.payment_url'), [
                    "store_id" => config('sslcommerz.store_id'),
                    "store_passwd" => config('sslcommerz.store_passwd'),
                    "total_amount" => $payable,
                    "currency" => "BDT",
                    "tran_id" => $tran_id,
                  "success_url" => config('sslcommerz.success_url') . '?tran_id=' . $tran_id,
                "fail_url" => config('sslcommerz.fail_url') . '?tran_id=' . $tran_id,
                "cancel_url" => config('sslcommerz.cancel_url') . '?tran_id=' . $tran_id,

                    "ipn_url" => config('sslcommerz.ipn_url'),
                    "cus_name" => $profile,
                    "cus_email" => $user_email,
                    "cus_add1" => "Dhaka",
                    "cus_add2" => "Dhaka",
                    "cus_city" => "Dhaka",
                    "cus_state" => "Dhaka",
                    "cus_postcode" => "1200",
                    "cus_country" => "Bangladesh",
                    "cus_phone" => "+8801234567890",
                    "cus_fax" =>  "+8801234567890",
                    "shipping_method" => "YES",
                    "ship_name" => "Dhaka",
                    "ship_add1" => "Dhaka",
                    "ship_add2" => "Dhaka",
                    "ship_city" => "Dhaka",
                    "ship_state" => "Dhaka",
                    "ship_country" => "Bangladesh",
                    "ship_postcode" => "1200",
                    "product_name" => "Apple Shop Product",
                    "product_category" => "Apple Shop Category",
                    "product_profile" => "Apple Shop Profile",
                    "product_amount" => $payable,
                ]);
    
                if ($response->successful()) {
                    $paymentResponse = $response->json();
                    if (isset($paymentResponse['GatewayPageURL'])) {
                       // return ['status' => 'success', 'url' => $paymentResponse['GatewayPageURL']];
                       return $paymentResponse['GatewayPageURL'];
                    } else {
                        Log::error('SSLCommerz response did not contain GatewayPageURL', ['response' => $paymentResponse]);
                        return ['status' => 'error', 'message' => 'Payment initiation failed.'];
                    }
                } else {
                    Log::error('SSLCommerz HTTP request failed', ['response' => $response->body()]);
                    return ['status' => 'error', 'message' => 'Payment initiation failed.'];
                }
            } catch (Exception $e) {
                Log::error('Exception during payment initiation', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                return ['status' => 'error', 'message' => 'An error occurred during payment initiation.'];
            }
        }
    
        public static function PaymentSuccess($tran_id)
        {
            
        
                // Additional logic for successful payment, e.g., updating inventory, sending email, etc.
                return response()->json(['message' => 'Payment status updated successfully.']);
           
        }
    
        public static function PaymentCancel($tran_id)
        {
                // Additional logic for successful payment, e.g., updating inventory, sending email, etc.
           
            return response('Payment cancel', 500);
        }
    
        public static function PaymentFail($tran_id)
        {
                // Additional logic for successful payment, e.g., updating inventory, sending email, etc.

            
            return response('Payment Fail', 404);
        }
    
        public static function PaymentIPN($tran_id, $status, $val_id)
        {
                // Additional logic for successful payment, e.g., updating inventory, sending email, etc.

            return response('Payment IPN', 200);
        }
    }
    
