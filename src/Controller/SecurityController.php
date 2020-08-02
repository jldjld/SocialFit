<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api") 
 * This controller is used for the authentication on the app
 */
class SecurityController extends AbstractController
{
     /**
     * @Route("/register", methods="POST") 
     * this method creates a new User based on UserType form,
     * if the form is submitted and valid, then it flushes the new User
     * in User table, and send a 201 response.
     * If there is an error it will send an error response
     */
    public function register(Request $request, EntityManagerInterface $managerInterface, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, array(
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ));
        $form->handleRequest($request);
        $form->submit(
            json_decode(
                $request->getContent(),
                true
            ), 
            false
        );

        if($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $hashedPassword = $encoder->encodePassword($user, $user->getPassword());
           
            $user->setPassword($hashedPassword);

            $managerInterface->persist($user);
        
            $managerInterface->flush(); 
            return $this->json($user, Response::HTTP_CREATED);
        };
        return $this->json($form->getErrors(true), Response::HTTP_BAD_REQUEST);
    }
     /**
     * @Route(methods="GET")
     * This method is watching which user is currently connected
     */
    public function currentUser() {
        $user = $this->getUser();
        return $this->json($user);
    }
}
