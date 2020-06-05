<?php


namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         * 1st Trick
         */
        $trick = new Trick();
        $trick->setName('Mute')
            ->setDescription('Grip the frontside edge of the board between the two feet with the front hand')
            //->setTrickGroup('grabs')
            ->setSlug('mute')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
     * 2nd Trick
     */
        $trick = new Trick();
        $trick->setName('Nose grab')
            ->setDescription('grip of the front part of the board, with the front hand')
            //->setTrickGroup('grabs')
            ->setSlug('nose grab')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 3rd Trick
         */
        $trick = new Trick();
        $trick->setName('180')
            ->setDescription('horizontal rotation at 180 degrees during the jump')
            //->setTrickGroup('rotation')
            ->setSlug('180')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 4th Trick
         */
        $trick = new Trick();
        $trick->setName('360')
            ->setDescription('rotation for a full turn during the jump')
            //->setTrickGroup('rotation')
            ->setSlug('360')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 5th Trick
         */
        $trick = new Trick();
        $trick->setName('japan air')
            ->setDescription('the front hand grabs the toe edge in between the feet and the front knee is pulled to the board')
            //->setTrickGroup('old school')
            ->setSlug('japan air')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 6th Trick
         */
        $trick = new Trick();
        $trick->setName('rocket air')
            ->setDescription('the front hand grabs the toe edge in front of the front foot (mute) and the back leg is boned while the board points perpendicular to the ground')
            //->setTrickGroup('old school')
            ->setSlug('rocket air')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 7th Trick
         */
        $trick = new Trick();
        $trick->setName('50-50')
            ->setDescription('A slide in which a snowboarder rides straight along a rail or other obstacle.[1] This trick has its origin in skateboarding, where the trick is performed with both skateboard trucks grinding along a rail')
            //->setTrickGroup('slides')
            ->setSlug('50-50')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 8th Trick
         */
        $trick = new Trick();
        $trick->setName('tailpress')
            ->setDescription('A trick performed by sliding along an obstacle, with pressure being put on the tail of the board, such that the nose of the board is raised in the air.')
            //->setTrickGroup('slides')
            ->setSlug('tailpress')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
     * 9th Trick
     */
        $trick = new Trick();
        $trick->setName('haakon flip')
            ->setDescription('An aerial maneuver performed in a halfpipe by taking off backwards, and performing an inverted 720° rotation. The rotation mimics a half-cab leading to McTwist, and is named after freestyle legend Terje Haakonsen of Norway.')
            //->setTrickGroup('flips')
            ->setSlug('haakon flip')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 10th Trick
         */
        $trick = new Trick();
        $trick->setName('tamedog')
            ->setDescription('A frontflip performed on a straight jump, with an axis of rotation in which the snowboarder flips in a forward, cartwheel-like fashion.')
            //->setTrickGroup('flips')
            ->setSlug('tamedog')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 11th Trick
         */
        $trick = new Trick();
        $trick->setName('stink-bug')
            ->setDescription('Grabbing Frontside or Mute with the rider\'s elbow passing to the inside of the knees. Style conventions dictate that during a grab, the elbow should be positioned to the outside of the knee.')
            //->setTrickGroup('tweaks')
            ->setSlug('stink-bug')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 12th Trick
         */
        $trick = new Trick();
        $trick->setName('tuck knee')
            ->setDescription('Where the knee of either leg is dropped down to touch the top of the board. When referring to snowboarding it means that the rider attempts to put their knee on the board by putting their knee underneath the torso and then pulling down to the board.')
            //->setTrickGroup('tweaks')
            ->setSlug('tuck knee')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 13th Trick
         */
        $trick = new Trick();
        $trick->setName('wildcat')
            ->setDescription('A backflip performed on a straight jump, with an axis of rotation in which the snowboarder flips in a backward, cartwheel-like fashion. A double wildcat is called a supercat.')
            //->setTrickGroup('flips')
            ->setSlug('wildcat')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 14th Trick
         */
        $trick = new Trick();
        $trick->setName('one-two')
            ->setDescription('A trick in which the rider\'s front hand grabs the heel edge behind their back foot.')
            //->setTrickGroup('grabs')
            ->setSlug('one-two')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        /**
         * 15th Trick
         */
        $trick = new Trick();
        $trick->setName('stalefish')
            ->setDescription('Back hand grabs the heel edge of the board between the feet, around the outside of the knee.')
            //->setTrickGroup('grabs')
            ->setSlug('stalefish')
            ->setMainPicture('')
            ->setCreatedAt(new \DateTime)
            ->setUpdatedAt(new \DateTime())
            ->setUser('admin');
        $manager->persist($trick);

        $manager->flush();
        }
    }