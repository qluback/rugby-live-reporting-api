<?php

namespace App\Controller;

use App\Dto\CreateGameDto;
use App\Entity\Game;
use App\Form\GameType;
use App\Service\Builder\GameBuilder;
use App\Service\Builder\TeamCompetingBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class GameController extends AbstractFOSRestController
{
  public function __construct(private EntityManagerInterface $em, private LoggerInterface $logger)
  {
    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    new Serializer($normalizers, $encoders);
  }

  #[Rest\Get('/games', name: 'app_get_games', methods: 'GET')]
  public function getGames(): JsonResponse
  {
    $games = $this->em->getRepository(Game::class)->findAll();

    return $this->json($games, 200, [], ['groups' => 'getGame']);
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
        foreach ($errors as $error) {
          // dump($error->getPropertyPath() . ": " . $error->getMessage());
        }
        // $view = $this->view([
        //   'status' => 'error',
        //   'error' => $e->getMessage(),
        // ], 200);
      }
      // $this->em->flush();
      // dd($games);
      $view = $this->view([
        'status' => 'success',
        'message' => 'Game has been successfully created.'
      ], Response::HTTP_CREATED);

    } catch (EntityNotFoundException $e) {
      $view = $this->view([
        'status' => 'error',
        'statusCode' => $e->getCode(),
        'error' => [
          'message' => $e->getMessage(),
          'path' => $request->getPathInfo(),
          'timestamp' => date('Y-m-d\TH:i:s\Z', $request->server->get('REQUEST_TIME')),
        ],
      ], $e->getCode());
    }

    return $this->handleView($view);
    // return $this->json($game, 200, [], ['groups' => 'getGame']);
    // return $this->view($game);
  }

  protected function parsingErrors(FormInterface $form): array
  {
    $errors = [];

    foreach ($form->all() as $field) {
      $fieldKey = $field->getName();
      foreach ($field->getErrors(true) as $error) {
        if (array_key_exists($fieldKey, $errors)) {
          $errors[$fieldKey][] = $error->getMessage();
        } else {
          $errors[$fieldKey] = [$error->getMessage()];
        }
      }
    }

    return $errors;
  }

  #[Rest\Put('/games', name: 'app_update_game')]
  public function updateGame(
    #[MapRequestPayload] CreateGameDto $createGame,
    TeamCompetingBuilder $teamCompetingBuilder,
    GameBuilder $gameBuilder
  ): JsonResponse {
    $teamCompetingHome = $teamCompetingBuilder->createTeamCompeting(
      $createGame->teamHome
    );
    $teamCompetingVisitor = $teamCompetingBuilder->createTeamCompeting(
      $createGame->teamVisitor
    );

    $game = $gameBuilder->createGame($teamCompetingHome, $teamCompetingVisitor);

    $this->em->flush();
    // $this->$games = $this->em->getRepository(Game::class)->findAll();
    // dd($games);

    return $this->json($game, 200, [], ['groups' => 'getGame']);
  }
}
