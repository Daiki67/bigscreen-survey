# bigscreen-survey

Déploiement
Pour déployer le projet à partir du code source livré, un développeur devra suivre les étapes suivantes :

1.	Prérequis logiciels :
○	PHP (version compatible avec Laravel)
○	Composer (gestionnaire de dépendances PHP)
○	Node.js et npm (pour les dépendances front-end)
○	Serveur local (Laragon)
○	Base de données MySQL
2.	Actions à effectuer dans le terminal :
○	Cloner le dépôt Git : git clone https://github.com/Daiki67/bigscreen-survey.git
○	Naviguer dans le répertoire backend du projet : cd backend_laravel
○	Installer les dépendances Composer : composer install
○	Naviguer dans le répertoire frontend du projet : cd frontend_vuejs
○	Installer les dépendances Node.js : npm install 
○	Lancer cette commande si vous avez une vulnérabilité critique : npm audit fix
○	Créer le fichier d'environnement .env à partir de .env.example : cp .env.example .env
○	Générer la clé d'application Laravel : php artisan key:generate
○	Configurer la connexion à la base de données dans le fichier .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
○	Exécuter les migrations de la base de données pour créer les tables : php artisan migrate
○	Exécuter les seeders pour remplir la base de données avec des données initiales (questions, administrateur) : php artisan db:seed
○	Compiler les assets front-end : npm run dev (pour le développement).
○	Compiler les assets back-end : php artisan serve
3.	Autres actions nécessaires :
○	Assurer les permissions d'écriture pour les dossiers storage et bootstrap/cache.
