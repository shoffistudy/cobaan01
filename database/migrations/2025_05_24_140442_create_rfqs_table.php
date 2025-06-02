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
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->string('rfq_number')->unique(); // RFQ-2024-001
            $table->foreignId('pengajuan_pembelian_barang_id')
                  ->constrained('pengajuan_pembelian_barang')
                  ->onDelete('cascade');
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('deadline');
            $table->enum('status', ['dibuat', 'berlangsung', 'ditutup'])
                  ->default('dibuat');
            $table->datetime('sent_at')->nullable(); // kapan RFQ dikirim ke vendor
            $table->datetime('closed_at')->nullable(); // kapan RFQ ditutup
            $table->timestamps();
            
            // Index untuk performance
            $table->index(['status', 'created_at']);
            $table->index('pengajuan_pembelian_barang_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};