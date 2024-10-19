<?php

namespace App\Controller;

use App\Dto\CreateHighlightDto;
use App\Service\Builder\HighlightBuilder;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class HighlightController extends AbstractFOSRestController
{
    public function __construct(private EntityManagerInterface $em, private LoggerInterface $logger)
    {
    }

    // #[Rest\Get('/games', name: 'app_get_games', methods: 'GET')]
    // public function getGames(): JsonResponse
    // {
    //   $games = $this->em->getRepository(Game::class)->findAll();

    //   return $this->json($games, 200, [], ['groups' => 'getGame']);
    // }

    #[Rest\Post('/highlights', name: 'app_create_highlight')]
    public function createHighlight(
        Request $request,
        #[MapRequestPayload] CreateHighlightDto $highlightDto,
        HighlightBuilder $highlightBuilder,
        ValidatorInterface $validator
    ): Response {
        try {
            $highlight = $highlightBuilder->createHighlight($highlightDto);
            $errors = $validator->validate($highlight);

            if (count($errors) > 0) {
                throw new \InvalidArgumentException(sprintf('%s : %s', $errors[0]->getPropertyPath(), $errors[0]->getMessage()), Response::HTTP_BAD_REQUEST);
            }

            $this->em->flush();

            $view = $this->view([
                'status' => 'success',
                'message' => 'Highlight has been successfully created.',
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
}
