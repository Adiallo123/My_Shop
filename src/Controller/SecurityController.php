<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    #[Route('/connexion', name: 'security.connexion', methods:['GET', 'POST'])]
    public function connexion(AuthenticationUtils $authenticationUtils): Response{
       
        return $this->render('security/connexion.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'     => $authenticationUtils->getLastAuthenticationError()
        ]);
    }


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

    #[Route('/deconnexion', name: 'security.logout', methods:['GET', 'POST'])]
    public function logout(): Response{
        return $this->render('home/index.html.twig');
    }
  
}
