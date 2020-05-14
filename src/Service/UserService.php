<?php


namespace App\Service;


use App\Entity\User;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;
    /**
     * @var \App\Service\MailerService
     */
    private $mailerService;

    public function __construct(EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager, MailerService $mailerService)
    {
        $this->entityManager = $entityManager;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->mailerService = $mailerService;
    }

    public function isRequestInTime(DateTimeInterface $resetPasswordTokenCreatedAt = null)
    {
        if ($resetPasswordTokenCreatedAt === null) {
            return false;
        }

        $now = new DateTime();
        $interval = $now->getTimestamp() - $resetPasswordTokenCreatedAt->getTimestamp();

        $daySeconds = 60 * 10;
        return $interval <= $daySeconds;
    }

    public function askRegistration(User $user): void
    {
        $user->setRegistrationToken($this->generateUniqueToken());

        $this->entityManager->flush();

        $this->mailerService->registrationAction($user);
    }

    public function askResetPassword(User $user): void
    {
        $user
            ->setResetPasswordToken($this->generateUniqueToken())
            ->setResetPasswordTokenCreatedAt(new DateTime());

        $this->entityManager->flush();

        $this->mailerService->forgotPasswordAction($user);
    }

    private function generateUniqueToken(): string
    {
        do {
            $confirmationToken = md5(random_bytes(32));
        } while (!$this->csrfTokenManager->getToken($confirmationToken));

        return $confirmationToken;
    }
}