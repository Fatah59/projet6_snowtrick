<?php


namespace App\Listener\Doctrine;


use App\Entity\Picture;
use App\Service\PictureUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;

class MainPictureListener
{
    /**
     * @var PictureUploader
     */
    private $pictureUploader;

    public function __construct(PictureUploader $pictureUploader)
    {
        $this->pictureUploader = $pictureUploader;
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if(!$entity instanceof Picture){
            return;
        }

        $filename = $this->pictureUploader->upload($entity);
        if ($filename === null){
            return;
        }
        $entity->setFileName($filename);
        }

        public function postRemove(LifecycleEventArgs $args)
        {
            $entity = $args->getEntity();
            if (!$entity instanceof Picture) {
                return;
            }

            $this->pictureUploader->remove($entity);
        }
}




