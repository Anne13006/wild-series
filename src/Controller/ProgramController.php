<?php

// src/Controller/ProgramController.php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Program;

/**
 * *@Route("/programs", name="program_")
 */

Class ProgramController extends AbstractController
{
    /**
     *  Show all rows from Program's Entity
     * 
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        
         $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();

        // dd($programs);
         return $this->render('program/index.html.twig', [
            'programs' => $programs]
        );
    }

    /**
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     * @return Response
     */

    public function show(int $id = 1 ): Response
    {

        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id] );

        if (!$program) {
              throw $this->createNotFoundException(
                  'No Program with id : '.$id.' found in program\'s table.'
              );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
         ]);
    }


    
}

