<?php

namespace AppBundle\Model;

use AppBundle\Entity\GameEntity;
use AppBundle\Entity\MoveEntity;

class GameModel
{
    /** @var \AppBundle\Entity\GameEntity */
    private $game;

    public function __construct(GameEntity $game)
    {
        $this->game = $game;
    }

    public function getAllMoves(): array
    {
        $allMoves = array_fill(0, 9, '');
        $moves = $this->game->getMoves();
        if ($moves) {
            foreach ($moves as $move) {
                $allMoves[$move->getMoveNumber()] = $move->getMoveValue();
            }
        }

        return $allMoves;
    }

    public function getPlayerMoves(string $value): array
    {
        $moves = $this->game->getMoves();
        $playerMoves = [];
        foreach ($moves as $move) {
            if ($move->getMoveValue() === $value) {
                $playerMoves[] = $move->getMoveNumber();
            }
        }

        return $playerMoves;
    }
}
