<?php

namespace App\Controller;

use App\Entity\User;
use App\Event\UserRegisteredEvent;
use App\Form\LoginUserType;
use App\Form\UserRegisterType;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    
	/**
	* @Route("/register", name="register")
	*/
	public function register(Request $request , UserPasswordEncoderInterface $passwordEncoder )
	{
		$user = new User();

		$form = $this->createForm(UserRegisterType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
		
		$password = $passwordEncoder
			->encodePassword($user, $user->getPassword());

		$user->setPassword($password);
		
		$em = $this->getDoctrine()->getManager();
		$em ->persist($user);
		$em ->flush();
		
		return $this->redirectToRoute('index');
		}
		return $this->render( 'security/register.html.twig', [
		'form' => $form->createView()
		]);
	}

	/**
	* @Route("/login", name="login")
	*/
	public function login(AuthenticationUtils $authenticationUtils )
	{
		$user = new User();
		$form = $this->createForm(LoginUserType:: class, $user);
		
		return $this->render( 'security/login.html.twig', [
			'error' => $authenticationUtils ->getLastAuthenticationError(),
			'form' => $form->createView()
			]);
	}

	/**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
