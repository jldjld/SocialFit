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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
     /**
     * @Route("/register", methods="POST")
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
     */
    public function currentUser() {
        $user = $this->getUser();
        return $this->json($user);
    }
}
