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
            ->add('fechaDesde',  DateType::class, [ 'required' => false,
            // renders it as a single text box
            'widget' => 'single_text',
        ])
        ->add('fechaHasta',  DateType::class, [ 'required' => false,
        // renders it as a single text box
        'widget' => 'single_text',
    ]);
    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults(array(
            'method' => 'POST',
            'action' => null,
        ));
    }
}
