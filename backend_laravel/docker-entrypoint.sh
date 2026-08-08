#!/bin/bash
set -e

echo "=== Laravel Container Startup ==="

# Copier .env.example vers .env si .env n'existe pas
if [ ! -f .env ]; then
  if [ -f .env.example ]; then
    cp .env.example .env
    echo ".env créé à partir de .env.example"
  fi
fi

# Attente de la base de données MySQL
if [ -n "$DB_HOST" ]; then
  echo "Attente de la connexion à la base de données MySQL ($DB_HOST)..."
  until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: 3306), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; do
    echo "Base de données non disponible, attente de 2 secondes..."
    sleep 2
  done
  echo "Base de données MySQL connectée avec succès !"
fi

# S'assurer que les dossiers nécessaires existent avec les bonnes permissions
mkdir -p storage/framework/views storage/framework/sessions storage/framework/cache storage/logs bootstrap/cache
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Installer les dépendances composer si le dossier vendor n'existe pas
if [ ! -d "vendor" ]; then
  echo "Installation des dépendances Composer..."
  composer install --no-interaction --prefer-dist
fi

# Générer la clé APP_KEY si elle n'est pas configurée
if [ -f .env ]; then
  if ! grep -q "^APP_KEY=base64" .env; then
    echo "Génération de la clé d'application Laravel..."
    php artisan key:generate --force
  fi
fi

# Exécuter les migrations et les seeders
echo "Exécution des migrations de base de données..."
php artisan migrate --force

echo "Remplissage de la base de données (db:seed)..."
php artisan db:seed --force || true

echo "=== Démarrage du serveur Laravel ==="
exec "$@"
