# Exercice 1 : Mes premiers tests

Cet exercice a pour objectif : 
* d'installer phpunit
* de déclarer ses premiers tests
* d'executer ses premiers tests


## Pré-requis :

* Avoir un projet PHP Installé avec une environnement d'éxecution
* Avoir composer d'installé

## Installation de PHPUnit

* Placer vous dans le dossier de votre projet
* A l'aide de composer installer PHPUnit et ses dépendances :
```
composer require phpunit/phpunit
```
* Vérifier que l'installation c'est bien passée en lançant la commande : 
```
phpunit --version
```

## Création du premier test 

* Créer une première classe de test DemoTest.php dans le dossier tests qui va contenir une première fonction de test qui contient deux assertions : 
``` php
<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
        $this->assertTrue(false);
    }
}
```


## Exécution du test 

* Pour exécuter le test que nous venons de créé, se positionner dans la racine de notre projet et lancer la commande : 
```
bin/phpunit 
```
* Ce qui va donner le résultat suivant : 
```
PHP Warning:  Unterminated comment starting line 38 in /var/www/html/sf-babybundle-test/tests/GameTest.php on line 38
PHPUnit 8.5.14 by Sebastian Bergmann and contributors.

Testing Project Test Suite
F                                                                   1 / 1 (100%)

Time: 32 ms, Memory: 6.00 MB

There was 1 failure:

1) App\Tests\DemoTest::testSomething
Failed asserting that false is true.

/var/www/html/sf-babybundle-test/tests/DemoTest.php:13

FAILURES!
Tests: 1, Assertions: 2, Failures: 1.
```
* Le résultat se lit de la façon suivante : 
*  * un test a été executé, 
*  * il contenait deux assertions
*  * une assertions a échouée

--> Félicitations vous savez créer un test et l'éxécuter. 

## Pour aller plus loin 

* Créer une fonction qui va calculer le pourcentage de bonne réponse pour les pronostics par rapport au résultat saisi d'un match.
* Créer le test unitaire qui va tester la logique de cette fonction.

