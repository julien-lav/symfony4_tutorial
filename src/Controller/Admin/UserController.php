<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;



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


        $form = $this->createFormBuilder($user)
                ->add('nickname', TextType::class, array('attr' => array('class' => 'form-control')))
                //->add('password', RepeatedType::class, array(
                //    'type' => PasswordType::class,
                //    'first_options'  => array('label' => 'Password'),
                //    'second_options' => array('label' => 'Repeat Password'),))
                ->add('firstname', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('lastname', TextType::class, array('attr' => array('class' => 'form-control')))
                ->add('email', EmailType::class, array('attr' => array('class' => 'form-control')))
                //->add('dateOfBirth', DateType::class, array('required' =>false, 'placeholder' => 'Select a date', 'attr' => array('class' => 'form-control')))
                ->add('save', SubmitType::class, array(
                  'label' => 'Edit an user',
                  'attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
         
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('user_list');
        }
        
        return $this->render('user/new.html.twig', 
            [
                'form' => $form->createView(),
                'id' => $id,
            ]);
    }

}