<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;

use Exception;
 
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
       //save users data
       $user = Auth::user();
       $user->update($request->except('total_price'));

       //proses checkout
        $code = 'STORE-' . mt_rand(000000, 999999);
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();


        // Looping buat hitung total harga
        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->quantity * $cart->product->price;
        }

        // gara gara ini mungkin? nggak omg
        // Tambahin ongkir
        $totalPrice += $request->ongkir;

        //transaction create
        $transaction = Transaction::insertGetId([
            'users_id' => Auth::user()->id, 
            'shipping_price' => $request->ongkir,
            'total_price' => $totalPrice,
            'transaction_status' => 'PROCESS',
            'code' => $code,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'resi' => '',
            'couriers' => $request->couriers
        ]);  
        
        //transaction detail
        foreach ($carts as $cart) {
  
            TransactionDetail::create([
                'transactions_id' => $transaction,
                'products_id' => $cart->product->id, 
                'price' => $cart->product->price,
                'code' => $code,
                'quantity' => $cart->quantity,
                'product_variant_id' => $cart->product_variant_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]); 
        }

        // Delete Cart Data
        Cart::where('users_id', Auth::user()->id)
            ->delete();

        //konfigurasi midtrans
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'bank_transfer'
            ],

            'vt_web' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

