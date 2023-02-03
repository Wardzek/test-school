<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function create(Request $request, EntityManagerInterface $em, ArgonauteRepository $argonauteRepository): Response
    {
        //Instance argo
        $argo = new Argonaute();

        //Instance form
        $form = $this->createForm(ArgonauteType::class, $argo);
        $form->handleRequest($request);

        //Vérification et validation du formulaire, persister et enregistrer nos argo
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($argo);
            $em->flush();
        }

        $arg = $argonauteRepository->findAll();

        // Génération de la vue
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'args' => $arg
        ]);
    }
}
