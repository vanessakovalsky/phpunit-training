# Exercice 5 execution des test dans une CI

Cet exercice a pour objectif : 
* de mettre en place l'execution des tests au sein d'un pipeline de CI Gitlab
* d'ajouter la génération d'un rapport de couverture de code au pipeline

## Execution des tests dans un pipeline CI Gitlab

* Afin de pouvoir éxecuter nos tests, il est nécessaire d'avoir au préalable préparer un environnement conteneurisé pour notre application
* Puis à l'aide du fichier gitlab.ci nous pouvons définir une étape de tests qui exécute les tests comme suit : 
```
stages:
  - test

variables:
    COMPOSER_ALLOW_SUPERUSER: "1"
    COMPOSER_DISABLE_XDEBUG_WARN: "1"

.php_template: &php_definition
  tags:
    - docker
  before_script:
    - export APP_ENV=test
    - composer install --prefer-dist --ansi --no-progress --no-suggest
  script:
    - php -d zend.enable_gc=0 bin/phpunit -c ./phpunit.xml.dist --colors=never
  stage: test

test:php7.4:
  <<: *php_definition
  image: dockerhub.cwd.at/docker/php/cli-xdebug:7.4
```
* Cet chaine effectue les étape suivantes : 
* * Récupération de l'image contenant xdebug (indispensable pour les tests)
* * Définition de variables utiles pour composer 
* * Exécution de composer install pour installer l'ensemble des dépendances nécessaire au projet.
* * Execution de la commande permettant de lancer les test unitaires avec phpunit et le fichier de configuration. 

* N'hésitez pas à adapter cette configuration pour la faire correspondre à votre environnement, notamment sur le projet exemple il est nécessaire de créer le schéma de données sur la base de test et de charger les fixtures avant de lancer les tests.

## Ajout de la couverture de code sur le pipeline

* Il est nécessaire de faire un peu de configuration, se rendre dans General pipelines sur l'interface de Gitlab puis paramètrer l'élément Test coverage parsing avec la valeur suivante :
```
^\s*Lines:\s*\d+.\d+\%
```
* Il reste alors à ajouter l'option --coverage-text lors de l'appel de phpunit pour générer le rapport de couverture de code.
* Il est aussi possible dans l'interface de définir des badges dans la section Pipeline status 

Un exemple complet avec la conteneurisation (en anglais) est disponible ici : https://cwd.at/blog/2019-12-08_docker-php-symfony/
