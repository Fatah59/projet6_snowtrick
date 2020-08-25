<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trick")
 */
class TrickController extends AbstractController
{
    /**
     * @Route("/", name="trick_index", methods={"GET"})
     */
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="trick_create", methods={"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $trick = new Trick();
        $trick->setUser($this->getUser());
        $trickForm = $this->createForm(TrickType::class, $trick);
        $trickForm->handleRequest($request);

        if ($trickForm->isSubmitted() && $trickForm->isValid()) {

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'The trick' .$trick->getName(). 'has been saved !');

            return $this->redirectToRoute('trick_details', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/create.html.twig', [
            'trickForm' => $trickForm->createView(),
        ]);
    }

    /**
     * @Route("/details/{slug}", name="trick_details", methods={"GET"})
     */
    public function details(TrickRepository $trickRepository, Request $request,EntityManagerInterface $entityManager, $slug)
    {
        $trick = $trickRepository->findOneBySlug($slug);

        $comment = new Comment();

        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid())
        {
            $comment->setCreatedAt(new \DateTime());
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Your comment has been saved !');

            return $this->redirectToRoute('trick_details', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/details.html.twig', [
            'trick' => $trick,
            'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * @Route("/edit/{slug}", name="trick_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TrickRepository $trickRepository, EntityManagerInterface $entityManager, $slug)
    {
        $trick = $trickRepository->findOneBySlug($slug);

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            foreach($trick->getTrickPicture() as $picture)
            {
                $picture->setTrick($trick);
                $entityManager->persist($picture);
            }

            $trick->setUpdatedAt(new \DateTime());
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'The trick' .$trick->getName(). 'has been modified !');
            return $this->redirectToRoute('trick_details', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="trick_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TrickRepository $trickRepository, EntityManagerInterface $entityManager, $slug)
    {
        $trick = $trickRepository->findOneBySlug($slug);

        $fileSystem = new Filesystem();

        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token')))
        {
            foreach ($trick->getTrickPicture() as $picture) {
                $fileSystem->remove($picture->getPath() . '/' . $picture->getName());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trick);
            $entityManager->flush();

            $this->addFlash('success', 'The trick' . $trick->getName() . 'was successfully deleted !');
        }

        return $this->redirectToRoute('home');
    }
}
