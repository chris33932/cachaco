<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class RangoFechaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('fechaDesde', DateType::class, array(
                'label' => 'Desde',
                'required' => true,
                'attr' => ['class' => 'form-control js-datepicker'],
                'empty_data' => null,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ))->add('fechaHasta', DateType::class, array(
                'label' => 'Hasta',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control js-datepicker'],
                'empty_data' => null,
                'html5' => false,
                'format' => 'dd/MM/yyyy',
            ));
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'method' => 'POST',
            'action' => null,
        ));
    }
}
