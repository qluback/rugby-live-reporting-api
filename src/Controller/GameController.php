<?php

namespace App\Controller;

use App\Dto\CreateGameDto;
use App\Entity\Game;
use App\Service\Builder\GameBuilder;
use App\Service\Builder\TeamCompetingBuilder;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class GameController extends AbstractFOSRestController
{
    public function __construct(
        private EntityManagerInterface $em,
        private LoggerInterface $logger,
        private SerializerInterface $serializer
    ) {
    }

    #[Rest\Get('/games', name: 'app_get_games', methods: 'GET')]
    public function getGames(): Response
    {
        $games = $this->em->getRepository(Game::class)->findAll();

        // dd($serializer->serialize($games, 'json', ['groups' => 'getGames']));

        // return $this->json($games, 200, [], ['groups' => 'getGame']);
        $view = $this->view([
            'status' => 'success',
            'message' => 'Games have been successfully retrieved.',
            'data' => json_decode($this->serializer->serialize($games, 'json', ['groups' => 'getGames'])),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    #[Rest\Get('/games/{id}', name: 'app_get_game_by_id', methods: 'GET')]
    public function getGameById(int $id): Response
    {
        $game = $this->em->getRepository(Game::class)->find($id);

        $view = $this->view([
            'status' => 'success',
            'message' => 'Game have been successfully retrieved.',
            'data' => json_decode($this->serializer->serialize($game, 'json', ['groups' => 'getGame'])),
        ], Response::HTTP_OK);

        return $this->handleView($view);
    }

    #[Rest\Post('/games', name: 'app_create_game')]
    public function createGame(
        Request $request,
        #[MapRequestPayload] CreateGameDto $createGame,
        TeamCompetingBuilder $teamCompetingBuilder,
        GameBuilder $gameBuilder,
        ValidatorInterface $validator
    ): Response {
        try {
            $teamCompetingHome = $teamCompetingBuilder->createTeamCompeting(
                $createGame->teamHome
            );
            $teamCompetingVisitor = $teamCompetingBuilder->createTeamCompeting(
                $createGame->teamVisitor
            );
            $game = $gameBuilder->createGame($teamCompetingHome, $teamCompetingVisitor);
            $errors = $validator->validate($game);

            if (count($errors) > 0) {
                throw new \InvalidArgumentException(sprintf('%s : %s', $errors[0]->getPropertyPath(), $errors[0]->getMessage()), Response::HTTP_BAD_REQUEST);
            }

            $this->em->flush();

            $view = $this->view([
                'status' => 'success',
                'message' => 'Game has been successfully created.',
                'data' => $game,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $view = $this->view([
                'status' => 'error',
                'statusCode' => $e->getCode(),
                'error' => [
                    'message' => $e->getMessage(),
                    'path' => $request->getPathInfo(),
                    'timestamp' => date('Y-m-d\TH:i:s\Z', time()),
                ],
            ], $e->getCode());
        }

        return $this->handleView($view);
    }

    // #[Rest\Put('/games', name: 'app_update_game')]
    // public function updateGame(
    //   #[MapRequestPayload] CreateGameDto $createGame,
    //   TeamCompetingBuilder $teamCompetingBuilder,
    //   GameBuilder $gameBuilder
    // ): JsonResponse {
    //   $teamCompetingHome = $teamCompetingBuilder->createTeamCompeting(
    //     $createGame->teamHome
    //   );
    //   $teamCompetingVisitor = $teamCompetingBuilder->createTeamCompeting(
    //     $createGame->teamVisitor
    //   );

    //   $game = $gameBuilder->createGame($teamCompetingHome, $teamCompetingVisitor);

    //   $this->em->flush();

    //   return $this->json($game, 200, [], ['groups' => 'getGame']);
    // }
}
