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
        Schema::create('penerimaan_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 15);
            $table->foreignId('pemesanan_id')->constrained('pemesanan_barang');
            $table->date('tanggal_penerimaan');
            $table->foreignId('vendor_id')->constrained('vendor');
            $table->string('pengantar');
            $table->string('penerima');
            $table->boolean('batal')->default(0);
            $table->text('keterangan_batal')->nullable();
            $table->timestamp('tanggal_batal')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('tanggal')->useCurrent();
        });

        Schema::create('penerimaan_barang_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penerimaan_id')->constrained('penerimaan_barang');
            $table->foreignId('pemesanan_barang_detail_id')->constrained(table: 'pemesanan_barang_detail', indexName: 'pemesanan_barang_foreign_key');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->text('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barang_detail');
        Schema::dropIfExists('penerimaan_barang');
    }
};
