<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaPokokToBarangsTable extends Migration
{
    public function up()
    {
        // Menambahkan kolom baru ke tabel barangs
        Schema::table('barangs', function (Blueprint $table) {
            $table->decimal('harga_pokok', 10, 2)->default(0); // Kolom harga pokok
            $table->integer('jumlah_barang_awal')->default(0); // Kolom jumlah barang awal
            $table->integer('jumlah_terjual')->default(0); // Kolom jumlah barang terjual
        });
    }

    public function down()
    {
        // Menghapus kolom yang ditambahkan jika migrasi dibatalkan
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['harga_pokok', 'jumlah_barang_awal', 'jumlah_terjual']);
        });
    }
}
