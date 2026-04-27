<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Rename 'reponce' to 'response' in tickets table using raw SQL
        if (Schema::hasColumn('tickets', 'reponce')) {
            DB::statement('ALTER TABLE `tickets` CHANGE `reponce` `response` TEXT NULL');
        }

        // Rename 'reponce' to 'response' in reclamations table using raw SQL
        if (Schema::hasColumn('reclamations', 'reponce')) {
            DB::statement('ALTER TABLE `reclamations` CHANGE `reponce` `response` TEXT NULL');
        }
    }

    public function down(): void {
        // Rollback by renaming back to 'reponce'
        if (Schema::hasColumn('tickets', 'response')) {
            DB::statement('ALTER TABLE `tickets` CHANGE `response` `reponce` TEXT NULL');
        }

        if (Schema::hasColumn('reclamations', 'response')) {
            DB::statement('ALTER TABLE `reclamations` CHANGE `response` `reponce` TEXT NULL');
        }
    }
};
