# Exercice 2 Tester avec des jeux de données

Cet exercice a pour objectifs : 
* d'utiliser les fixtures de test
* de créer un mock 

## Utilisation des fixtures

* Afin de tester la connexion de notre utilisateur, nous allons injecter un compte utilisateur en tant que fixture à une fonction de test.
* Pour cela nous créons dans le dossiers tests, un fichier nommé LoginTest.php
* Celui-ci contient deux fonctions de tests : 
*  * Une fonction setUp qui permet de créer notre fixture
*  * Une première fonction qui teste l'affichage du formulaire de connexion 
*  * Une seconde fonction qui test l'envoi des données lors de la connexion
* Voici le code :  
``` php
<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{

      public $fixtures;

    public function setUp() : void
    {
        $this->fixtures = [
            'email' => 'v.david@kovalibre.com',
            'password' => 'symfony0520'
        ];
    }
    
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

    public function testLoginSend(): void
    {
        $client = static::createClient();
        $data = $this->fixtures;
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
	    $form = $crawler->selectButton('Sign in')->form();
        $form['email']->setValue($data['email']);
        $form['password']->setValue($data['password']);
        $client->submit($form);

        $client->followRedirect();

        $this->assertSelectorTextContains('body', 'Bienvenue');
        $this->assertResponseIsSuccessful();

    }
}
```
* Exécuter le test (en vous assurant que les données correspondent bien à un utilisateur chez vous auparavant) 
* Afin d'améliorer encore la pertinence du test, que peux t'on ajouter comme assertion sur cet exemple ?

## Création d'un mock sur une entité

* Nous allons maintenant créer un mock pour simuler une entité Game 
* Pour cela nosu créons un nouveau fichier GameTest.php dans le dossier tests
* Celui-ci contient le code suivant :
``` php  
<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Game;

class GameTest extends TestCase
{

    public $game;

    public function setUp() : void
    {
        $this->game = new Game();
        $this->game->setEquipe1('Toulouse');
        $this->game->setEquipe2('Bordeaux');
    }

    public function testAddGame(): void
    {
        $this->assertEquals('Toulouse',$this->game->getEquipe1());
        $this->assertEquals('Bordeaux',$this->game->getEquipe2());        
    }

    public function testShowGame()
    {
        //Que doit t'on tester ?

    }

    /**
     *
     * @return void
     */
   public function testEditGame($game)
    {
        $this->game->setEquipe1('Nice');
        $this->assertEquals('Nice',$this->game->getEquipe1());
    }

    public function testDeleteGame()
    {
        //Que doit t'on tester ?
    }


    
}
```
* Ici nous n'avons pas crée de mock car cela n'est pas utile, il est possible de créer un mock pour remplacer par exemple le repository de l'entité (voir ici : https://symfony.com/doc/current/testing/database.html#mocking-a-doctrine-repository-in-unit-tests ). 