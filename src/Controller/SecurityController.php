<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPassportInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registration(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user =new User();
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("login");
        }

        return $this->render('security/reg.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {

        return $this->render('security/login.html.twig', array(

        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
