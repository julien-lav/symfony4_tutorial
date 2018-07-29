<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use App\Form\AdminUserType;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends Controller
{

    /**
     * @Route("/admin/user/delete/{id}", name="user_delete")
     * Method({"DELETE"})
     */    
    public function delete(Request $request, UserRepository $userRepository, int $id) 
    {
        $user = $userRepository->find($id);

        if($user) {
            $em = $this->getDoctrine()->getManager();
            $em ->remove($user);
            $em ->flush();
           
            return $this->redirect($this->generateUrl('user_list'));
        }
            die('No profile found');
    }

    // <a href="{{ path( 'article_remove', {'id': article.id}) }} ">
    // /** 
    // * @Route("/article/remove/{id}", name="article_remove")
    // * @ParamConverter("article", options={"mapping"={"id"="id"}})
    // */
    // public function remove(Article $article , EntityManagerInterface $entityManager )
    // {
    // $entityManager ->remove( $article );
    // $entityManager ->flush();
    // return $this->redirectToRoute( 'home');
    // }

    /**
     * @Route("/profile/delete", name="profile_delete")
     */
    public function profileDelete(Request $request, UserRepository $userRepository, UserInterface $user)
    {

        $userId = $user->getId();
        $user = $userRepository->find($user);

        if($user) {
            $em = $this->getDoctrine()->getManager();
            $em ->remove($user);
            $em ->flush();

            return $this->render('profile/goodbye.html.twig',[
                'user'=> $user,
            ]);
        }
            die('No profile found');
     }


    /**
     * @Route("admin/user/edit/{id}", name="edit_user")
     */
    public function update(Request $request, $id, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder) 
    {

        $user = new User();
        $user = $userRepository->find($id);

        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
         
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('user_list');
        }
        
        return $this->render('user/update.html.twig', 
            [
                'form' => $form->createView(),
                'id' => $id,
            ]);
    }
}