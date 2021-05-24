<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'report.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\report $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Transaction::with('user');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => [
                            [
                                'text' => 'Pilih Bulan',
                                'action' => '
                                function() { $(`#pilihTanggal`).modal(`show`) }
                                '
                            ],
                            [
                                'extend' => 'print',
                                'text' => 'Print',
                                'className' => 'btn btn-danger',

                            ],
                            [
                                'extend' => 'excel',
                                'text' => 'Excel',
                                'className' => 'btn btn-success',

                            ],
                        ],
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'user.name' => 'user.name',
            'total_price',
            'transaction_status',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'report_' . date('YmdHis');
    }
}
