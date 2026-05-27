<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();  // Nomor Identitas Mahasiswa
            $table->string('nama');
            $table->string('email')->unique();
            $table->enum('jurusan', ['Informatika', 'Sistem Informasi', 'Teknik Komputer']);
            $table->string('angkatan');
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->timestamps();
            $table->softDeletes();  // Untuk soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
