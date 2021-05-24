<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
         $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                            ->whereHas('transaction', function($transaction){
                                $transaction->where('users_id', Auth::user()->id);
                            })->orderBy('id','desc')->get();
        
        return view('pages.dashboard-transactions',[
            'buyTransactions' => $buyTransactions
        ]);
    }
    public function details(Request $request, $id)
    {
        $transactions = TransactionDetail::with(['transaction.user','product.galleries'])
                            ->findOrFail($id);

        return view('pages.dashboard-transactions-details',[
            'transactions' => $transactions
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd ($data);

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-details', $id);
    }
}
