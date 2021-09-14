<?php

namespace App\Form;

use App\Entity\Hecho;
use App\Entity\OcasionDelito;
use App\Form\DetalleHechoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class HechoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            //--------------------------------
            //grupo ocurrencia
            //------------------------------

            ->add('nro_preventivo')

            ->add('nro_sumario')
            ->add('nro_exp_jud')

            ->add('fiscalia')

            ->add('juzgado')
            
                
            ->add('fecha', DateType::class, [ // renders it as a single text box
                'widget' => 'single_text', 'required' => false
            ])
            ->add('anio')
            ->add('mes', ChoiceType::class, [ "label" =>
            "Mes",
                'choices' => [
                    ' ' => ' ',
                    'Enero' => 'Enero',
                    'Febrero' => 'Febrero',
                    'Marzo' => 'Marzo',
                    'Abril' => 'Abril',
                    'Mayo' => 'Mayo',
                    'Junio' => 'Junio',
                    'Julio' => 'Julio',
                    'Agosto' => 'Agosto',
                    'Septiembre' => 'Septiembre',
                    'Octubre' => 'Octubre',
                    'Noviembre' => 'Noviembre',
                    'Diciembre' => 'Diciembre',
                
                   
                ],
             
            ])
            ->add('cod_loc_indec', ChoiceType::class, [ "label" =>
            "Código Localidad INDEC",
                'choices' => [
                    ' falta hacer' => ' ',
                    'Enero' => 'Enero',
                    'Febrero' => 'Febrero',
                    'Marzo' => 'Marzo',
                    'Abril' => 'Abril',
                    'Mayo' => 'Mayo',
                    'Junio' => 'Junio',
                    'Julio' => 'Julio',
                    'Agosto' => 'Agosto',
                    'Septiembre' => 'Septiembre',
                    'Octubre' => 'Octubre',
                    'Noviembre' => 'Noviembre',
                    'Diciembre' => 'Diciembre',
                
                   
                ],
             
            ])
            ->add('gran_rcia', ChoiceType::class, [ "label" =>
            "Gran Resistencia",
                'choices' => [
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin datos' => 'Sin datos',
                    'Sin determinar' => 'Sin determinar',
                    
                   
                ],
             
            ])
           
            ->add('dia_ocu', ChoiceType::class, [ "label" =>
            "Día de Ocurrencia",
                'choices' => [
                    ' ' => ' ',
                    'Lunes' => 'Lunes',
                    'Martes' => 'Martes',
                    'Miercoles' => 'Miercoles',
                    'Jueves' => 'Jueves',
                    'Viernes' => 'Viernes',
                    'Sabado' => 'Sabado',
                    'Domingo' => 'Domingo',
                   
                ],
             
            ])
            
           
          
         
            ->add('localidad')
            ->add('cod_loc_indec', TextType::class, [ "label" =>
            "Codigo de localidad del INDEC",])

            ->add('hora_ocu', TextType::class, [ "label" =>
            "Hora de ocurrencia",])
            
            ->add('franja_h_seis', ChoiceType::class, [ "label" =>
            "Franja horaria (cada 6 horas)",
                'choices' => [
                    ' ' => ' ',
                    '00:00 - 05:59' => '00:00 - 05:59',
                    '06:00 - 11:59' => '06:00 - 11:59',
                    '12:00 - 17:59' => '12:00 - 17:59',
                    '18:00 - 23:59' => '18:00 - 23:59',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('franja_h_tres')
            ->add('barrio_ocu', TextType::class, [ "label" =>
            "Barrio Ocurrencia",])
            ->add('calle_ocu')
            ->add('altura_ocu')
            ->add('intersecc_ocu', ChoiceType::class, [ "label" =>
            "Interseccion ocurrencia",
                'choices' => [
                    'No' => 'No',
                    'Si' => 'Si',
                    
                    'Sin datos' => 'Sin datos',
                    'Sin determinar' => 'Sin determinar',
                    
                   
                ],
             
            ])
            ->add('calle_int_ocu', TextType::class, [ "label" =>
            "Calle intersección Ocurrencia",])
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
            
            ->add('orig_reg_otro')
            ->add('recep_den_otro')
            ->add('cant_victimas')
            ->add('cant_vic_col', TextType::class, ['data_class' => null, 'required' => false, "label" =>
            "N° victimas colat."])
           
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


            //--------------------------------
            //grupo hallazgo
            //------------------------------
            ->add('zona_hgo')
            ->add('tipo_esp_hgo')
            ->add('tipo_lug_hgo')
            ->add('lugar_hgo')
            ->add('dom_part_hgo')
            ->add('oca_delito', EntityType::class, [ 'class' => OcasionDelito::class ,"label" => "En ocasión de otro delito",]
                  )
            ->add('oca_delito_otro', TextType::class, [ "label" =>
            "En ocasión delito otro",])
            ->add('origen_reg')
            ->add('recep_den')
            ->add('tipologia')
            ->add('cant_pres_autor')
            ->add('link')
            ->add('observacion',  TextType::class, array('data_class' => null, 'required' => false, "label" =>
            "Observación"))

            // coleccion de detalles para cada hecho

            ->add('detalleHechos', CollectionType::class, [
            'entry_type' => DetalleHechoType::class,
            'entry_options' => [
                'label' => false
            ], 'by_reference' => false,
               'allow_add' => true,
               'allow_delete' => true
        ]) 
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
