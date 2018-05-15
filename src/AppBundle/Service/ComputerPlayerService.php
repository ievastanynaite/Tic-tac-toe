<?php

namespace AppBundle\Service;

use AppBundle\Entity\GameEntity;
use AppBundle\Model\GameModel;

class ComputerPlayerService
{
    /** @var GameLogicService */
    private $gameLogicService;

    public function __construct(GameLogicService $gameLogicService)
    {
        $this->gameLogicService = $gameLogicService;
    }

    public function getMove(GameEntity $game): int
    {
        $winningMove = $this->gameLogicService->findWinningMove($game);
        if ($winningMove !== null) {
            return $winningMove;
        }
        $blockingMove = $this->gameLogicService->findBlockingMove($game);
        if ($blockingMove !== null) {
            return $blockingMove;
        }

        return $this->getRandomMove($game);
    }

    private function getRandomMove(GameEntity $game): int
    {
        $gameModel = new GameModel($game);
        $moves = $gameModel->getAllMoves();
        $emptyMoves = [];
        foreach ($moves as $key => $move) {
            if ($move === '') {
                $emptyMoves[] = $key;
            }
        }

        return $emptyMoves[array_rand($emptyMoves, 1)];
    }
}
