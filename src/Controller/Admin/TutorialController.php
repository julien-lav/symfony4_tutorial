<?php

namespace App\Controller\Admin;

use App\Entity\Tutorial;
use App\Repository\TutorialRepository;
use App\Form\TutorialType;
use App\Form\AdminTutorialType;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

// use Symfony\Component\Security\Core\User\UserInterface;
// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class TutorialController extends Controller
{
    /**
     * @Route("/admin/tutorial/delete/{id}", name="tutorial_delete_admin")
     * Method({"DELETE"})
     */    
    public function delete(Request $request, TutorialRepository $tutorialRepository, int $id) 
    {
        $tutorial = $tutorialRepository->find($id);

        if($tutorial) {
            $em = $this->getDoctrine()->getManager();
            $em ->remove($tutorial);
            $em ->flush();
           
            return $this->redirect($this->generateUrl('tutorials'));
        }
            die('No profile found');
    }


    /**
     * @Route("/admin/tutorial/edit/{id}", name="edit_tutorial_admin")
     */
    public function update(Request $request, int $id, TutorialRepository $tutorialRepository) 
    {

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
            ]);
    }

    /**
     * @Route("/profile/delete", name="profile_delete")
     */
    public function profileDelete(Request $request, TutorialRepository $tutorialRepository)
    {

        $tutorialId = $tutorial->getId();
        $tutorial = $tutorialRepository->find($tutorial);

        if($tutorial) {
            $em = $this->getDoctrine()->getManager();
            $em ->remove($tutorial);
            $em ->flush();

            return $this->render('profile/goodbye.html.twig',[
                'user'=> $tutorial,
            ]);
        }
            die('No profile found');
     }
}