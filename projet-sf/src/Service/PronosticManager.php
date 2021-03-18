<?php

namespace App\Service;

use App\Repository\GameRepository;

class PronosticManager 
{
    private $gameRepository;
    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function getPronoByMatch($game)
    {
        $pronostics = $this->gameRepository->findBonPronostic($game->getId());
        return $pronostics;
    }

}