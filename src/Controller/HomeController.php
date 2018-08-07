<?php

namespace App\Controller;

use App\Entity\Channel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\ChannelRepository;


class HomeController extends Controller
{
    public function index(Request $request, ChannelRepository $channelRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $channels = $em->getRepository(Channel::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home',
            'channels' => $channels,
        ]);
    }

    public function contact()
    {
    	return $this->render('contact/index.html.twig', [
            'controller_name' => 'Contact',
        ]);
    }
}
