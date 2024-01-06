<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;




class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'security.inscription', methods:['GET', 'POST'])]
    public function inscription(Request $request, UserPasswordHasherInterface $passwordHasher, 
    EntityManagerInterface $manager,
    
    ): Response
    {
        $client = new Client();
       
        /*$hashedPassword = $passwordHasher->hashPassword(
            $client,
            $client->getPlainPassword()
        );
        $client->setPassword($hashedPassword);*/
    
        $form = $this->createForm(InscriptionType::class, $client);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){

            $plainPassword = $form->getData()->getPassword();
            // hashage du mot de passe
            
           $password = $passwordHasher->hashPassword($client, $plainPassword);
            $client->setPassword($password);

            //sauvegarder le client
            $client = $form->getData();
            $manager->persist($client);
            $manager->flush();

            // message
            $this->addFlash(
                'success',
                'Votre compte a bien été créer!'
            );
        }

        return $this->render('security/inscription.html.twig', [
            'form' => $form,
        ]);
    }
}
