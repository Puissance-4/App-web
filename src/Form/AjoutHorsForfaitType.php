<?php

namespace App\Form;

use App\Entity\Fiche;
use App\Entity\Fraishorsforfait;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutHorsForfaitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('libelle')
            ->add('montant')
            //->add('validite')
            /*->add('idFiche',
            EntityType::class,
            array('class'=>Fiche::class,
            'choice_label'=>'id',
            'multiple'=>false,
            'expanded'=>true,
            'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('Fiche')->orderBy('Fiche.id', 'ASC');
            }
            ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fraishorsforfait::class,
        ]);
    }
}
