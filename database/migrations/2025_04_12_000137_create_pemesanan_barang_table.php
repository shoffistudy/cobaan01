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
        Schema::create('pemesanan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 15);
            $table->foreignId('perbandingan_id')->constrained('perbandingan_harga');
            $table->foreignId('vendor_id')->constrained('vendor');
            $table->string('npwp');
            $table->string('pic');
            $table->string('kontak_pic');
            $table->boolean('batal')->default(0);
            $table->text('keterangan_batal')->nullable();
            $table->timestamp('tanggal_batal')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('tanggal')->useCurrent();
        });

        Schema::create('pemesanan_barang_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan_barang');
            $table->foreignId('perbandingan_barang_id')->constrained(table: 'perbandingan_harga_item_barang', indexName: 'perbandingan_barang_foreign_key');
            $table->string('nama_barang');
            $table->text('spesifikasi');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->boolean('penerimaan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_barang_detail');
        Schema::dropIfExists('pemesanan_barang');
    }
};
