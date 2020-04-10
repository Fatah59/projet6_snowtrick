<?php


namespace App\Service;


use App\Entity\User;
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

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
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

    public function forgotPasswordAction (User $forgotpassword)
    {
        $message = (new \Swift_Message('You forgot your password for the website snowtricks ?'))
            ->setFrom('projet6snowtricks@derradjfatah.com')
            ->setTo($forgotpassword->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/forgotpassword.html.twig', [
                    'contact' =>$forgotpassword
                ]),
                'text/html');

        $this->mailer->send($message);
    }

}