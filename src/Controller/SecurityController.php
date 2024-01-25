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
        $client->setRoles(['ROLE_USER']);

        $form = $this->createForm(InscriptionType::class, $client);
        $form->handleRequest($request);
       
         // verification si le formulaire est soumis et s'il est valide
        if($form->isSubmitted() and $form->isValid() ){

            $plainpassword = $client->getPlainPassword();
            // hashage du mot de passe
           $password = $passwordHasher->hashPassword($client,  $plainpassword);
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
