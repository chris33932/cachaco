<?php

namespace App\Form;

use App\Entity\PresAutor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


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
            ->add('interseccion', ChoiceType::class, [
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
            ->add('provincia')
            ->add('departamento')
            ->add('localidad')
      
            ->add('reincidente', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('nacionalidad_otro')
            ->add('ant_penal_den', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('especif_ant')
            ->add('otra_sit_lab')
            ->add('fuerza_seg', ChoiceType::class, [
                'choices' => [
                    'No' => 'No',
                    'Si' => 'Si',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('otra_fuer_seg_pert')
            ->add('ejer_func', ChoiceType::class, [ "label" =>
            "Ejercicio de funciones",
                'choices' => [
                    'No corresponde' => 'No corresponde',
                    'En servicio' => 'En servicio',
                    'De franco' => 'De franco',
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
 
            ->add('uso_arma_fuego', ChoiceType::class, [
                'choices' => [                                
                    'No' => 'No',
                    'Si' => 'Si',
                    'Sin datos' => 'Sin datos',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
        
            ->add('observacion',  TextType::class, array('data_class' => null, 'required' => false, "label" =>
            "  "))
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
