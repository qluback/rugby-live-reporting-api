<?php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api')]
class TeamController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {
    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    new Serializer($normalizers, $encoders);
  }

  #[Route('/teams', name: 'app_get_teams')]
  public function getTeams(): JsonResponse
  {
    $teams = $this->em->getRepository(Team::class)->findAll();

    return $this->json($teams);
  }
}
