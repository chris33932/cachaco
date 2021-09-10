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
            ->add('nombre')
            ->add('apellido')
            ->add('documentoNro')
            ->add('genero_otro')
            ->add('edad')
            ->add('nacionalidad_otra')
            ->add('barrio')
            ->add('calle')
            ->add('altura')
            ->add('interseccion')
            ->add('calle_interseccion')
            ->add('latitud')
            ->add('longitud')
            ->add('fraccion')
            ->add('radio')
            ->add('mecanismo_muerte_otro')
            ->add('tipo_arma_otro')
            ->add('medida_protecc_vigente')
            ->add('medida_protecc_especif')
            ->add('discapacidad')
            ->add('embarazada')
            ->add('privada_libertad')
            ->add('ejer_prostitucion')
            ->add('migrante_internacional')
            ->add('migrante_intraprov')
            ->add('migrante_interprov')
            //->add('pueblo_originario')
            ->add('pueblo_originario', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                    'Si' => 'Si',
                   
                ],
             
            ])



            ->add('etnia_otro')
            ->add('hab_nativo_esp')
            ->add('homosex_bisex')
            ->add('ref_activista')

         
            ->add('afro')
            ->add('otra_sit_intersecc')
            ->add('otra_sit_laboral')
            ->add('hijos_pers_cargo')
            ->add('cant_a_cargo')
            ->add('benef_ley_brisa')
            ->add('cant_benef')
            ->add('violencia_exc')
            ->add('femicidio')
            ->add('fuerza_seg')
            ->add('otra_fuer_pert')
           // ->add('sit_detencion')
            ->add('estado_intox')
            ->add('est_intox_otro')
            ->add('desap_ant_hecho')
            ->add('observacion', TextType::class)
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
