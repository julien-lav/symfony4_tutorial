<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\TutorialRepository;

use App\Entity\Tutorial;
use App\Entity\Category;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Form\TutorialType;
use App\Form\AdminUserType;





class UserController extends Controller
{

    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'Users list',
        ]);
    }
    /**
     * @Route("/user/list", name="user_list")
     */
    public function list(Request $request , UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
    	
        return $this->render('user/index.html.twig', [
            'controller_name' => 'Contact',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_id", requirements={"page"="\d+"})
     */
    public function single(Request $request, UserRepository $userRepository, int $id)
    {

        $user = $userRepository->find($id);

        if($user) {
            return $this->render('user/single.html.twig',[
                'user'=> $user,
            ]);
        }
        throw $this->createNotFoundException('User not found!');

     }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, TutorialRepository $tutorialRepository, UserRepository $userRepository, UserInterface $user)
    {

        $userId = $user->getId();
        $user = $userRepository->find($user);

        $em = $this->getDoctrine()->getManager();        
        $tutorials = $em->getRepository(Tutorial::class)->findAll();
        
        if($user) {
            return $this->render('profile/profile.html.twig',[
                'user'=> $user,
                'tutorials'=> $tutorials,

            ]);
        }
        throw $this->createNotFoundException('No profile found!');
     }


    /**
     * @Route("profile/user/edit/{id}", name="user_edit_user")
     */
    public function update(Request $request, int $id,  UserRepository $userRepository, UserInterface $user, UserPasswordEncoderInterface $passwordEncoder) 
    {
        $pageUser = new User();
        $pageUser = $userRepository->find($id);

        if($user->getId() === $id) {

            $form = $this->createForm(AdminUserType::class, $user);

            $form->handleRequest($request);
       
            if($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirectToRoute('profile');
            }   
        } else {
            die('What are you tryin\' to do ?');
        }

        return $this->render('user/update.html.twig', 
            [
                'form' => $form->createView(),
                'id' => $id,
            ]);
    }
}