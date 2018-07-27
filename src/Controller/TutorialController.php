<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tutorial;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Form\TutorialType;

use App\Repository\UserRepository;
use App\Repository\TutorialRepository;

use Symfony\Component\HttpFoundation\Request;

class TutorialController extends Controller
{

	/**
     * @Route("/tutorial", name="tutorial")
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
    	}

    	return $this->render('tutorial/index.html.twig', array(
    		'form' => $form->createView(),
    		'tutorial'=> $tutorial,
    	));
    }

    /**
     * @Route("/tutorials", name="tutorials")
     */
    public function tutorials(Request $request, TutorialRepository $tutorialRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $tutorials = $em->getRepository(Tutorial::class)->findAll();
        
        return $this->render('tutorial/list.html.twig', array(
            'tutorials'=> $tutorials,
        ));
    }
}