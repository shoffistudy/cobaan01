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
        Schema::create('rfq_vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')
                  ->constrained('rfqs')
                  ->onDelete('cascade');
            $table->foreignId('vendor_id')
                  ->constrained('vendor')
                  ->onDelete('cascade');
            $table->enum('status', ['ditawarkan', 'diterima', 'ditolak'])
                  ->default('ditawarkan');
            $table->datetime('responded_at')->nullable(); // kapan vendor merespon
            $table->text('reject_reason')->nullable(); // alasan jika ditolak
            $table->timestamps();
            
            // Unique constraint - satu vendor hanya bisa dapat satu kali per RFQ
            $table->unique(['rfq_id', 'vendor_id']);
            
            // Index untuk performance
            $table->index(['vendor_id', 'status']);
            $table->index(['rfq_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_vendors');
    }
};