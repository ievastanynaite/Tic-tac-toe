<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GameEntity
 *
 * @ORM\Table(name="game_entity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameEntityRepository")
 */
class GameEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFinished", type="boolean", options={"default":false})
     */
    private $isFinished = false;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MoveEntity", mappedBy="game")
     */
    private $moves;

    public function __construct()
    {
        $this->moves = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function getIsFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @return Collection|MoveEntity[]
     */
    public function getMoves(): Collection
    {
        return $this->moves;
    }

    public function addMove(MoveEntity $move): self
    {
        $this->moves[] = $move;

        return $this;
    }
}

