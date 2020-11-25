<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetenceController extends AbstractController
{
    /**
     * @Route("/competence", name="compétences")
     */
    public function index()
    {
	    $entityManager = $this->getDoctrine()->getRepository(Competence::class);
	    $comp = $entityManager->findAll();

	    return $this->render('competence/index.html.twig', [
		    'competences' => $comp
	    ]);
    }

	/**
	 * @param Request $request
	 * @return mixed
	 * @Route("/competence/new", name="compétence_add")
	 */
	public function newCompetence (Request $request)
	{
		$comp = new Competence();
		$form = $this->createForm(CompetenceType::class,$comp);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()){
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($comp);
			$entityManager->flush();

			return $this->redirectToRoute('compétences');
		}

		return $this->render('competence/new.html.twig', [
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/competence/{id}", name="competence_show")
	 */
	public function show($id)
	{
		$entityManager = $this->getDoctrine()->getRepository(Competence::class);
		$comp = $entityManager->find($id);

		return $this->render('competence/show.html.twig', [
			'article' => $comp
		]);
	}

	/**
	 * @Route("/competence/del/{id}", name="competence_del")
	 */
	public function del($id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$comp =$entityManager->getRepository(Competence::class)->find($id);
		$entityManager->remove($comp);
		$entityManager->flush();

		return $this->redirectToRoute('compétences');
	}
}
