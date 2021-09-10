<?php

namespace App\Form;

use App\Entity\DetalleHecho;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetalleHechoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('victima')
            ->add('pres_autor')
            ->add('den_previa')
            ->add('den_prev_desc')
            //->add('hecho')
            
            
            ->add('vinculo')
            ->add('vinculo_fam_vic')
            ->add('vinculo_fam_otro')
            ->add('vinc_no_fam_otro_vic')
            ->add('vinc_no_fam_otro_vic')
            ->add('conviviente')

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetalleHecho::class,
        ]);
    }
}
