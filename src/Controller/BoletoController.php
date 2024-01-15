<?php

namespace App\Controller;

use App\Entity\Boleto;
use App\Form\BoletoType;
use App\Repository\BoletoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boleto')]
class BoletoController extends AbstractController
{
    #[Route('/', name: 'app_boleto_index', methods: ['GET'])]
    public function index(BoletoRepository $boletoRepository): Response
    {
        return $this->render('boleto/index.html.twig', [
            'boletos' => $boletoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_boleto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $boleto = new Boleto();
        $form = $this->createForm(BoletoType::class, $boleto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($boleto);
            $entityManager->flush();

            return $this->redirectToRoute('app_boleto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('boleto/new.html.twig', [
            'boleto' => $boleto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boleto_show', methods: ['GET'])]
    public function show(Boleto $boleto): Response
    {
        return $this->render('boleto/show.html.twig', [
            'boleto' => $boleto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boleto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boleto $boleto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BoletoType::class, $boleto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_boleto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('boleto/edit.html.twig', [
            'boleto' => $boleto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boleto_delete', methods: ['POST'])]
    public function delete(Request $request, Boleto $boleto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boleto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($boleto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_boleto_index', [], Response::HTTP_SEE_OTHER);
    }
}
