<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->integer('duree')->nullable(); // in days
            $table->string('priorite')->default('moyenne');
            $table->string('status')->default('à faire'); // à faire, en cours, terminé
            $table->date('date_fin')->nullable();
            $table->text('commentaire')->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tasks'); }
};