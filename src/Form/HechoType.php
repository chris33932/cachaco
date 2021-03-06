<?php

namespace App\Form;

use App\Entity\Departamento;
use App\Entity\Hecho;
use App\Entity\OcasionDelito;
use App\Form\DetalleHechoType;
use Doctrine\Common\Annotations\Annotation\Required;
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
            ->add('juzgado')
            ->add('fiscalia')
            ->add('comisaria')
            ->add('fecha', DateType::class, [ 'required' => false, // renders it as a single text box
            'widget' => 'single_text',
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
            ->add('dia_ocu', ChoiceType::class, [ "label" =>
            "D??a de Ocurrencia",
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
                        
            ->add('provincia')
            ->add('departamento' )
            ->add('localidad')
            ->add('cod_loc_indec', TextType::class, [ "label" =>
            "Codigo de localidad del INDEC",])

            ->add('gran_rcia', ChoiceType::class, [ "label" =>
            "Gran Resistencia",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin datos' => 'Sin datos'
                    
                   
                ],
             
            ])
                      
            ->add('hora_ocu', TimeType::class, [ "label" =>
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
            ->add('franja_h_tres', ChoiceType::class, [ "label" =>
            "Franja horaria (cada 3 horas)",
                'choices' => [
                    ' ' => ' ',
                    '00:00 - 02:59' => '00:00 - 02:59',
                    '03:00 - 05:59' => '03:00 - 05:59',
                    '06:00 - 08:59' => '06:00 - 08:59',
                    '09:00 - 11:59' => '09:00 - 11:59',
                    '12:00 - 14:59' => '12:00 - 14:59',
                    '15:00 - 17:59' => '15:00 - 17:59',
                    '18:00 - 20:59' => '18:00 - 20:59',
                    '21:00 - 23:59' => '21:00 - 23:59',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
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
            "Calle intersecci??n Ocurrencia",])
            ->add('rep_geo_ocu')
            ->add('latitud_ocu')
            ->add('longitud_ocu')
            ->add('zona_ocu')
            ->add('tipo_esp_ocu')
            ->add('tipo_lug_ocu')
            ->add('acceso_ocu', ChoiceType::class, [ "label" =>
            "Acceso",
                'choices' => [
                    'No corresponde ' => 'No corresponde',
                    'Libre' => 'Libre',
                    'Restringido' => 'Restringido',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',

                   
                ],
             
            ])
            ->add('lugar_ocu')
            ->add('lugar_ocu_otro')
            ->add('dom_part_ocu')
            ->add('dom_part_otro')
            ->add('fraccion_ocu')
            ->add('radio_ocu')
            ->add('coinc_lug_ocu', ChoiceType::class, [ "label" =>
            "Coincidencia entre lugar de ocurrencia y lugar de hallazgo",
                'choices' => [
                    'Si' => 'Si',
                    'No' => 'No',
                   
              
                    'Sin datos' => 'Sin datos',
                    'Sin determinar' => 'Sin determinar',
                    
                   
                ],
             
            ])         
           
            


            //--------------------------------
            //grupo hallazgo
            //------------------------------
            ->add('fecha_hgo', DateType::class, [ 'required' => false,
                // renders it as a single text box
                'widget' => 'single_text',
            ])
            ->add('hora_hgo')
            ->add('dia_hgo', ChoiceType::class, [ "label" =>
            "D??a de Hallazgo",
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
            
            ->add('barrio_hgo')
            ->add('calle_hgo')
            ->add('altura_hgo')
            ->add('intersec_hgo')
            ->add('calle_int_hgo')
            ->add('rep_geo_hgo')
            ->add('latitud_hgo')
            ->add('longitud_hgo')


            ->add('lug_hgo_otro')
            ->add('acceso_hgo', ChoiceType::class, [ "label" =>
            "Acceso",
                'choices' => [
                    'No corresponde ' => 'No corresponde',
                    'Libre' => 'Libre',
                    'Restringido' => 'Restringido',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                ],
            ])
            ->add('dom_part_hgo_otro')
            ->add('fraccion_hgo')
            ->add('radio_hgo')
            ->add('zona_hgo')
            ->add('tipo_esp_hgo')
            ->add('tipo_lug_hgo')
            ->add('lugar_hgo')
            ->add('dom_part_hgo')

            ->add('oca_delito', EntityType::class, [ 'class' => OcasionDelito::class ,"label" => "En ocasi??n de otro delito",]
                  )
            ->add('oca_delito_otro', TextType::class, [ "label" =>
            "En ocasi??n delito otro",])
            ->add('origen_reg')
            ->add('orig_reg_otro')
            ->add('recep_den')
            ->add('recep_den_otro')
            ->add('tipologia')
            
           
            ->add('cant_victimas')
            ->add('cant_vic_col', TextType::class, ['data_class' => null, 'required' => false, "label" =>
            "N??mero de v??ctimas colaterales"])
           
            
            
            ->add('cant_pres_autor')
            ->add('link')
            ->add('observacion',  TextType::class, array('data_class' => null, 'required' => false, "label" =>
            "Observaci??n"))

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
