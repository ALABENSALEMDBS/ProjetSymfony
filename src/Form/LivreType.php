<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\CategoryLivre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;



class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('TitreLivre')
            ->add('TitreLivre', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le titre est obligatoire.']),
                    new Assert\Length([
                        'max' => 20,
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez le titre du livre',
                    'class' => 'form-control',
                ],
            ])
            ->add('AuteurLivre')

            // ->add('IsbnLivre')
            ->add('IsbnLivre', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'ISBN est obligatoire.']),
                    new Assert\Regex([
                        'pattern' => '/^\d{3}-\d{1,5}-\d{1,7}-\d{1,7}-\d{1}$/',
                        'message' => 'L\'ISBN doit respecter le format standard (ex : 978-3-16-148410-0).',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez un ISBN valide (ex : 978-3-16-148410-0)',
                ],
            ])
            ->add('NombreExemplaireLivre')
            ->add('AnneePublicationLivre', DateType::class, [
                'widget' => 'single_text', // Permet d'utiliser un sélecteur de date HTML5
                'format' => 'yyyy-MM-dd', // Format attendu
                'html5' => true, // Utilise le calendrier natif du navigateur
                'attr' => [
                    'class' => 'form-control', // Classe CSS pour le style
                ],
            ])
            
            ->add('category', EntityType::class, [
                'class' => CategoryLivre::class,
                'choice_label' => 'Nom',
                'placeholder' => 'Sélectionnez une catégorie',
                'required' => false,
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
