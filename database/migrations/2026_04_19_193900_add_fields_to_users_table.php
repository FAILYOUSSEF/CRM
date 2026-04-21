<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('cin')->nullable();
            $table->decimal('salaire', 10, 2)->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_embauche')->nullable();
            $table->string('rib')->nullable();
            $table->string('addresse')->nullable();
            $table->string('status')->default('active');
            $table->string('type_contrat')->nullable();
            $table->string('fichier_de_contrat')->nullable();
            $table->string('ville')->nullable();
            $table->string('type_client')->default('client'); // admin, employee, client
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone','cin','salaire','date_naissance','date_embauche',
                'rib','addresse','status','type_contrat','fichier_de_contrat',
                'ville','type_client'
            ]);
        });
    }
};