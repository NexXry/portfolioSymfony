<?php

namespace App\Controller;

use App\Entity\Veille;
use App\Form\VeilleType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VeileController extends AbstractController
{
    /**
     * @Route("/veille", name="veille")
     */
    public function index()
    {
	    $entityManager = $this->getDoctrine()->getRepository(Veille::class);
	    $articles = $entityManager->findAll();

        return $this->render('veile/index.html.twig', [
            'controller_name' => 'VeileController',
	        'articles' => $articles
        ]);
    }

	/**
	 * @Route("/veille/new", name="veile_add")
	 * @param Request $request
	 * @param ObjectManager $manager
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
	 */
	public function newArticle (Request $request)
	{
		$article = new Veille();
		$form = $this->createForm(VeilleType::class,$article);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($article);
			$entityManager->flush();

			return $this->redirectToRoute('veille');
		}

		return $this->render('veile/new.html.twig', [
			'controller_name' => 'VeileController',
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/veille/{id}", name="veille_show")
	 */
	public function show($id)
	{
		$entityManager = $this->getDoctrine()->getRepository(Veille::class);
		$count = $entityManager->findAll();
		$lenght = end($count);
		$article = $entityManager->find($id);

		return $this->render('veile/show.html.twig', [
			'controller_name' => 'VeileController',
			'article' => $article,
            "last"=> $lenght
		]);
	}

	/**
	 * @Route("/veille/del/{id}", name="veille_del")
	 */
	public function del($id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$article =$entityManager->getRepository(Veille::class)->find($id);
		$entityManager->remove($article);
		$entityManager->flush();

		return $this->redirectToRoute('veille');
	}

}
