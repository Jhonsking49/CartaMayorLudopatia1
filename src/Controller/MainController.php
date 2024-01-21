<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\SorteoRepository;
use App\Repository\BoletoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(SorteoRepository $sorteoRepository, BoletoRepository $boletoRepository, EntityManagerInterface $entityManager): Response
    {
        $sorteosDelUsuario = [];

        if($this->getUser()){
            $sorteos = $sorteoRepository->findSorteosCerrados();
            foreach($sorteos as $sorteo){
                $sorteo->comprobarFinalizacion($boletoRepository);
                $entityManager->persist($sorteo);
                $entityManager->flush();
            }
            $sorteosDelUsuario = $sorteoRepository->findSorteosGanadosPorUsuario($this->getUser());
        
        }
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'sorteos' => $sorteosDelUsuario,
        ]);
    }
    #[Route('/error', name: 'app_main_error')]
    public function error(): Response
    {
        return $this->render('main/error.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
