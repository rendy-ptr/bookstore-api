<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_t_purchase_book_detail', function (Blueprint $table) {
            $table->increments('id_ttpbd');
            $table->integer('id_ttpb');
            $table->integer('id_tmb');
            $table->integer('qty_book_ttpbd');
            $table->integer('price_book_ttpbd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_t_purchase_book_detail');
    }
};
