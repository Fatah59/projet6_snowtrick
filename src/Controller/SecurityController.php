<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userService = $userService;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, UserService $userService)
    {
        $user = new User();

        $registrationForm = $this->createForm(RegistrationType::class, $user);
        $registrationForm->handleRequest($request);

        if($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password)
                ->setActivated(false)
                ->setRegistrationToken(md5(random_bytes(10)));

            $entityManager->persist($user);
            $entityManager->flush();

            $userService->askRegistration($user);

            $this->addFlash('success', 'Please consult your mailbox to validate your account and be able to connect');

            return $this->redirectToRoute('registration');
        }

        return $this->render('security/registration.html.twig', [
            'registrationForm' => $registrationForm->createView()
        ]);
    }

    /**
     * @Route("/account_activation/{registrationToken}", name="account_activation")
     */
    public function accountActivation($registrationToken)
    {

        $user = $this->userRepository->findOneBy(['registrationToken' => $registrationToken]);

        if ($user === null) {
            $this->addFlash('not found', 'User not found. Please enter a correct username.');
            return $this->redirectToRoute('registration');
        }

        $user->setActivated(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->addFlash('registration successful', 'Congratulations ! Your account has been successfully activated ! You can now log in !');

        return $this->redirectToRoute('login');

        return $this->render('login.html.twig');
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
    public function forgotPassword(Request $request, UserService $userService)
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

            $userService->askResetPassword($user);

            $this->addFlash('success', 'Consult your mailbox for your request to reset your password, if your account exist');

            return $this->redirectToRoute('forgot_password');
        }

        return $this->render('security/forgotpassword.html.twig', [
            'forgotPasswordForm' => $forgotPasswordForm->createView()
        ]);
    }

    /**
     * @Route("/reset_password/{resetPasswordToken}", name="reset_password")
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, $resetPasswordToken)
    {

        $resetPasswordForm = $this->createForm(ResetPasswordType::class);
        $resetPasswordForm->handleRequest($request);

        if ($resetPasswordForm->isSubmitted() && $resetPasswordForm->isValid()) {
            $formData = $resetPasswordForm->getData();

            $user = $this->userRepository->findOneBy(['resetPasswordToken' => $resetPasswordToken, 'email' => $formData['email']]);
            if ($user === null) {
                $this->addFlash('not found', 'User not found. Please enter a correct username.');
                return $this->redirectToRoute('forgot_password');
            }

            if (!$this->userService->isRequestInTime($user->getResetPasswordTokenCreatedAt())){
                $this->addFlash('time up', 'Time limit exceeded, please start your request again');
                return $this->redirectToRoute('forgot_password');
            }

            $password = $passwordEncoder->encodePassword($user, $formData['plainPassword']);
            $user->setPassword($password)
                ->setResetPasswordToken(null)
                ->setResetPasswordTokenCreatedAt(null);

            $this->entityManager->flush();

            $this->addFlash('reset successful', 'Congratulations, your password has been changed, you can use it to sign in.');

            return $this->redirectToRoute('home');
        }

        return $this->render('security/resetpassword.html.twig', [
            'resetPasswordForm' => $resetPasswordForm->createView()
        ]);
    }
}
