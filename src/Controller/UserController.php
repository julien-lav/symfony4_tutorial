<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class UserController extends Controller
{


    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'Users list',
        ]);
    }

    public function list(Request $request , UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
    	return $this->render('user/list.html.twig', [
            'controller_name' => 'Contact',
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
            die('ici pour le moment !');
     }

}