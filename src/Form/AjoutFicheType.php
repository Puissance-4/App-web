<?php

namespace App\Form;

use App\Entity\Fiche;
use App\Entity\Visiteur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutFicheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('dateModif')
            //->add('dateCreation')
            //->add('montantRembourse')
            //->add('idEtat')
            ->add('idVisiteur',
            EntityType::class,
            array('class'=>Visiteur::class,
            'choice_label'=>'id',
            'multiple'=>false,
            'expanded'=>true,
            'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('Visiteur')->orderBy('Visiteur.id', 'ASC');
            }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fiche::class,
        ]);
    }
}
