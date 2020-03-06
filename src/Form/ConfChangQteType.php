<?php

namespace App\Form;

use App\Entity\Fraisforfaitise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ConfChangQteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('quantite',IntegerType::class,array('attr' => array('min' =>0)))
        //->add('idFiche')
        //->add('idType')
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fraisforfaitise::class,
        ]);
    }
}
