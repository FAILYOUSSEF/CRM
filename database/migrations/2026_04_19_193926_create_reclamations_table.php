<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->date('date')->nullable();
            $table->string('type')->default('other'); // meeting, bug, other
            $table->string('type_other')->nullable();  // custom text if type=other
            $table->text('reponce')->nullable();
            $table->string('priorite')->default('moyenne');
            $table->string('status')->default('ouvert');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('reclamations'); }
};