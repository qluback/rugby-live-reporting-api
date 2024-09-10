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
use Symfony\Component\Serializer\SerializerInterface;

class TeamController extends AbstractController
{
  public function __construct(private EntityManagerInterface $em) {
    $encoders = [new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    new Serializer($normalizers, $encoders);
  }

  #[Route('/teams', name: 'app_team')]
  public function index(): JsonResponse
  {
    $teams = $this->em->getRepository(Team::class)->findAll();
    // $data = $this->serializer->serialize($teams, JsonEncoder::FORMAT);

    return $this->json($teams);
  }
}
