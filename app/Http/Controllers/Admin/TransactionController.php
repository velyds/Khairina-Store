<?php

namespace App\Http\Controllers\Admin;

use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Transaction::with('user');

            return Datatables::of($query)
                ->addColumn('action', function($item){
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                        type="button"
                                        data-toggle="dropdown">
                                        Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="'. route('transaction.edit', $item->id) .'">
                                                Detail
                                            </a>
                                            <form action="'. route('transaction.destroy', $item->id) .'"  method="POST">
                                                '. method_field('delete'). csrf_field().'
                                                <button type="submit" class="dropdown-item text-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div> 
                                    </div>
                                </div>
                            ';
                        })
                        ->rawColumns(['action'])
                        ->make();
                    }
            return view('pages.admin.transaction.index');
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Transaction::with(['user'])->findOrFail($id);
        $transactionDetail = TransactionDetail::with(['product'])->where(['transactions_id' => $id])->get();

        $berat = 0;
        foreach ($transactionDetail as $TD){
            $berat += $TD->product->weight * $TD->quantity;
        }

        return view('pages.admin.transaction-detail.admin-transaction-details',[
            'transactions'=> $item,
            'transactionDetail' => $transactionDetail,
            'berat' => $berat
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    //    kok ini ga kepanggil ya? bener ga wkwk ngga
    // ini methodnya ga kepanggil
    // padahal formnya udah actionnya bener mungkin ga pake item eh gatau
    $data = $request->all();

    
    $item = Transaction::findOrFail($id);
    $item->update($data);

        if ($data['transaction_status'] == "SHIPPING") {
            $TransactionDetails = TransactionDetail::where(['transactions_id' => $id])->get();
            // Update Resi
            Transaction::findOrFail($id)->update([
                'resi' => $data['resi']
            ]);

            foreach ($TransactionDetails as $TD) {
                // Update stock
                $item = Product::findOrFail($TD->products_id);
                $item->update([
                'stock' => $item->stock - $TD->quantity
                ]);
            }

            } else if ($data['transaction_status'] == "PENDING") {
            $TransactionDetails = TransactionDetail::where(['transactions_id' => $id])->get();

            foreach ($TransactionDetails as $TD) {
                $item = Product::findOrFail($TD->products_id);
                $item->update([
                'stock' => $item->stock + $TD->quantity
                ]);
            }
        }

        return redirect()->route('transaction.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Transaction::findOrFail($id);
        $item->delete();

        return redirect()->route('transaction.index');
    }
}
