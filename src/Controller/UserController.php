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

}