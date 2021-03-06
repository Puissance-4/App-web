<?php

namespace App\Form;

use App\Entity\Fraisforfaitise;
use App\Entity\Typefraisforfait;
use Doctrine\ORM\EntityRepository;
use Proxies\__CG__\App\Entity\Fiche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutFraiForfaitiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite')
            ->add('idFiche',
            EntityType::class,
            array('class'=>Fiche::class,
            'choice_label'=>'id',
            'multiple'=>false,
            'expanded'=>true,
            'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('Fiche')->orderBy('Fiche.id', 'ASC');
            }))
            ->add('idType',
            EntityType::class,
            array('class'=>Typefraisforfait::class,
            'choice_label'=>'libelle',
            'multiple'=>false,
            'expanded'=>true,
            'query_builder'=>function(EntityRepository $er){
                return $er->createQueryBuilder('Typefraisforfait')->orderBy('Typefraisforfait.libelle', 'ASC');
            }))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fraisforfaitise::class,
        ]);
    }
}
