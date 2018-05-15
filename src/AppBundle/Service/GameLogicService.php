<?php

namespace AppBundle\Service;

use AppBundle\Entity\GameEntity;
use AppBundle\Entity\MoveEntity;
use AppBundle\Model\GameModel;

class GameLogicService
{
    public const WINNING_COMBINATIONS = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [6, 4, 2],
    ];

    public function isWinningCombination(GameEntity $game, string $value): array
    {
        $gameModel = new GameModel($game);
        $playerMoves = $gameModel->getPlayerMoves($value);
        foreach (self::WINNING_COMBINATIONS as $winningCombination) {
            $score = 0;
            foreach ($winningCombination as $winningItem) {
                if (\in_array($winningItem, $playerMoves, true)) {
                    ++ $score;
                }
            }
            if ($score === 3) {
                return $winningCombination;
            }
        }

        return [];
    }

    public function findBlockingMove(GameEntity $game): ?int
    {
        return $this->findTheMove($game, MoveEntity::PLAYER_X_MOVE, MoveEntity::PLAYER_O_MOVE);
    }

    public function findWinningMove(GameEntity $game): ?int
    {
        return $this->findTheMove($game, MoveEntity::PLAYER_O_MOVE, MoveEntity::PLAYER_X_MOVE);
    }

    private function findTheMove(GameEntity $game, string $moveValue1, string $moveValue2): ?int
    {
        $gameModel = new GameModel($game);
        $playerMoves = $gameModel->getPlayerMoves($moveValue1);
        foreach (self::WINNING_COMBINATIONS as $winningCombination) {
            $score = 0;
            foreach ($winningCombination as $winningItem) {
                if (\in_array($winningItem, $playerMoves, true)) {
                    ++ $score;
                }
            }
            if ($score === 2) {
                $emptyMove = $this->getTheMove($gameModel, $winningCombination, $moveValue2, $moveValue1);
                if ($emptyMove !== null) {
                    return $emptyMove;
                }
            }
        }

        return null;
    }

    private function getTheMove(GameModel $gameModel, array $winningCombination, string $moveValue1, string $moveValue2): ?int
    {
        $firstPlayerMoves = $gameModel->getPlayerMoves($moveValue1);
        foreach ($firstPlayerMoves as $firstPlayerMove) {
            if (\in_array($firstPlayerMove, $winningCombination, true)) {

                return null;
            }
        }
        $secondPlayerMoves = $gameModel->getPlayerMoves($moveValue2);
        foreach ($winningCombination as $winningItem) {
            if (!\in_array($winningItem, $secondPlayerMoves, true)) {

                return $winningItem;
            }
        }
    }
}
