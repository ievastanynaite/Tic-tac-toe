<?php

namespace AppBundle\Service;

use AppBundle\Entity\GameEntity;
use Doctrine\ORM\EntityManagerInterface;

class GameService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createGame(): GameEntity
    {
        $game = new GameEntity();
        $this->entityManager->persist($game);

        return $game;
    }
}
