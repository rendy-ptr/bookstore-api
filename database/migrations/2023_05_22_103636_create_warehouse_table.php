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
        Schema::create('tbl_m_warehouse', function (Blueprint $table) {
            $table->increments('id_tmw');
            $table->string('name_tmw');
            $table->text('description_tmw');
            $table->tinyInteger('status_deactive_tmw')->default(0);
            $table->integer('created_by_tmw')->default(0);
            $table->integer('update_by_tmw')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_m_warehouse');
    }
};
