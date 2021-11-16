<?php

namespace App\Form;

use App\Entity\Victima;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VictimaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, [
                'help' => 'En caso de no contar con el dato, guardar: "Sin datos_n°prev" ',
             ])
            ->add('apellido', null, [
                'help' => 'En caso de no contar con el dato, guardar: "Sin datos_n°prev" ',
             ])
            ->add('documentoNro', null, [
                'help' => 'Dejar vacio en caso de no contar con el dato',
             ])
            ->add('genero_otro')
            ->add('edad')
            ->add('nacionalidad_otra')
            ->add('provincia')
            ->add('departamento')
            ->add('localidad')
            ->add('barrio', null, [
                'help' => 'Por default Sin datos',
             ])
            ->add('calle')
            ->add('altura')
            ->add('interseccion' , ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('calle_interseccion')
            ->add('latitud')
            ->add('longitud')
            ->add('fraccion')
            ->add('radio')
            ->add('mecanismo_muerte_otro')
            ->add('tipo_arma_otro')
            ->add('medida_protecc_vigente', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('medida_protecc_especif')
            ->add('discapacidad', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('embarazada', ChoiceType::class, [
                'choices' => [
                    'No corresponde' => 'No corresponde',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('privada_libertad', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('ejer_prostitucion', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('migrante_internacional', ChoiceType::class, [
                'choices' => [
                    'No' => 'No',
                    'Si' => 'Si',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('migrante_intraprov', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('migrante_interprov', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            //->add('pueblo_originario')
            ->add('pueblo_originario', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])



            ->add('etnia_otro')
            ->add('hab_nativo_esp', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('homosex_bisex', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('ref_activista', ChoiceType::class, [
                'choices' => [
                    'No corresponde' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])

         
            ->add('afro', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('otra_sit_intersecc')
            ->add('otra_sit_laboral')
            ->add('hijos_pers_cargo', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('cant_a_cargo')
            ->add('benef_ley_brisa', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('cant_benef')
            ->add('violencia_exc', ChoiceType::class, [
                'choices' => [
                    'No' => 'No',
                    'Si' => 'Si',
                    
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('femicidio', ChoiceType::class, [
                'choices' => [
                    'No' => 'No',
                    
                    'Si' => 'Si',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('fuerza_seg', ChoiceType::class, [
                'choices' => [
                    'No' => 'No',
                    
                    'Si' => 'Si',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('otra_fuer_pert')
       
            ->add('estado_intox', ChoiceType::class, [ "label" =>
            "Estado de intoxicación al momento del hecho",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('est_intox_otro')
            ->add('desap_ant_hecho', ChoiceType::class, [ "label" =>
            "Desaparición de la víctima antes del hallazgo del cuerpo",
                'choices' => [
                    
                    'No' => 'No',
                    'Si' => 'Si',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('observacion',  TextType::class, array('data_class' => null, 'required' => false, "label" =>
            "  "))
            ->add('tipoDocumento')
            ->add('sexo')
            ->add('genero')
            ->add('rango_etario')
            ->add('edad_legal')
            ->add('nacionalidad')
            ->add('rep_geo')
            ->add('estado_civil')
            ->add('mecanismo_muerte')
            ->add('tipo_arma')
            ->add('etnia')
            ->add('sit_laboral')
            ->add('cond_actividad')
            ->add('niv_inst')
            ->add('niv_inst_form')
            ->add('tipo_femicidio')
            ->add('cont_femicida')
            ->add('fuer_seg_pert')
            ->add('est_pol')
            ->add('ejer_funcion')
            ->add('tipo_est_intox')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Victima::class,
        ]);
    }
}
