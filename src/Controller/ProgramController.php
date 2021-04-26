<?php

// src/Controller/ProgramController.php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

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
 * The controller for the Program Serie add form
 *
 * @Route("/new", name="new")
 */
public function new(Request $request) : Response
    {
        // Create a new Program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to program list
            return $this->redirectToRoute('program_index');   
        
        
        }
        // Render the form
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }




    /**
     * @Route("/{id<^[0-9]+$>}", name="show")
     * @return Response
     */

    public function show(Program $program ): Response
    {

        // $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id] );

         $seasons = $program->getSeasons();


        // if (!$program) {
        //       throw $this->createNotFoundException(
        //           'No Program with id : '.$id.' found in program\'s table.'
        //       );
        // }
        // return $this->render('program/show.html.twig', [
        //     'program' => $program, 'seasons' => $seasons,
        //  ]);
        return $this->render('program/show.html.twig', [
                'program' => $program, 'seasons' => $seasons,
             ]);

    }


/**
     * @Route("/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}", name="season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
     * @return Response
     */

    public function seasonShow(Program $program, Season $season ): Response
    {
        
        return $this->render('program/season_show.html.twig', [
            'program' => $program, 'season' => $season,
         ]);
    }

    /**
    * @Route("/{programId<^[0-9]+$>}/season/{seasonId<^[0-9]+$>}/episodes/{episodeId} ", name="episode_show") 
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId": "id"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId": "id"}})
    * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId": "id"}})
    */

public function showEpisode(Program $program, Season $season, Episode $episode)
{
    return $this->render('program/episode_show.html.twig', [
        'program' => $program, 'season' => $season, 'episode' => $episode
     ]);

}

    
}

