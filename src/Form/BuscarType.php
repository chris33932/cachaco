<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class BuscarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('query', SearchType::class, array('label' => 'Buscar por nombre, apellido o Id',
                'required' => false,'attr' =>
                array('class' => 'form-control','style'=>'margin-bottom:15px'),
                'empty_data' => null,'attr' =>
                array('class' => 'form-control','style'=>'margin-bottom:15px')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'method' => 'GET',
            'action' => null,
        ));
    }
}
