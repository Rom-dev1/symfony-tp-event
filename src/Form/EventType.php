<?php

namespace App\Form;

use App\Entity\Event;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', )
            ->add('price')
            ->add('createdAt')
            ->add('startEvent')
            ->add('endEvent')
            ->add('cover')
            ->add('description')
        ;
    }

    //@todo faire un tableau ppur débuter selection de date a partir de 2023
    //@todo faire le moneytype, modifier le range dans eventype validate, et personnalisé le message  

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
