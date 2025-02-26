# wordpress-cooking-theme
Thème wordpress en surcouche du plugin Wordpress Recipe Maker

## Processus d'installation
### Installer Wordpress avec docker-compose.yml
Nous supposons que nous exécutons le docker-compose.yml sur un serveur avec Traefik qui comporte déjà une stack mariadb opérationnelle.
1. Sur votre base de données, assurez vous qu'une table soit dédié à votre projet et qu'un utilisateur soit configuré.
2. Remplissez les informations requises par le `.env`.
3. Positionnez vous dans le dossier d'installation de votre projet sur le serveur.
4. Copiez-y les fichiers `docker-compose.yml` et `.env`.
5. Lancer la commande `docker compose up -d`.


### Installer le plugin Wordpress Recipe Maker
TODO : <i>Faire une évolution pour l'activer via Dockerfile</i>

Changer les paramètre du plugins :
- Recipe Existence: public
- Recipe Slug: recipe
- Recipe Permalink: "link to the recipe itself"
- Comments : true (allow comments on recipe)
- Default Temperature Unit: C°
  
### Installer le thème Wordpress Cooking Thème
TODO: <i>Faire une évolution en créant un Dockerfile et en l'hébergeant sur le registry pour gagner en lisibilité. Activer automatiquement le thème.</i>

### Installer l'extension "Google Language Translator"
 - Sélectionner Français et Portugais
 - Sélectionner le Portugais du Brésil
 - Sélectionner le Français comme langue de base
 - Sélectionner la structure "sub-directory"
 - Hide language switcher
 - Hide Google Toolbar
 - Hide Google Branding
 - Hide floating translation widget
 - Enregistrer

### Configurer le site
 - Définir les permalinks à "post_name"

### Remplir la base de données avec les bonnes données
 - insérer tous ce qu'il y a dans la table wpfk_postmeta
 - insérer tout ce qu'il y a dans la table wpfk_posts
 - insérer tout ce qu'il y a dans la table wpfk_terms
 - insérer tout ce qu'il y a dans la table wpfk_term_relationships
 - insérer tout ce qu'il y a dans la table wpfk_term_taxonomy (à voir ce que c'est)
