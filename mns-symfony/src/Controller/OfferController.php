<?php

namespace App\Controller;
use App\Entity\Offer;
use App\Form\OfferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class OfferController extends AbstractController
{
    #[Route('/add-offer', name: 'add_offer')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $offer->setUser($user);
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offers');
        }
        ;

        return $this->render('offer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/offers', name: 'offers')]
    public function offers(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offers = $entityManager->getRepository(Offer::class)->findAll();
        /** @var User $user */
        $user = $this->getUser();
        $user->setRoles(['ROLE_ADMIN']);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->render('offer/list.html.twig', ['offers' => $offers]);
    }

    #[Route('/edit-offer/{id}', name: 'edit_offer')]
    #[IsGranted("ROLE_ADMIN")]
    public function editOffer(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $offer = $entityManager->getRepository(Offer::class)->find($id);
        if (!$offer) {
            return $this->redirectToRoute('offers');
        }
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $offer->setUser($user);
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offers');
        }
        ;

        return $this->render('offer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete-offer/{id}', name: 'delete_offer')]
    #[IsGranted("ROLE_ADMIN")]
    public function deleteOffers(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $offer = $entityManager->getRepository(Offer::class)->find($id);
        if (!$offer) {
            return $this->redirectToRoute('offers');
        }
        $entityManager->remove($offer);
        $entityManager->flush();
        return $this->redirectToRoute('offers');
    }
}
