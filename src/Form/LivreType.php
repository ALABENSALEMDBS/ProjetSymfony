<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TitreLivre')
            ->add('AuteurLivre')
            ->add('IsbnLivre')
            ->add('NombreExemplaireLivre')
            ->add('AnneePublicationLivre', DateType::class, [
                'widget' => 'single_text', // Permet d'utiliser un sélecteur de date HTML5
                'format' => 'yyyy-MM-dd', // Format attendu
                'html5' => true, // Utilise le calendrier natif du navigateur
                'attr' => [
                    'class' => 'form-control', // Classe CSS pour le style
                ],
            ])
            ->add('ImageLivre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
