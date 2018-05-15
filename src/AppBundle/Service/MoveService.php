<?php

namespace AppBundle\Service;

use AppBundle\Entity\GameEntity;
use AppBundle\Entity\MoveEntity;
use Doctrine\ORM\EntityManagerInterface;

class MoveService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createMove(GameEntity $game, int $number, string $value): void
    {
        $newMove = new MoveEntity();
        $newMove->setGame($game);
        $newMove->setMoveNumber($number);
        $newMove->setMoveValue($value);
        $this->entityManager->persist($newMove);
        $game->addMove($newMove);
    }

    public function isValidMove(GameEntity $game, int $thisMove): bool
    {
        $moves = $game->getMoves();
        foreach ($moves as $move) {
            if ($move->getMoveNumber() === $thisMove) {
                return false;
            }
        }

        return true;
    }
}
