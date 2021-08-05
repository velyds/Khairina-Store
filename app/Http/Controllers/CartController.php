<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
      /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if ($this->cekAlamat()) {
            return redirect()->route('dashboard-account')->with('alamat','Alamat belum diisi');;
        }

        $carts = Cart::with(['product.galleries','user'])
                    ->where('users_id', Auth::user()->id)
                    ->get();

        $user = Auth::user();

        $berat = 0;
        foreach ($carts as $cart){
            $produts = Product::where('id', $cart->products_id)->get();

            $beratSementara = 0;
            foreach($produts as $product) {
                $beratSementara += $product->weight;
            }

            $berat += $beratSementara * $cart->quantity;
        }

        return view('pages.cart',[
            'carts' => $carts,
            'berat' => $berat,
            'user' => $user
        ]);
    }

    public function update(Request $request, $id){
        $cart = Cart::findOrFail($id);
        $cart->update([
            'quantity' => $request->quantity
        ]);

        $carts = Cart::with(['product.galleries','user'])
                    ->where('users_id', Auth::user()->id)
                    ->get();

        $berat = 0;
        foreach ($carts as $cart){
            $produts = Product::where('id', $cart->products_id)->get();
            $beratSementara = 0;
            foreach($produts as $product) {
                $beratSementara += $product->weight;
            }

            $berat += $beratSementara * $cart->quantity;

        }

        $data = ['berat' => $berat];

        return json_encode($data);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function success(Request $request)
    {  
        $this->callback($request);
        return view('pages.success');
    }
    
     public function failed()
    {
        return view('pages.failed');
    }

    public function cekAlamat() {
        $alamat = Auth::user()->address_one;

        if (empty($alamat)) {
            return true;
        }

        return false;
    }

    public function callback(Request $request)
    {
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
}
