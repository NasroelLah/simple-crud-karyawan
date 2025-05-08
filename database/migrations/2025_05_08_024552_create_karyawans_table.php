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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->nullable();
            $table->unsignedBigInteger('departemen_id')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->unique();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('jabatan')->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
