<?php

namespace App\Form\Type;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType extends AbstractType
{
    public const NAME = 'movie';
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('genre');
        $builder->add('imageSrc');
        $builder->add('showtimes', CollectionType::class, [
            'entry_type'   => ShowtimeFormType::class,
            'by_reference' => false,
            'allow_add'    => true,
            'allow_delete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Movie::class,
            'allow_extra_fields' => true,
            'csrf_protection'    => false
        ]);
    }

    public function getBlockPrefix()
    {
        return self::NAME;
    }
}
