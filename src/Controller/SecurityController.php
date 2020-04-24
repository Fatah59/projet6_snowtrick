<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/forgot_password", name="forgot_password")
     */
    public function forgotPassword(Request $request, MailerService $mailerService)
    {
        $user = new User();
        $forgotPasswordForm = $this->createForm(ForgotPasswordType::class, $user);
        $forgotPasswordForm->handleRequest($request);

        if ($forgotPasswordForm->isSubmitted() && $forgotPasswordForm->isValid()) {


            $user = $this->userRepository->findOneBy(['username'=>$user->getUsername()]);


            if(!$user){
                $this->addFlash('success', 'Consult your mailbox for your request to reset your password, if your account exist');

                return $this->redirectToRoute('forgot_password');
            }

            $mailerService->askResetPassword($user);


            $this->addFlash('success', 'Consult your mailbox for your request to reset your password, if your account exist');

            return $this->redirectToRoute('forgot_password');
        }

        return $this->render('security/forgotpassword.html.twig', [
            'forgotPasswordForm' => $forgotPasswordForm->createView()
        ]);
    }

    /**
     * @Route("/reset_password/{reset_password_token}", name="reset_password")
     */
    public function resetPassword(Request $request)
    {
        return $this->render('security/resetpassword.html.twig');
    }
}

