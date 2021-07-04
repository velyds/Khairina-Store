<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
   public function index()
    {
        $transactions = Transaction::with('detail')->where('users_id', Auth::user()->id)
                                    ->orderBy('id','desc');
        
        $revenue = $transactions->get()->reduce(function ($carry, $item){
            return $carry + $item->price;
        });

        $customer = User::count();

        return view('pages.dashboard', [
            'transaction_count' => $transactions->count(),
            'transaction_data' => $transactions->get(),
            'revenue' => $revenue,
            'customer' => $customer,
        ]);
    }
    
}