<?php

namespace App\Form\Type;

use App\Entity\Showtime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowtimeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('showtime', DateTimeType::class, [
            'widget'     => 'single_text',
            'format' => 'yyyy-MM-dd  HH:mm:ss',
            'html5' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Showtime::class,
            'csrf_protection' => false,
        ]);
    }
}
