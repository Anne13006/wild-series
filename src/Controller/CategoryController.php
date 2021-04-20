<?php

// src/Controller/CategoryController.php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Entity\Program;
use Doctrine\ORM\Mapping\Id;

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

        //dd($programs);

        return $this->render('Category/show.html.twig', [
            'categories' => $categories, 'programs' => $programs,
         ]);
    }


}
