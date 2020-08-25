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

        if (!$entity instanceof Picture) {
            return;
        }

        $this->upload($entity);
    }

    private function upload(Picture $picture)
    {
        if(!$picture->getFile()){
            return;
        }

        $picture->setFileName(
            $this->pictureUploader->upload(
                $picture->getFile()
            )
        );
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




