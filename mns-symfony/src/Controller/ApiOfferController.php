<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/offers', name: 'api_offers_')]
final class ApiOfferController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, ): JsonResponse
    {
        $offers = $entityManager->getRepository(Offer::class)->findAll();
        $data = array_map(fn($offer) => [
            'id' => $offer->getId(),
            'title' => $offer->getTitle(),
            'description' => $offer->getCreatedAt()->format('Y-m-d H:i:s'),
        ], $offers);
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
