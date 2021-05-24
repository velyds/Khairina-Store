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

        // $cartsnya kosong bjir, lah aneh dah
        // dibawah ada foreach carts lagi tapi jalan :/

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
            'inscurance_price' => 0, 
            'shipping_price' => 0,
            'total_price' => $totalPrice,
            'transaction_status' => 'PENDING',
            'code' => $code,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);  
        
        //transaction detail
        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(00000,99999);
  
        TransactionDetail::create([
            'transactions_id' => $transaction,
            'products_id' => $cart->product->id, 
            'price' => $cart->product->price,
            'shipping_status' => 'PENDING',
            'resi' => '',
            'code' => $trx,
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
    
    public function callback(Request $request)
   {
      //set konfigurasi midtrans
      Config::$serverKey = config('services.midtrans.serverKey');
      Config::$isProduction = config('services.midtrans.isProduction');
      Config::$isSanitized = config('services.midtrans.isSanitized');
      Config::$is3ds = config('services.midtrans.is3ds');

      //instance midtrans notification
      $notification = new Notification();

      //assign ke variabel untuk memudahkan coding
      $status = $notification->transaction_status;
      $type = $notification->payment_type;
      $fraud =$notification->fraud_status;
      $order_id = $notification->order_id;

      // cari transaksi berdasarkan ID
      $transaction = Transaction::findOrFail($order_id);

      // handle notification status
      if ($status == 'capture') {
          if($type == 'credit_card'){
              if($fraud == 'challenge') {
                  $transaction->status = 'PENDING';
              }
              else {
                  $transaction->status ='SUCCESS';
              }
          }
      }

      else if($status == 'settlement'){
          $transaction->status = 'SUCCESS';
      }

      else if($status == 'pending') {
          $transaction->status = 'PENDING';
      }

      else if($status == 'deny') {
          $transaction->status = 'CANCELLED';
      }

      else if($status == 'expire') {
          $transaction->status = 'CANCELLED';
      }

      else if($status == 'cancel') {
          $transaction->status = 'CANCELLED';
      }

      //simpan transaksi
      $transaction->save();
   }
}

