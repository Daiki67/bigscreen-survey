<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration pour la création de la table 'submissions'
// Cette table stocke chaque soumission de réponses à un sondage
return new class extends Migration
{
    /**
     * Exécute la migration : création de la table 'submissions'.
     * Champs :
     *   - id (bigint, auto-incrément) : Identifiant unique de la soumission (clé primaire)
     *   - url_token (string, unique)  : Jeton unique permettant d'identifier la soumission
     *   - created_at/updated_at       : Dates de création et de mise à jour
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id(); // bigint, clé primaire
            $table->string('url_token')->unique(); // Jeton unique de la soumission
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Annule la migration : supprime la table 'submissions'.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
