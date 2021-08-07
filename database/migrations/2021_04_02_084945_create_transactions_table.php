<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id');
            $table->integer('shipping_price');
            $table->integer('total_price');
            $table->string('transaction_status'); //unpaid/pending/success/failed
            $table->string('status_pay')->length(8)->nullable();
            $table->string('code');
            $table->string('couriers');
            $table->string('resi');
            

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
