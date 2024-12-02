<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\CategoryLivre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;




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
            
            
            // ->add('ImageLivre')
            ->add('ImageLivre', FileType::class, [
                'label' => 'Image du livre',
                'mapped' => false, // Indique que ce champ ne doit pas être directement mappé à l'entité
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            // ->add('category', EntityType::class, [
            //     'class' => CategoryLivre::class,
            //     'choice_label' => 'Nom',
            //     'label' => 'Catégorie du livre',
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
