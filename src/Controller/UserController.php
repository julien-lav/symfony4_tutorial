<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;




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
            die("User doesn't exist");
     }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, UserRepository $userRepository, UserInterface $user)
    {

        $userId = $user->getId();
        $user = $userRepository->find($user);

        if($user) {
            return $this->render('profile/profile.html.twig',[
                'user'=> $user,
            ]);
        }
            die('No profile found');
     }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     * Method({"DELETE"})
     */    
    public function delete(Request $request, UserRepository $userRepository, int $id) 
    {
            $user = $userRepository->find($id);

            $em = $this->getDoctrine()->getManager();
            $em ->remove($user);
            $em ->flush();
           

            return $this->redirect($this->generateUrl('user_list'));
        // return $this->redirect($this->generateUrl('users_list'));     
        // Si on utilise le return directement, on peut se passer de $response 
        // et donc de son --> use Symfony\Flex\Response;
    }

}