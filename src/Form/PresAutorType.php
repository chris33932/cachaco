<?php

namespace App\Form;

use App\Entity\PresAutor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresAutorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('documento_nro')
            ->add('genero_otro')
            ->add('edad')
            ->add('barrio')
            ->add('calle')
            ->add('altura')
            ->add('interseccion')
            ->add('calle_interseccion')
            ->add('latitud')
            ->add('longitud')
            ->add('fraccion')
            ->add('radio')
      
            ->add('reincidente')
            ->add('nacionalidad_otro')
            ->add('ant_penal_den')
            ->add('especif_ant')
            ->add('otra_sit_lab')
            ->add('fuerza_seg')
            ->add('otra_fuer_seg_pert')
            ->add('ejer_func')
            ->add('discapacidad')
         
        
      
            ->add('pert_pueblo_orig')
            ->add('etnia_otro')
            ->add('hab_nat_esp')
            ->add('uso_arma_fuego')
        
            ->add('observacion')
            ->add('tipo_documento')
            ->add('sexo')
            ->add('genero')
            ->add('edad_legal')
            ->add('rango_etario')
            ->add('rep_geo')
      
            ->add('nacionalidad')
            ->add('estado_civil')
            ->add('sit_lab')
            ->add('cond_act')
            ->add('niv_inst')
            ->add('niv_inst_formal')
            ->add('fuer_seg_pert')
            ->add('est_pol')
            ->add('etnia')
            ->add('sit_arma_fue')
            ->add('per_arma_fue')
         
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PresAutor::class,
        ]);
    }
}
