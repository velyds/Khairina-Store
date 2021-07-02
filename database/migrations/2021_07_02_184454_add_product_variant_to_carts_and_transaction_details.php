<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductVariantToCartsAndTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('product_variant_id');
        });
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->string('product_variant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('product_variant_id');
        });
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn('product_variant_id');
        });
    }
}
