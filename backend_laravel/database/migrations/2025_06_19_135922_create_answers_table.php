<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour la création de la table 'answers'
// Cette table stocke toutes les réponses aux questions du sondage
return new class extends Migration
{
    /**
     * Exécute la migration : création de la table 'answers'.
     * Champs :
     *   - id (bigint, auto-incrément)      : Identifiant unique de la réponse (clé primaire)
     *   - submission_id (bigint, foreign)  : Référence à la soumission (clé étrangère, cascade)
     *   - question_id (bigint, foreign)    : Référence à la question (clé étrangère, cascade)
     *   - value (text)                     : Valeur de la réponse (texte libre ou codé)
     *   - created_at/updated_at            : Dates de création et de mise à jour
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // bigint, clé primaire
            $table->foreignId('submission_id')
                ->constrained('submissions')
                ->onDelete('cascade'); // Clé étrangère vers submissions, suppression en cascade
            $table->foreignId('question_id')
                ->constrained('questions')
                ->onDelete('cascade'); // Clé étrangère vers questions, suppression en cascade
            $table->text('value'); // Valeur de la réponse
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Annule la migration : supprime la table 'answers'.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
