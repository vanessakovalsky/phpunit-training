<?php

namespace App\Tests;

use App\Entity\Game;
use App\Entity\Pronostic;
use PHPUnit\Framework\TestCase;
use App\Service\PronosticManager;
use App\Repository\GameRepository;

class PronosticManagerTest extends TestCase
{

    public $game;
    
    public $pronostic;

    public function setUp() : void
    {
        $this->game = new Game();
        $this->game->setEquipe1('Toulouse');
        $this->game->setEquipe2('Bordeaux');
        $this->pronostic = new Pronostic();
        $this->pronostic->setScore1(12);
    }

    public function testGetPronoByMatch(): void
    {
        $pronosticRepository = $this->createMock(GameRepository::class);
        $pronosticRepository->expects($this->any())
            ->method('findBonPronostic')
            ->willReturn([$this->pronostic]);

        $pronosticManager = new PronosticManager($pronosticRepository);
        $goodPronos = $pronosticManager->getPronoByMatch($this->game);

        $this->assertEquals('12',$goodPronos[0]->getScore1());
    }
}
