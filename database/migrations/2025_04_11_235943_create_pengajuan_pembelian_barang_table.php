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
        Schema::create('pengajuan_pembelian_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 15);
            $table->string('nama_pengajuan');
            $table->text('keterangan');
            $table->boolean('batal')->default(0);
            $table->text('keterangan_batal')->nullable();
            $table->timestamp('tanggal_batal')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('tanggal')->useCurrent();
        });

        Schema::create('pengajuan_pembelian_barang_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_pembelian_barang');
            $table->string('nama_barang');
            $table->text('spesifikasi');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->boolean('perbandingan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pembelian_barang_detail');
        Schema::dropIfExists('pengajuan_pembelian_barang');
    }
};
