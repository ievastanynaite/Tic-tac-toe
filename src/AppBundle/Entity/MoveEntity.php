<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameEntity
 *
 * @ORM\Table(name="move_entity")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MoveEntityRepository")
 */
class MoveEntity
{
    public const PLAYER_X_MOVE = 'x';

    public const PLAYER_O_MOVE = 'o';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\GameEntity", inversedBy="moves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;
    /**
     * @var int
     *
     * @ORM\Column(name="moveNumber", type="integer")
     */
    private $moveNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="moveValue", type="string")
     */
    private $moveValue;

    public function getId(): int
    {
        return $this->id;
    }

    public function getGame(): GameEntity
    {
        return $this->game;
    }

    public function setGame(GameEntity $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getMoveNumber(): int
    {
        return $this->moveNumber;
    }

    public function setMoveNumber(int $moveNumber): self
    {
        $this->moveNumber = $moveNumber;

        return $this;
    }

    public function getMoveValue(): string
    {
        return $this->moveValue;
    }

    public function setMoveValue(string $moveValue): self
    {
        $this->moveValue = $moveValue;

        return $this;
    }
}
