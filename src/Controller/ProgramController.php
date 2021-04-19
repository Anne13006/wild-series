<?php

// src/Controller/ProgramController.php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

Class ProgramController extends AbstractController
{
    /**
     * @Route("/programs/", name="program_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Séries',
         ]);
    }

    /**
     * @Route("/programs/show/{id}/", requirements={"page"="\d+"}, name="program_show")
     * @return Response
     */

    public function show(int $id = 1 ): Response
    {
        return $this->render('program/show.html.twig', [
            'website' => 'Program show Wild Séries', 'id' => $id
         ]);
    }

}

