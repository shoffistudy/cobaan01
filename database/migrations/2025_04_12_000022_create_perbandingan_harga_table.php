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
        Schema::create('perbandingan_harga', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 15);
            $table->string('judul');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_pembelian_barang');
            $table->foreignId('user_id')->constrained();
            $table->timestamp('tanggal')->useCurrent();
        });

        Schema::create('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perbandingan_id')->constrained('perbandingan_harga');
            $table->foreignId('vendor_id')->constrained('vendor');
            $table->string('pic');
            $table->string('kontak_pic');
            $table->text('ketentuan_pembayaran');
        });

        Schema::create('perbandingan_harga_item_barang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perbandingan_vendor_id')->constrained(table: 'perbandingan_harga_vendor', indexName: 'perbandingan_foreign_key');
            $table->foreignId('pengajuan_barang_detail_id')->constrained(table: 'pengajuan_pembelian_barang_detail', indexName: 'pengajuan_barang_foreign_key');
            $table->string('nama_barang');
            $table->text('spesifikasi');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->boolean('pemesanan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbandingan_harga_item_barang');
        Schema::dropIfExists('perbandingan_harga_vendor');
        Schema::dropIfExists('perbandingan_harga');
    }
};
