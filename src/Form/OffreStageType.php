<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\OffreStage;
use App\Entity\Specialite;
use App\Entity\Type;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add('specialite')
            ->add('type')
            ->add('duree')
            ->add('dateDebut',DateType::class,
            ['widget' => 'single_text'])
            ->add('dateFin',DateType::class,
            ['widget' => 'single_text'])
            ->add('description', HiddenType::class)
            ->add('mission',HiddenType::class)
            ->add('preRequis', HiddenType::class)
            ->add('niveau')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OffreStage::class,
        ]);
    }
}
