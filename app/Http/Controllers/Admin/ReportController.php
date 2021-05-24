<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

use App\Models\Transaction;

use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
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

            return $this->renderDataTable($query);
        }
        return view('pages.admin.report.index');
    }

    // kekuatan copas
    public function filter(Request $request)
    {
        $dariTanggal = date($request->dari);
        $keTanggal = date($request->ke);
        $dataFilter = Transaction::with('user')->whereBetween('created_at', [$dariTanggal . '%', $keTanggal . '%']);
        return $this->renderDataTable($dataFilter);
    }

    public function renderDataTable($query)
    {
        return DataTables::of($query)->make();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $item = Report::findOrFail($id);
        // $item->delete();

        return redirect()->route('report.index');
    }
}
