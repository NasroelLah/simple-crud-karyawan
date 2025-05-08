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
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->nullable();
            $table->string('nama')->unique()->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->onDelete('cascade');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jabatans');
    }
};
