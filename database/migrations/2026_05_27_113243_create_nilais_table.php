<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_kuliah_id')->constrained()->onDelete('cascade');
            $table->integer('semester');
            $table->integer('tahun_akademik');
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('grade')->nullable();  // A, B, C, D, E
            $table->timestamps();

            // Composite unique key - satu mahasiswa hanya bisa punya satu nilai per MK per semester
            $table->unique(['mahasiswa_id', 'mata_kuliah_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
