<?php


namespace App\Controller;


use App\Repository\TrickRepository;
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

    public function indexAction(TrickRepository $trickRepository)
    {
        $tricks = $trickRepository->findBy([], ['createdAt' => 'DESC'], 15, 0);

        return $this->render('pages/home.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route ("/tricks", name="tricks")
     * @return Response
     */

    public function tricksAction(Request $request)
    {
        return $this->render('pages/tricks.html.twig');
    }
}