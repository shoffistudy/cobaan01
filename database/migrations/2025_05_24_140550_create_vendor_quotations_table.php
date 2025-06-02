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
        Schema::create('vendor_quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_vendor_id')
                  ->constrained('rfq_vendors')
                  ->onDelete('cascade');
            $table->foreignId('pengajuan_pembelian_barang_detail_id')
                  ->constrained('pengajuan_pembelian_barang_detail')
                  ->onDelete('cascade');
            $table->decimal('unit_price', 15, 2); // harga per unit
            $table->decimal('total_price', 15, 2); // total harga (qty * unit_price)
            $table->text('payment_terms'); // ketentuan pembayaran
            $table->text('notes')->nullable(); // catatan tambahan
            $table->boolean('is_selected')->default(false); // apakah dipilih admin
            $table->timestamps();
            
            // Unique constraint - satu rfq_vendor hanya bisa quote satu kali per item
            $table->unique(['rfq_vendor_id', 'pengajuan_pembelian_barang_detail_id'], 'unique_quotation_per_item');
            
            // Index untuk performance
            $table->index(['rfq_vendor_id', 'is_selected']);
            $table->index('pengajuan_pembelian_barang_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_quotations');
    }
};