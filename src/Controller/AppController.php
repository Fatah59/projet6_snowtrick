<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
 * @Route ("/", name="home")
 * @return Response
 */

    public function indexAction(Request $request)
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route ("/tricks", name="tricks")
     * @return Response
     */

    public function tricksAction(Request $request)
    {
        return $this->render('pages/tricks.html.twig');
    }


    /**
     * @Route ("/subscribe", name="subscribe")
     * @return Response
     */

    public function subscribeAction(Request $request)
    {
        return $this->render('pages/subscribe.html.twig');
    }

}