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
        Schema::create('tbl_m_user', function (Blueprint $table) {
            $table->increments('id_tmu');
            $table->integer('nik_tmu');
            $table->string('name_tmu');
            $table->enum('role_tmu', ['admin', 'user'])->default('user');
            $table->string('username_tmu');
            $table->text('password_tmu');
            // $table->text('email_validate')->nullable();
            $table->tinyInteger('status_deactive_tmu')->default(0);
            $table->tinyInteger('status_deleted_tmu')->default(0);
            $table->integer('created_by_tmu')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_m_user');
    }
};
