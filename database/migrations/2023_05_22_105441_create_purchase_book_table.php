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
        Schema::create('tbl_t_purchase_book', function (Blueprint $table) {
            $table->increments('id_ttpb');
            $table->integer('no_inv_ttpb');
            $table->string('id_ttpm');
            $table->integer('id_tmu')->nullable();
            $table->integer('total_price_ttpb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_t_purchase_book');
    }
};
