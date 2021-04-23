<?php

// src/Controller/CategoryController.php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Entity\Program;
use Doctrine\ORM\Mapping\Id;
use App\Form\CategoryType;

/**
 * *@Route("/categories", name="categories_")
 */

class CategoryController extends AbstractController
{
    /**
     *  Show all rows from Category's Entity
     * 
     * @Route("/", name="index")
     * @return Response
     */

    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('Category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

/**
 * The controller for the category add form
 *
 * @Route("/new", name="new")
 */
public function new(Request $request) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('categories_index');   
        
        
        }
        // Render the form
        return $this->render('Category/new.html.twig', ["form" => $form->createView()]);
    }

     /**
     * @Route("/show/{categoryName}", name="show")
     * @return Response
     */

    public function show(string $categoryName ): Response
    {

        $categories = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name' => $categoryName] );
        //dd($categories);
        if (!$categories) {
              throw $this->createNotFoundException(
                  'No Category with name : '.$categoryName.' found in categories table.'
              );
        }

        $programs = $this->getDoctrine()->getRepository(Program::class)
        ->findBy(['category'=>$categories->getId()], ['id' => 'DESC'],$limit=3);


        return $this->render('Category/show.html.twig', [
            'categories' => $categories, 'programs' => $programs,
         ]);
    }




}
