<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/wishes", name="wish_")
 */
class WishController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->readAllWithCategory();
        return $this->render('wish/list.html.twig', ['wishes' => $wishes]);
    }

    /**
     * @Route("/details/{id}", name="details", requirements={"id"="\d+"})
     */
    public function details(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        return $this->render('wish/details.html.twig', ['wish' => $wish]);
    }

    /**
     * @Route("/create", name="create")
     *
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setDateCreated(new \DateTime());
            $wish->setIsPublished(true);

            $entityManager->persist($wish);
            $entityManager->flush();

            //message flash
            $this->addFlash('success', 'Idea successfully added! Good job.');

            // Pr envoyer sur la page details de la serie ajoutee
            return $this->redirectToRoute('wish_details', ['id' => $wish->getId()]);
        }

        return $this->render('wish/create.html.twig', ['wishForm' => $wishForm->createView()]);
    }
}
