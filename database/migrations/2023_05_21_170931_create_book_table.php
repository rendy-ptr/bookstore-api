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
        Schema::create('tbl_m_book', function (Blueprint $table) {
            $table->increments('id_tmb');
            // id_tmw belum tau kegunaan nya jadi sementara dibuat null
            $table->integer('id_tmw')->nullable();
            $table->string('name_book_tmb');
            $table->integer('price_book_tmb');
            $table->string('picture_book_tmb');
            $table->integer('stock_tmb');
            $table->tinyInteger('status_deactive_tmb')->default(0);
            $table->integer('created_by_tmb')->nullable();
            $table->integer('updated_by_tmb')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_m_book');
    }
};
