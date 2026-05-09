<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function midtransCallback(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if(!$notification) {
            return response()->json([
                'message' => 'No Data'
            ], 404);
        }

        $validSignatureKey = hash('sha512', $notification->order_id.$notification->status_code.$notification->gross_amount.config('services.midtrans.server_key'));

        if ($notification->signature_key != $validSignatureKey) {
            return response([
                'message' => 'Invalid signature',
            ], 403);
        }

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = false;

        $statusCode = null;

        $paymentNotification = new Notification;
        $order = Order::where('code', $paymentNotification->order_id)->firstOrFail();

        if ($order->status == 'processing') {
            return response([
                'message' => 'The order has been paid before',
            ], 422);
        }

        $transaction = $paymentNotification->transaction_status;
        $type = $paymentNotification->payment_type;
        $fraud = $paymentNotification->fraud_status;

        $paymentStatus = null;
        if ($transaction == 'settlement' || $transaction == 'capture') {
            $paymentStatus = 'processing';
        } elseif ($transaction == 'pending') {
            $paymentStatus = 'pending';
        } else {
            $paymentStatus = 'cancelled';
        }

        if ($paymentStatus) {
            DB::transaction(
                function () use ($order, $paymentNotification, $paymentStatus) {
                    $order->status = $paymentStatus;
                    $order->save();
                }
            );
        }

        $message = 'Payment status is : '.$paymentStatus;

        $response = [
            'code' => 200,
            'message' => $message,
        ];

        return response($response, 200);
    }
}
