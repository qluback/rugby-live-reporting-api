<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api')]
class GameController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {
    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    new Serializer($normalizers, $encoders);
  }

  #[Route('/games', name: 'app_game')]
  public function index(): JsonResponse
  {
    $games = $this->em->getRepository(Game::class)->findAll();
    // dd($games);

    return $this->json($games, 200, [], ['groups' => 'getGame']);
  }
}
