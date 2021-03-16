<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Game;

// Si besoin du repository : https://symfony.com/doc/current/testing/database.html#mocking-a-doctrine-repository-in-unit-tests

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