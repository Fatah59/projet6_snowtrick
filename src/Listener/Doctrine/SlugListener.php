<?php

namespace App\Listener\Doctrine;

use App\Entity\Trick;
use App\Service\SlugService;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SlugListener
{
    /**
     * @var SlugService
     */
    private $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    public function prePersist(Trick $trick, LifecycleEventArgs $args)
    {
        $this->slug($trick);
    }

    public function slug(Trick $trick)
    {
        if (!$trick->getName() && $trick->getSlug()){
            return;
        }

        $trick->setSlug(
            $this->slugService->slugify($trick->getName())
        );
    }
}