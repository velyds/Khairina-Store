<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $buyTransactions = Transaction::with('detail')->where('users_id', Auth::user()->id)
                                        ->orderBy('id','desc')->get();
        
        return view('pages.dashboard-transactions',[
            'buyTransactions' => $buyTransactions
        ]);
    }
    
    public function details(Request $request, $id)
    {
        $item = Transaction::with(['user'])->findOrFail($id);
        $transactionDetail = TransactionDetail::with(['product'])->where(['transactions_id' => $id])->get();

        $berat = 0;
        foreach ($transactionDetail as $TD){
            $berat += $TD->product->weight * $TD->quantity;
        }

        return view('pages.dashboard-transactions-details',[
            'transactions'=> $item,
            'transactionDetail' => $transactionDetail,
            'berat' => $berat
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
