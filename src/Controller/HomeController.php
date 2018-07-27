<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller
{
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home',
        ]);
    }

    public function contact()
    {
    	return $this->render('contact/index.html.twig', [
            'controller_name' => 'Contact',
        ]);
    }
}
