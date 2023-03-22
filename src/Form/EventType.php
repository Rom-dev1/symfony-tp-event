<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('cover', FileType::class, [
                'label' => 'Image',
                'mapped' => 'false',
                'required' => 'false',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ]
                    ])
                ]
            ]) // @todo voir doc upload, remplacer ce champ, les validations vont etre insérés ici
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
