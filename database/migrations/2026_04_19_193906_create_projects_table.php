<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('ficher')->nullable();
            $table->text('description')->nullable();
            $table->date('date_duree')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('status')->default('en cours'); // en cours, terminé, annulé
            $table->string('priorite')->default('moyenne'); // faible, moyenne, haute
            $table->decimal('budget', 12, 2)->nullable();
            $table->foreignId('client_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};