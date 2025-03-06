FROM wordpress:latest

# Installation des dépendances nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    less \
    && rm -rf /var/lib/apt/lists/*

# Installation de WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Ajout du script de démarrage personnalisé
COPY entrypoint.sh /usr/local/bin/custom-entrypoint.sh
RUN chmod +x /usr/local/bin/custom-entrypoint.sh

# Définition des variables d'environnement
ENV WORDPRESS_DB_HOST=${WORDPRESS_DB_HOST} \
    WORDPRESS_DB_USER=${WORDPRESS_DB_USER} \
    WORDPRESS_DB_PASSWORD=${WORDPRESS_DB_PASSWORD} \
    WORDPRESS_DB_NAME=${WORDPRESS_DB_NAME}

# Définition du point d'entrée
ENTRYPOINT ["docker-entrypoint.sh"]

# Commande par défaut
CMD ["apache2-foreground"]