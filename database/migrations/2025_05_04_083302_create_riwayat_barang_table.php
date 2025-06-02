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
        Schema::create('riwayat_barang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_id'); // Relasi ke pengajuan
            $table->string('nama_barang');
            $table->string('spesifikasi');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();
            
            // Relasi dengan tabel pengajuan
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan_pembelian_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_barang');
    }
};
