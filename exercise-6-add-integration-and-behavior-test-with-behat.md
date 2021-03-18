# Exercice 6 - Tests de comportements et E2E

Cet exercice a pour objectifs : 
* D'écrire un premier test de comportement avec Behat
* Décrire un premier test E2E avec panther 


## Tests de comportement avec Behat

* Installer behat
``` 
composer require behat\behat
```
* Créer un dossier features qui contiendra nos tests.
* A l'intérieur de ce dossier on créé un fichier login.feature qui contient les scnéarios de test pour la connexion comme nous l'avons défini dans le plan de test.
* Exemple de contenu du fichier
```
Feature: Login
  In order to log
  As a user
  I need to be able to submit form on login page

  Scenario: Send Login
    Given I am in login page
    When I put 'v.david@kovalibre.com' on email field and 'symfony0520' on password field
    Then I should be redirect to /home
```
* Nous devons maintenant faire correspondre ce scénario à des fonctions de tests. Pour cela nous commençons par initialiser le contexte avec la commande
```
vendor/bin/behat --init
```
* Cela génère un fichier FeatureContext dans features/bootstrap 
* Nous pouvons maintenant déclarer les fonctions de test qui correspondent à nos morceaux de scénarios comme dans l'exemple suivant pour la condition : 
```
    /**
     * @Given I am in :arg1 page
     */
    public function iAmOnPage($arg1)
    {
        $session = $this->getSession();
        $session->visit($arg1);
        $page1contents = $session->getPage()->getHtml();
    }
```
* Pour executer les tests 
```
vendor/bin/behat 
```
* Pour plus d'information n'hésitez pas à consulter la documentation de Behat : https://docs.behat.org/en/v2.5/ 
* Il est également possible de combiner PHPUnit et Behat voir ici : https://github.com/jonathanjfshaw/phpunitbehat 

## Test E2E avec Panther
* Panther est un outil qui permet de réaliser des tests end-to-end pour symfony. Il s'appuie sur Firefox ou Chrome qu'il ouvre pour executer l'application comme le ferais n'importe quel utilisateur et est capable de prendre des captures d'écran pour montrer le résultat des différentes étapes de tests. 
* Pour l'installer : 
```
composer req symfony/panther
```
* Il est recommandé de suivre la documentation pour l'installation des drivers : https://github.com/symfony/panther
* Ensuite nous déclarons dans le dossier test une classe E2ETest.php qui contient le code suivant 
```
<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class E2eTest extends PantherTestCase
{
    public function testMyApp(): void
    {
        self::stopWebServer();
        $client = static::createPantherClient(); // Your app is automatically started using the built-in web server
        $client->request('GET', '/login');
        $client->takeScreenshot('login.png');

        // Use any PHPUnit assertion, including the ones provided by Symfony
        $this->assertPageTitleContains('Log in');
    }
}
```
* Pour executer le tests on utilise PHPUnit : 
```
vendor/bin/phpunit tests/E2ETest.php 
```
* La aussi les possibilités sont nombreuses pour ce type de tests. 

## Aller plus loin - Autres outils :
* Selenium permet aussi de faire des tests E2E : https://www.selenium.dev/ 
* JMeter permet de faire des tests de charges : https://jmeter.apache.org/ 
* Zap Proxy permet d'automatiser des tests sur la sécurités : https://www.zaproxy.org/ 