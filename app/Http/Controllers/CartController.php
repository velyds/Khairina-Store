<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
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

     public function success()
    {
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
}
