<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `nilais` ADD COLUMN `indeks` DECIMAL(3,2) NULL AFTER `grade`");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `nilais` DROP COLUMN `indeks`");
    }
};
