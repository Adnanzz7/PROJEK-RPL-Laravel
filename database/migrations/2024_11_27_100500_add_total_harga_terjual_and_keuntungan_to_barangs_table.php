<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalHargaTerjualAndKeuntunganToBarangsTable extends Migration
{
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->decimal('total_harga_terjual', 15, 2)->default(0)->after('jumlah_terjual');
            $table->decimal('keuntungan', 15, 2)->default(0)->after('total_harga_terjual');
        });
    }

    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['total_harga_terjual', 'keuntungan']);
        });
    }
}
