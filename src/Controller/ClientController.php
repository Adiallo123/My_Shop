<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client.inscription', methods:['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        
        return $this->render('client/inscription.html.twig', [
            'form' => $form,
        ]);
    }
}
