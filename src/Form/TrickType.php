<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Tricks name'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('trickGroup', EntityType::class, [
                'label' => 'Trick group',
                'class' => TrickGroup::class,
                'choice_label' => 'name'
            ])
            ->add('mainPicture', PictureType::class, [
                'label' => 'Main Picture'
            ])
//            ->add('trickPicture', CollectionType::class, [
//                'entry_type' => PictureType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//            ])
//            ->add('trickvideo', CollectionType::class, [
//                'entry_type' => VideoType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
