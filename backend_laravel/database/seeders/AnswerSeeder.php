<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Submission;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Answer::factory()->count(2000)->create(); */

        $questions = Question::all();

        $submissions = Submission::all();

        foreach ($submissions as $submission) {

            foreach ($questions as $question) {

                $value = $this->generateAnswerValue($question);
                Answer::create([
                    'submission_id' => $submission->id,
                    'question_id' => $question->id,
                    'value' => $value
                ]);
            }

        }
    }

    private function generateAnswerValue(Question $question) {
            $faker = \Faker\Factory::create('fr_FR');

            if ($question->type === 'A') {

                switch ($question->id){

                    case 3:
                        return $faker->randomElement([
                            "Homme",
                            "Femme",
                            "Préfère ne pas répondre"
                        ]);

                    case 6:
                        return $faker->randomElement([
                            "Oculus Quest",
                            "Oculus Rift/s",
                            "HTC Vive",
                            "Windows Mixed Reality",
                            "Valve index",
                        ]);    

                    case 7: 
                        return $faker->randomElement([
                            "SteamVR",
                            "Occulus store",
                            "Viveport",
                            "Windows store",
                        ]);

                    case 8:
                        return $faker->randomElement([
                            "Occulus Quest",
                            "Occulus Go",
                            "HTC Vive Pro",
                            "PSVR",
                            "Autre",
                            "Aucun",
                        ]);
                    
                    case 10: 
                        return $faker->randomElement([
                            "regarder la TV en direct",
                            "regarder des films",
                            "travailler",
                            "jouer en solo",
                            "jouer en équipe",
                        ]);

                    default:
                        return $faker->randomElement(["Oui", "Non"]);
                        
                }

            }

            elseif ($question->type === 'B') {

                switch ($question->id) {

                    case 1:
                        return $faker->unique()->safeEmail();
                     
                    case 2:
                        return $faker->numberBetween(18, 78);    

                    case 5:
                        return $faker->randomElement([
                            "Médecin",
                            "Ingénieur",
                            "Enseignant",
                            "Avocat",
                            "Architecte",
                            "Comptable",
                            "Infirmier",
                            "Développeur de logiciels",
                            "Psychologue",
                            "Pharmacien",
                            "Artiste",
                            "Policier",
                            "Pompier",
                            "Vétérinaire",
                            "Journaliste",
                            "Chef cuisinier",
                            "Électricien",
                            "Mécanicien",
                            "Agriculteur",
                            "Designer graphique",
                            "Traducteur",
                            "Musicien",
                            "Athlète professionnel",
                            "Consultant en gestion",
                            "Scientifique de données"
                        ]);    

                    case 20:
                        return $faker->randomElement([
                            "Suivi oculaire intégré",
                            "Résolution 4K par œil",
                            "Champ de vision de 120 degrés",
                            "Audio spatial 3D",
                            "Contrôleurs sans fil avec retour haptique",
                            "Compatibilité multi-plateforme",
                            "Réglage automatique de la distance interpupillaire",
                            "Confort amélioré avec des matériaux légers",
                            "Batterie longue durée",
                            "Reconnaissance des gestes",
                            "Suivi des mouvements précis",
                            "Mode cinéma pour regarder des films en grand écran virtuel",
                            "Intégration avec les assistants vocaux",
                            "Connexion sans fil PC/VR",
                            "Résistance à l'eau et à la poussière",
                            "Options de personnalisation du casque",
                            "Mode multijoueur intégré",
                            "Support pour les lunettes",
                            "Système de refroidissement intégré",
                            "Accès à une bibliothèque de contenus VR",
                            "Contrôle parental",
                            "Suivi des expressions faciales",
                            "Options de connectivité étendues (HDMI, USB-C, etc.)",
                            "Support pour le développement de contenu utilisateur",
                            "Mises à jour logicielles régulières"
                        ]);    
                    
                    default:
                        return $faker->sentence(3);
                        
                }

            }

            return $faker->numberBetween(1, 5);
    }
}
