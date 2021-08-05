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
            'inscurance_price' => 0, 
            'shipping_price' => $request->ongkir,
            'total_price' => $totalPrice,
            'transaction_status' => 'PENDING',
            'code' => $code,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'resi' => '',
            'couriers' => $request->couriers
        ]);  
        
        //transaction detail
        foreach ($carts as $cart) {
            $code = 'STORE-' . mt_rand(00000,99999);
  
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

    public function getStatusMidtrans($orderId) {
        $auth = "Basic U0ItTWlkLXNlcnZlci0zbGpVdjZWSzlPZTVtQUg5N0ZKSkhsTTM=";
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/" . $orderId . "/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS =>"\n\n",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: " . $auth,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function midtranscancel()
    {
        return view('pages.midtrans.cancel');
    }

    public function midtransfinish(Request $request)
    {
        $code = $request->order_id;
        //pakai $code soalnya takut di pakai lagi kodenaya
        $db = Transaction::where('code',$code)->first();
        
        return view('pages.midtrans.status',compact('db'));   
    }
    
    public function midtransunfinish()
    {
       
        return view('pages.midtrans.gagal');
    }

    public function midtranserror()
    {
        return view('pages.midtrans.error');
    }
    
    public function callback(Request $request)
    {

        // $request = json_decode($request);
        $transaction = $request->transaction_status;
        $fraud = $request->fraud_status;

        // Storage::put('file.txt', $transaction);
        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
              // TODO Set payment status in merchant's database to 'challenge'
              
              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'FAILED',
                'transaction_status' => 'PENDING'
            ]);
            return;
              
            }else if ($fraud == 'accept') {
              // TODO Set payment status in merchant's database to 'success'
              
              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'SUCCESS',
                'transaction_status' => 'PROCCESS'
            ]);
            return;
              
            }
        }else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
              // TODO Set payment status in merchant's database to 'failure'
              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'FAILED',
                'transaction_status' => 'PENDING'
            ]);
            return;
              
            }else if ($fraud == 'accept') {
              // TODO Set payment status in merchant's database to 'failure'

              Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'CANCEL',
                'transaction_status' => 'PENDING'
            ]);
            return;
            }
        }else if ($transaction == 'deny') {
            // TODO Set payment status in merchant's database to 'failure' 

            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'FAILED',
                'transaction_status' => 'PENDING'
            ]);
            return;
              
        }else if($transaction == 'pending') {
                Transaction::where('code',$request->order_id)->update([
                    'status_pay' => 'PENDING',
                    'transaction_status' => 'PENDING'
                ]);
            return;
        }else if($transaction == 'expire') {
            
            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'EXPIRED',
                'transaction_status' => 'PENDING'
            ]);
            return;
        }else if($transaction == 'accept') {
            
            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'SUCCESS',
                'transaction_status' => 'PROCESS'
            ]);
            return;
        }else if($transaction == 'settlement') {
            Transaction::where('code',$request->order_id)->update([
                'status_pay' => 'SUCCESS',
                'transaction_status' => 'PROCESS'
            ]);
            return;
        }
        echo json_encode('berhasil');
    }

   /* public function callback(Request $request)
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
   */


}

