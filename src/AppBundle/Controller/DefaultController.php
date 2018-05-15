<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GameEntity;
use AppBundle\Entity\MoveEntity;
use AppBundle\Model\GameModel;
use AppBundle\Service\ComputerPlayerService;
use AppBundle\Service\GameLogicService;
use AppBundle\Service\GameService;
use AppBundle\Service\MoveService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request): Response
    {
        $gameService = $this->get(GameService::class);
        $moveService = $this->get(MoveService::class);
        $gameLogicService = $this->get(GameLogicService::class);
        $computerPlayerService = $this->get(ComputerPlayerService::class);
        $move = $request->get('move');
        $entityManager = $this->getDoctrine()->getManager();
        $result = null;
        $winningCombination = [];
        $game = $entityManager->getRepository(GameEntity::class)->findOneBy(['isFinished' => false]);
        if ($move !== null) {
            if (!$game) {
                $game = $gameService->createGame();
            }
            if ($moveService->isValidMove($game, $move)) {
                $moveService->createMove($game, $move, MoveEntity::PLAYER_X_MOVE);
                $winningCombination = $gameLogicService->isWinningCombination($game, MoveEntity::PLAYER_X_MOVE);
                if (!empty($winningCombination)) {
                    $result = 'X won!';
                }
            } else {
                $gameModel = new GameModel($game);

                return $this->render('default/index.html.twig', [
                    'gameModel' => $gameModel,
                    'result' => $result,
                    'winningCombination' => $winningCombination,
                ]);
            }
            $movesCount = \count($game->getMoves());
            if ($movesCount < 8 && $movesCount % 2 && empty($winningCombination)) {
                $computerMove = $computerPlayerService->getMove($game);
                $moveService->createMove($game, $computerMove, MoveEntity::PLAYER_O_MOVE);
                $winningCombination = $gameLogicService->isWinningCombination($game, MoveEntity::PLAYER_O_MOVE);
                if (!empty($winningCombination)) {
                    $result = 'O won!';
                }
            } else {
                $game->setIsFinished(true);
                $result = 'Draw!';
            }
        } else {
            if ($game !== null) {
                $game->setIsFinished(true);
            }
            $game = $gameService->createGame();
        }

        $entityManager->flush();
        $gameModel = new GameModel($game);
        return $this->render('default/index.html.twig', [
            'gameModel' => $gameModel,
            'result' => $result,
            'winningCombination' => $winningCombination,
        ]);
    }
}
