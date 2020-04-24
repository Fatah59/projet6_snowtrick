<?php


namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Twig\Environment;

class MailerService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    public function __construct(\Swift_Mailer $mailer, Environment $twig, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function registrationAction (User $registration)
    {
        $message = (new \Swift_Message('Registration to the website snowtricks !'))
            ->setFrom('projet6snowtricks@derradjfatah.com')
            ->setTo($registration->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/registration.html.twig', [
                    'contact' =>$registration
                ]),
                'text/html');

        $this->mailer->send($message);
    }


    public function askResetPassword(User $user): void
    {
        $user
            ->setResetPasswordToken($this->generateUniqueToken())
            ->setResetPasswordTokenCreatedAt(new DateTime());

        $this->entityManager->flush();

        $this->forgotPasswordAction($user);
    }

    public function forgotPasswordAction (User $user)
    {
        $message = (new \Swift_Message('You forgot your password for the website snowtricks ?'))
            ->setFrom('projet6snowtricks@derradjfatah.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/forgotpassword.html.twig', [
                    'user' =>$user
                ]),
                'text/html');

        $this->mailer->send($message);
    }

    private function generateUniqueToken(): string
    {
        do {
            $confirmationToken = md5(random_bytes(32));
        } while (!$this->csrfTokenManager->getToken($confirmationToken));

        return $confirmationToken;
    }

}
