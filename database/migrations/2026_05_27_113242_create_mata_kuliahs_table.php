<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk')->unique();  // Kode Mata Kuliah
            $table->string('nama_mk');
            $table->integer('sks');  // Satuan Kredit Semester
            $table->integer('semester');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Dosen pengampu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
