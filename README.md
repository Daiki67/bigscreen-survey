# Bigscreen Survey 🥽📱

> Application web de sondage d'opinion pour l'entreprise **Bigscreen**, spécialisée dans le développement de casques de réalité virtuelle.

L'application permet aux utilisateurs de répondre à un questionnaire de 20 questions sur l'utilisation des casques VR, et fournit un espace d'administration sécurisé pour la visualisation des statistiques (graphiques interactifs ApexCharts) et la gestion des réponses.

---

## 🚀 Fonctionnalités Principales

- **Questionnaire public** : Formulaire interactif à 20 questions (choix unique, texte libre, évaluation de 1 à 5).
- **Lien unique de consultation** : Génération d'une URL sécurisée à la soumission permettant au sondé de consulter ses réponses ultérieurement.
- **Espace Administration** :
  - Authentification sécurisée via Token Bearer (Laravel Sanctum).
  - Tableau de bord statistique (répartition par marque, fréquence d'utilisation, temps de jeu, types d'utilisation).
  - Consultation de la liste des questions et de l'ensemble des soumissions.
  - Déconnexion sécurisée.
- **Multi-environnement** : Prise en charge du développement local et conteneurisé via Docker (`dev`, `docker dev`, `docker prod`).

---

## 🛠️ Stack Technique

- **Frontend** : Vue 3 (Composition API / `<script setup>`), TypeScript, Vue Router 4, ApexCharts, Axios, Vite.
- **Backend** : Laravel 11/12, PHP 8.3, Laravel Sanctum, Eloquent ORM.
- **Base de données** : MySQL 8.0 / MariaDB.
- **DevOps & Orchestration** : Docker, Docker Compose, Nginx, `concurrently`.

---

## 📋 Prérequis

- **Node.js** (v18+) & **npm** (v9+)
- **PHP** (v8.2+) & **Composer** (v2+)
- **MySQL** (v8.0+)
- **Docker** & **Docker Compose** (optionnel pour les modes conteneurisés)

---

## ⚡ Démarrage Rapide (Mode `dev` unifié)

Grâce à `concurrently`, vous pouvez tout démarrer en une seule commande depuis la racine du projet :

```bash
# 1. Cloner le dépôt
git clone https://github.com/Daiki67/bigscreen-survey.git
cd bigscreen-survey

# 2. Installer les dépendances à la racine
npm install

# 3. Initialiser le backend Laravel
cd backend_laravel
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
cd ..

# 4. Initialiser le frontend Vue.js
cd frontend_vuejs
npm install
cd ..

# 5. Démarrer le projet en une seule commande !
npm run dev
```

- **Frontend Vue.js** : [http://localhost:5173](http://localhost:5173)
- **Backend API Laravel** : [http://localhost:8000/api](http://localhost:8000/api)

---

## 🐳 Démarrage avec Docker

L'application prend en charge 3 modes d'exécution distincts :

| Mode | Commande | Description |
|---|---|---|
| **Dev (Local)** | `npm run dev` | Lance Laravel et Vite en parallèle via `concurrently` sur votre machine |
| **Docker Dev** | `npm run docker:dev` | Lance MySQL, Laravel Dev et Vite Dev (avec hot reload) dans des conteneurs |
| **Docker Prod** | `npm run docker:prod` | Lance la stack complète de production (Nginx + Laravel + MySQL) |

### Mode 1 : Développement Local (`dev`)
```bash
npm run dev
```

### Mode 2 : Docker Développement (`docker dev`)
```bash
# Démarrer l'infrastructure Docker Dev
npm run docker:dev

# Arrêter les conteneurs Dev
npm run docker:dev:down
```
- **Frontend** : [http://localhost:5173](http://localhost:5173)
- **Backend API** : [http://localhost:8000/api](http://localhost:8000/api)

### Mode 3 : Docker Production (`docker prod`)
```bash
# Démarrer la stack de production conteneurisée
npm run docker:prod

# Arrêter les conteneurs Prod
npm run docker:prod:down
```
- **Application Web & API (Nginx)** : [http://localhost](http://localhost)

---

## 📜 Commandes npm à la racine

| Commande | Action |
|---|---|
| `npm run dev` | Lance le backend Laravel et le frontend Vue.js en parallèle |
| `npm run docker:dev` | Démarre les conteneurs Docker de développement avec rechargement à chaud |
| `npm run docker:dev:down` | Arrête et supprime les conteneurs Docker dev |
| `npm run docker:prod` | Démarre les conteneurs Docker de production optimisés avec Nginx |
| `npm run docker:prod:down` | Arrête et supprime les conteneurs Docker prod |
| `npm run docker:down` | Arrête l'ensemble des conteneurs Docker |

---

## 🌐 Guide de Déploiement Officiel sur un Serveur Distant (Production)

### Option A : Déploiement via Docker (Méthode Recommandée)

1. **Se connecter au serveur (VPS Linux) et cloner le dépôt** :
   ```bash
   git clone https://github.com/Daiki67/bigscreen-survey.git
   cd bigscreen-survey
   ```

2. **Configurer l'environnement** :
   ```bash
   cp .env.example .env
   # Modifier si besoin DB_PASSWORD et les variables d'environnement dans .env
   ```

3. **Lancer l'application en production** :
   ```bash
   npm run docker:prod
   ```
   *Les conteneurs vont s'initialiser, exécuter automatiquement les migrations et les seeders, et servir l'application sur le port 80.*

---

### Option B : Déploiement classique (Nginx + PHP-FPM + MySQL)

1. **Installer les paquets requis sur le serveur** :
   ```bash
   sudo apt update && sudo apt install -y nginx php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl composer mysql-server
   ```

2. **Configurer le Backend Laravel** :
   ```bash
   cd /var/www/html/backend_laravel
   composer install --no-dev --optimize-autoloader
   cp .env.example .env
   # Définir DB_DATABASE, DB_USERNAME, DB_PASSWORD dans .env
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed --force
   php artisan config:cache
   php artisan route:cache
   sudo chown -R www-data:www-data storage bootstrap/cache
   ```

3. **Compiler le Frontend Vue.js** :
   ```bash
   cd /var/www/html/frontend_vuejs
   npm install
   VITE_API_BASE_URL=/api npm run build
   ```

4. **Configurer Nginx comme Web Server & Reverse Proxy** :
   Fichier `/etc/nginx/sites-available/bigscreen` :
   ```nginx
   server {
       listen 80;
       server_name votredomaine.com;

       root /var/www/html/frontend_vuejs/dist;
       index index.html;

       location / {
           try_files $uri $uri/ /index.html;
       }

       location /api {
           proxy_pass http://127.0.0.1:8000/api;
           proxy_set_header Host $host;
           proxy_set_header X-Real-IP $remote_addr;
           proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
       }
   }
   ```

5. **Activer le site Nginx et sécuriser avec Let's Encrypt (SSL)** :
   ```bash
   sudo ln -s /etc/nginx/sites-available/bigscreen /etc/nginx/sites-enabled/
   sudo systemctl reload nginx
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d votredomaine.com
   ```

---

## 🔑 Identifiants d'Administration par Défaut

Une fois les seeders exécutés (`php artisan db:seed`), l'accès d'administration s'effectue avec :

- **URL de connexion** : `/administration/login`
- **Email** : `admin@bigscreen.fr`
- **Mot de passe** : `password`

> ⚠️ **Sécurité** : Pensez à modifier le mot de passe administrateur en environnement de production !
