<?php

namespace App\Tests;

use App\Controller\GameController;
use App\Entity\Game;
use App\Entity\Pronostic;
use PHPUnit\Framework\TestCase;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// Si besoin du repository : https://symfony.com/doc/current/testing/database.html#mocking-a-doctrine-repository-in-unit-tests

class GameTest extends WebTestCase
{

    public $game;
    
    public $pronostic;

    public function setUp() : void
    {
        $this->game = new Game();
        //$this->game->setId(87);
        $this->game->setEquipe1('Toulouse');
        $this->game->setEquipe2('Bordeaux');
        $this->pronostic = new Pronostic();
        $this->pronostic->setScore1(12);
        
    }

    public function testAddGame(): void
    {
        $this->assertEquals('Toulouse',$this->game->getEquipe1());
        $this->assertEquals('Bordeaux',$this->game->getEquipe2());   

    }

    public function testShowGame()
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UtilisateurRepository::class);
        $testUser = $userRepository->findOneByEmail('v.david@kovalibre.com');

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/game/'.$this->game->getId());
        $this->assertSelectorTextContains('td', '12');
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