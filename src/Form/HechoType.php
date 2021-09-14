<?php

namespace App\Form;

use App\Entity\Hecho;
use App\Form\DetalleHechoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class HechoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nro_preventivo')

        ->add('nro_sumario')
        ->add('nro_exp_jud')
        ->add('juzgado')
        ->add('fiscalia')

            
        ->add('fecha', DateType::class, [
            // renders it as a single text box
            'widget' => 'single_text',
        ])
        ->add('anio')
        ->add('mes')


        
         // coleccion de detalles para cada hecho

         ->add('detalleHechos', CollectionType::class, [
            'entry_type' => DetalleHechoType::class,
            'entry_options' => [
                'label' => false
            ], 'by_reference' => false,
               'allow_add' => true,
               'allow_delete' => true
        ])
       
        

          
         
            ->add('localidad')
            ->add('cod_loc_indec')
            ->add('gran_rcia')
            ->add('hora_ocu')
            ->add('dia_ocu')
            //--------------------------------
            //grupo ocurrencia
            //------------------------------
            ->add('franja_h_seis')
            ->add('franja_h_tres')
            ->add('barrio_ocu')
            ->add('calle_ocu')
            ->add('altura_ocu')
            ->add('intersecc_ocu')
            ->add('calle_int_ocu')
            ->add('latitud_ocu')
            ->add('longitud_ocu')
            ->add('acceso_ocu')
            ->add('lugar_ocu_otro')
            ->add('dom_part_otro')
            ->add('fraccion_ocu')
            ->add('radio_ocu')
            ->add('coinc_lug_ocu')
            ->add('fecha_hgo', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('hora_hgo')
            ->add('dia_hgo')
            ->add('f_hora_hgo_seis')
            ->add('f_hora_hgo_tres')
            ->add('barrio_hgo')
            ->add('calle_hgo')
            ->add('altura_hgo')
            ->add('intersec_hgo')
            ->add('calle_int_hgo')
            ->add('latitud_hgo')
            ->add('longitud_hgo')
            ->add('lug_hgo_otro')
            ->add('acceso_hgo')
            ->add('dom_part_hgo_otro')
            ->add('fraccion_hgo')
            ->add('radio_hgo')
            ->add('oca_delito_otro')
            ->add('orig_reg_otro')
            ->add('recep_den_otro')
            ->add('cant_victimas')
            ->add('cant_vic_col')
            ->add('cant_pres_autor')
            ->add('link')
            ->add('observacion')
            ->add('comisaria')
            ->add('provincia')
            ->add('departamento')
            ->add('localidad')
            ->add('rep_geo_ocu')
            ->add('zona_ocu')
            ->add('tipo_esp_ocu')
            ->add('tipo_lug_ocu')
            ->add('lugar_ocu')
            ->add('dom_part_ocu')
            ->add('rep_geo_hgo')
            ->add('zona_hgo')
            ->add('tipo_esp_hgo')
            ->add('tipo_lug_hgo')
            ->add('lugar_hgo')
            ->add('dom_part_hgo')
            ->add('oca_delito')
            ->add('origen_reg')
            ->add('recep_den')
            ->add('tipologia')
             ->add('save', SubmitType::class,['attr' => ['class' => 'btn btn-success']])

          
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hecho::class,
        ]);
    }
}
