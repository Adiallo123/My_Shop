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

        $form = $this->createForm(InscriptionType::class, $client);
        $form->handleRequest($request);
        $client = $form->getData();
        dd($form);
        if($form->isSubmitted() and $form->isValid()){
            $client = $form->getData();
            
            $plainpassword = $form->getData()->getPassword();

            // hashage du mot de passe
           $password = $passwordHasher->hashPassword($client, $client->getPlainPassword());
           $client->getPassword($client->setPassword($password));
            dd($password);
            //sauvegarder le client
      
            //
           /*  $manager->persist($client);
            $manager->flush();
            if($password != null)
            {
                $this->addFlash(
                    'success',
                    'Votre compte a bien été créer!'
                );

            }else{
                $this->addFlash(
                    'success',
                    'Votre compte a bien été créer!pas de mot de passe'
                );
            }
            // message
          */
        }

        return $this->render('security/inscription.html.twig', [
            'form' => $form,
        ]);
    }
}
