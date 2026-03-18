<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Relation avec la propriété
            $table->foreignId('property_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Utilisateur qui fait la demande
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Propriétaire de la propriété
            $table->foreignId('owner_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Informations sur la visite
            $table->date('visit_date');
            $table->time('visit_time');
            $table->text('message')->nullable();
            
            // Statut de la demande
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'cancelled'])
                  ->default('pending');
            
            // Contrainte unique pour éviter les doublons sur même créneau
            $table->unique(['property_id', 'visit_date', 'visit_time'], 'unique_visit_slot');
            
            // Timestamps
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['user_id', 'status']);
            $table->index(['owner_id', 'status']);
            $table->index(['visit_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};