<?php

namespace App\Controller;

use App\Entity\Veille;
use App\Entity\Competence;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getRepository(Veille::class);
         $veille = $entityManager->findAll();
        $entityManager = $this->getDoctrine()->getRepository(Competence::class);
        $comp = $entityManager->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            "competences" => $comp,
            "Veille" => $veille
        ]);
    }

    /**
     * @Route("/mention", name="mention")
     */
    public function mention()
    {
        return $this->render('accueil/mention.html.twig');
    }
}
