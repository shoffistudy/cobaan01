<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->enum('status_penawaran', ['penawaran', 'disetujui', 'ditolak', 'lengkap', 'berakhir'])
                ->default('penawaran')
                ->after('ketentuan_pembayaran');

            $table->timestamp('batas_waktu_penawaran')->nullable()->after('status_penawaran');
            $table->timestamp('tanggal_respon')->nullable()->after('batas_waktu_penawaran');
        });
    }

    public function down(): void
    {
        Schema::table('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->dropColumn(['status_penawaran', 'batas_waktu_penawaran', 'tanggal_respon']);
        });
    }
};
