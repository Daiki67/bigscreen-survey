<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour la création de la table 'questions'
// Cette table stocke toutes les questions du sondage
return new class extends Migration
{
    /**
     * Exécute la migration : création de la table 'questions'.
     * Champs :
     *   - id (bigint, auto-incrément) : Identifiant unique de la question (clé primaire)
     *   - title (string)              : Titre de la question
     *   - body (string)               : Corps/texte de la question
     *   - type (enum)                 : Type de la question ('A', 'B', 'C')
     *   - options (json, nullable)    : Options de réponse possibles (tableau ou null)
     *   - created_at/updated_at       : Dates de création et de mise à jour
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // bigint, clé primaire
            $table->string('title'); // Titre de la question
            $table->string('body'); // Corps/texte de la question
            $table->enum('type', ['A', 'B', 'C']); // Type de la question
            $table->json('options')->nullable(); // Options de réponse (JSON ou null)
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Annule la migration : supprime la table 'questions'.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
