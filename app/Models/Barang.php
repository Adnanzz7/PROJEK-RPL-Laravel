<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'harga_barang',
        'harga_pokok',
        'jumlah_barang',
        'jumlah_barang_awal',
        'jumlah_terjual',
        'foto_barang',
        'user_id'
    ];
    
    
    // Pastikan harga pokok dan jumlah barang terjual didefinisikan
    // Di mana harga_pokok adalah biaya produksi atau pembelian barang
    public function getHargaBarangAttribute($value)
    {
        // Menambahkan pajak Rp. 1000 jika ingin dihitung
        return $value + 1000;
    }
    // Di model Barang.php
public function user()
{
    return $this->belongsTo(User::class);
}

}
