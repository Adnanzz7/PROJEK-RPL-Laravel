<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID pembuat barang
            $table->string('nama_barang');
            $table->integer('harga_barang');
            $table->integer('jumlah_barang');
            $table->string('foto_barang');
            $table->decimal('total', 10, 2)->nullable(); // Buat nullable jika diperlukan
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
