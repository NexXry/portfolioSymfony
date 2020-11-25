<?php

namespace App\Controller;

use App\Entity\Auth;
use App\Form\AuthType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ConnexionController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion")
     */
	public function login()
	{
		$auth = new Auth();
        $form = $this->createForm(AuthType::class,$auth);

        return $this->render('connexion/index.html.twig', [
            'form' => $form->createView(),
        ]);
	}
}
