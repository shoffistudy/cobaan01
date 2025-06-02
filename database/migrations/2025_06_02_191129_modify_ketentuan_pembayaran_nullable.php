<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->text('ketentuan_pembayaran')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->text('ketentuan_pembayaran')->nullable(false)->change();
        });
    }
};
