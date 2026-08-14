<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name'); // Prénom
            $table->string('last_name'); // Nom
            $table->string('email')->unique(); // Email professionnel unique
            $table->string('phone')->nullable(); // Téléphone
            $table->date('hire_date'); // Date d'embauche (crucial pour le calcul des congés)
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade'); // Lien relationnel département
            $table->integer('leave_balance')->default(25); // Solde de congés annuel (norme standard)
            $table->timestamps();
        });
    }

    /**
     * Annule la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
