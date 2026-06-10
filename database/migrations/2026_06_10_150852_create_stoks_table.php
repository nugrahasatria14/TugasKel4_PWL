<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->timestamps();

            // Unique bersama agar satu cabang hanya punya satu stok per barang
            $table->unique(['cabang_id', 'barang_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stoks');
    }
};