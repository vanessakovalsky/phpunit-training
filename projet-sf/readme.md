# Installation du projet 

Voici les étapes à suivre pour installer l'environnement : 

* Cloner le projet dans le dossier web
* créer la BDD et l'utilisateur
* Paramètrer la connexion à la BDD dans le fichier .env
* Installer les dépendances : composer update
* Créer le schéma de la BDD : bin/console doctrine:schema:create
* Importer les données depuis la fixtures : bin/console doctrine:fixtures:load