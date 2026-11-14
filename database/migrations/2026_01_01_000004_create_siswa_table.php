<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->char('nisn', 10)->primary();
            $table->char('nis', 8)->unique();
            $table->string('nama', 35);
            $table->unsignedBigInteger('id_kelas');
            $table->text('alamat')->nullable();
            $table->string('no_telp', 13)->nullable();
            $table->unsignedBigInteger('id_spp');
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_spp')->references('id_spp')->on('spp')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
