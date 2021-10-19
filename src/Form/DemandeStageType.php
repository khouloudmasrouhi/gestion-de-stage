<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DemandeStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email',EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' =>'Merci de saisir une adresse email'
                    ]) ],
                'required' => true,
                'attr' => [
                    'class' => 'form_control'
                ]
            ])
            ->add('cin')
            ->add('etablissement')
            ->add('dateNaissance',DateType::class,
            ['widget' => 'single_text'])
            ->add('ville')
            ->add('pays')
            ->add('adresse')
            ->add('telephone')
            //->add('nomPieceJointe',FileType::class,array(
            //    'label' => 'Choisissez votre fichier'
            //))
            ->add('offrestage')
            ->add('niveau')
            ->add('specialite')
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
