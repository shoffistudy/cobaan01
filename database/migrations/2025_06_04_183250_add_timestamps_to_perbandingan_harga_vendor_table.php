<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->timestamps(); // Ini akan menambahkan created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::table('perbandingan_harga_vendor', function (Blueprint $table) {
            $table->dropTimestamps(); // Ini untuk rollback migrasi
        });
    }
};
