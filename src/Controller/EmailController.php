<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class EmailController extends Controller
{

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
 
       return $this->render('contact/index.html.twig', 
        [
            //
        ]);
    }

    /**
     * @Route("/send", name="send")
     * @Method({"GET", "POST"})
     */
	public function send(Request $request, \Swift_Mailer $mailer)
	{

		if($request->isMethod('POST')) {
            $name = $request->get('name');
            $email = $request->get('email');
            $subject = $request->get('subject');
            $body = $request->get('message');

            if ($mailer instanceof \Swift_Mailer) {

                var_dump($name);

                $message = (new \Swift_Message($subject))
                    ->setFrom($email)
                    ->setTo("info.prepa.cinema@gmail.com")
                    ->setBody(
                        $body,
                       'text/plain'
                    )
                ;
                $mailer->send($message);

                $this->addFlash('success', 'Your email has been sent !');

            }
        }   

		    return $this->render('contact/index.html.twig', 
		    [
		    // Used here to reload the page
		    ]);
	}
}
?>