<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tutorial;
use App\Entity\Category;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Form\TutorialType;

use App\Repository\UserRepository;
use App\Repository\TutorialRepository;

use Symfony\Component\HttpFoundation\Request;

class TutorialController extends Controller
{

    /**
     * @Route("/tutorials", name="tutorials")
     */
    public function index(Request $request, TutorialRepository $tutorialRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $tutorials = $em->getRepository(Tutorial::class)->findAll();
        // Need to go deeper here !
        // $categoryName = $em->getRepository(Category::class)->findAll();
        
        return $this->render('tutorial/list.html.twig', array(
            'tutorials'=> $tutorials,
            //'categoryName' => $categoryName,
        ));
    }

	/**
     * @Route("/profile/tutorial", name="tutorial")
     */
    public function tutorial(Request $request, TutorialRepository $tutorialRepository)
    {
    	$tutorial = new Tutorial();
    	$form = $this->createForm(TutorialType::class, $tutorial);

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($tutorial);
    		$em->flush();

            return $this->redirectToRoute('tutorials');

    	}

    	return $this->render('tutorial/index.html.twig', array(
    		'form' => $form->createView(),
    		'tutorial'=> $tutorial,
    	));
    }

    /**
     * @Route("profile/tutorial/edit/{id}", name="edit_tutorial")
     */
    public function update(Request $request, int $id, TutorialRepository $tutorialRepository, UserRepository $userRepository) 
    {
        /**//**//**//* 
        need to find a fix to prevent users 
        from updating tutorials not own by themself   
        *//**//**//*

        $tutorial = new Tutorial();

        $tutorial = $tutorialRepository->find($id);

        $form = $this->createForm(AdminTutorialType::class, $tutorial);

        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
         
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('tutorials');
        }
        
        return $this->render('tutorial/update.html.twig', 
            [
                'form' => $form->createView(),
                'id' => $id,
            ]);*/
    }
}