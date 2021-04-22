<?php

// src/Controller/ProgramController.php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Program;
use App\Entity\Season;

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
     * @Route("/{id<^[0-9]+$>}", name="show")
     * @return Response
     */

    public function show(int $id = 1 ): Response
    {

        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id] );

        $seasons = $program->getSeasons();


        if (!$program) {
              throw $this->createNotFoundException(
                  'No Program with id : '.$id.' found in program\'s table.'
              );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program, 'seasons' => $seasons,
         ]);
    }


/**
     * @Route("/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}", name="season_show")
     * @return Response
     */

    public function seasonShow(int $programId, int $seasonId ): Response
    {


        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $programId]);
        $season = $this->getDoctrine()->getRepository(Season::class)->findOneBy(['id' => $seasonId]);
        
        return $this->render('program/season_show.html.twig', [
            'program' => $program, 'season' => $season,
         ]);
    }




    
}

