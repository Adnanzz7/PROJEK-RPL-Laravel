<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->integer('stok_tersisa')->default(0); // Menambahkan kolom stok_tersisa
        });
    }
    
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('stok_tersisa'); // Menghapus kolom stok_tersisa jika migrasi dibatalkan
        });
    }    
};
