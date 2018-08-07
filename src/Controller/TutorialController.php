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

use Symfony\Component\Security\Core\User\UserInterface;

use App\Form\AdminTutorialType;



class TutorialController extends Controller
{
    /**
     * @Route("/tutorials", name="tutorials")
     */
    public function index(Request $request, TutorialRepository $tutorialRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $tutorials = $em->getRepository(Tutorial::class)->findAll();

        /* KPN PAGINATOR */
        $query = $tutorials;
        $paginator  = $this->get('knp_paginator');       
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
            );
                      
        return $this->render('tutorial/list.html.twig', array(
            'tutorials'=> $tutorials,
            'pagination' => $pagination,
        ));
    }

	/**
     * @Route("/profile/tutorial", name="tutorial")
     */
    public function addTutorial(Request $request, TutorialRepository $tutorialRepository,UserInterface $user)
    {
    	$tutorial = new Tutorial();


    	$form = $this->createForm(TutorialType::class, $tutorial);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
            $tutorial->setUser($user);  		          
            $em->persist($tutorial);
    		$em->flush();

            $this->addFlash('notice','Your tutorial has been added, thanks !');       
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
    public function update(Request $request, int $id, TutorialRepository $tutorialRepository, UserInterface $user) 
    {

        $tutorial = new Tutorial();
        $tutorial = $tutorialRepository->find($id);

        if($user->getId() === $tutorial->getUser()->getId()) {

            $form = $this->createForm(AdminTutorialType::class, $tutorial);
            $form->handleRequest($request);
           
            if($form->isSubmitted() && $form->isValid()) {            
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirectToRoute('tutorials');
            }
        } else {
            die('What are you tryin\' to do ?');
        }

        return $this->render('tutorial/update.html.twig', 
            [
                'form' => $form->createView(),
                'id' => $id,
            ]);
    }
}