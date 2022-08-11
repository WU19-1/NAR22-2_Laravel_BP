<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('purchase_headers', function (Blueprint $table) {
//            $table->uuid('id')->primary();
//            $table->unsignedInteger('staff_id');
//            $table->foreign('staff_id')->references('id')->on('users');
//            $table->dateTime('transaction_date');
//            $table->dateTime('arrived_at')->nullable();
//            $table->string('status')->nullable();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_headers');
    }
}
