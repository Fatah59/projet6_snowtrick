<?php

namespace App\Listener\Doctrine;

use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPasswordListener
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getObject();

        if(!$entity instanceof User){
            return;
        }

        $this->encodePlainPassword($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getObject();

        if(!$entity instanceof User){
            return;
        }

        $this->encodePlainPassword($entity);
        // mettre à jour les modifs dans entity //
        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }

    public function encodePlainPassword(User $user): void
    {
        if(!$user->getPlainPassword()){
            return;
        }

        $user->setPassword(
            $this->userPasswordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            )
        );

        $user->eraseCredentials();
    }
}