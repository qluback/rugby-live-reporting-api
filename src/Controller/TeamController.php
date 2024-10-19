<?php

namespace App\Controller;

use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class TeamController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {
  }

  #[Route('/teams', name: 'app_get_teams')]
  public function getTeams(): JsonResponse
  {
    $teams = $this->em->getRepository(Team::class)->findAll();

    return $this->json($teams);
  }
}
