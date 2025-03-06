#!/bin/bash
set -e

# Lancement du serveur en arrière-plan
docker-entrypoint.sh apache2-foreground &

# Attente du démarrage de WordPress
sleep 20

# Vérification et installation du thème si nécessaire
if [ ! -d "/var/www/html/wp-content/themes/wordpress-cooking-theme" ]; then
    git clone https://github.com/abonnin37/wordpress-cooking-theme.git /var/www/html/wp-content/themes/wordpress-cooking-theme
    chown -R www-data:www-data /var/www/html/wp-content/themes/wordpress-cooking-theme
    wp theme activate wordpress-cooking-theme --allow-root
fi

# Attente des processus enfants
wait