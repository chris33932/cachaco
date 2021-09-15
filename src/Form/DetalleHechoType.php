<?php

namespace App\Form;

use App\Entity\CompHecho;
use App\Entity\DetalleHecho;
use App\Entity\EstadoIntox;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DetalleHechoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('victima')
            ->add('pres_autor', TextType::class, [ "label" =>
            "Presunto autor",])
            ->add('den_previa', ChoiceType::class, [ "label" =>
            "Denuncia previa de la víctima contra el presunto autor",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('den_prev_desc', TextType::class, [ "label" =>
            "Descripción de la(s) denuncia(s) previa(s)",])
            //->add('hecho')
            
            
            ->add('vinculo', ChoiceType::class, [ "label" =>
            "Vínculo entre la víctima y el presunto autor",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',                  
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])
            ->add('vinculo_fam_vic', ChoiceType::class, ["label" =>
            "Vínculo familiar entre la víctima y el presunto autor",
                'choices' => [                                
                    'Cónyuge' => 'Cónyuge',
                    'Pareja' => 'Pareja',
                    'Ex cónyuge' => 'Ex cónyuge',
                    'Ex pareja' => 'Ex pareja',
                    'Separado(a) de hecho' => 'Separado(a) de hecho',
                    'Hermano(a)' => 'Hermano(a)',
                    'Hermanastro(a)' => 'Hermanastro(a)',
                    'Hijo(a)' => 'Hijo(a)',
                    'Hijastro(a)' => 'Hijastro(a)',
                    'Padre/madre' => 'Padre/madre',
                    'Padrastro/madrastra' => 'Padrastro/madrastra',
                    'Otros vínculos familiares' => 'Otros vínculos familiares',
                    'Sin vínculo familiar' => 'Sin vínculo familiar',
                    
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])

                      
            
           
            ->add('vinculo_fam_otro', TextType::class, [ "label" =>
            "Otro vínculo familiar entre la víctima y el presunto autor",])

            ->add('vinc_no_fam_vic', ChoiceType::class, ["label" =>
            "Vínculo extrafamiliar entre la víctima y el presunto autor",
                'choices' => [                                
                    'Socio(a)' => 'Socio(a)',
                    'Empleado(a)' => 'Empleado(a)',
                    'Empleador(a)' => 'Empleador(a)',
                    'Cliente/proveedor' => 'Cliente/proveedor',
                    
                    'Otras relaciones laborales' => 'Otras relaciones laborales',
                    'Otras relaciones' => 'Otras relaciones',
                    'Sin vínculo extrafamiliar' => 'Sin vínculo extrafamiliar',
                    
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                   
                ],
             
            ])

            ->add('vinc_no_fam_otro_vic', TextType::class, [ "label" =>
            "Otro vínculo extrafamiliar entre la víctima y el presunto autor",])
           
            ->add('conviviente', ChoiceType::class, [ "label" =>
            " Convivencia entre la víctima y el presunto autor al momento del hecho",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])

            ->add('est_intox', ChoiceType::class, [ "label" =>
            "Estado de intoxicación del presunto autor",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            
            ->add('tipo_e_intox'  ,EntityType::class, ['class' => EstadoIntox::class, "label" => "Tipo de estado de intoxicación del presunto autor al momento del hecho"]      )

            ->add('est_intox_otro', TextType::class, [ "label" =>
            "Otro estado de intoxicación del presunto autor al momento del hecho",])
            
            
            ->add('sit_procesal', EntityType::class, [ 'class' => EstadoIntox::class ,"label" => "Situación procesal del presunto autor al momento del hecho",]
                  )
           
            ->add('comp_hecho', EntityType::class, [ 'class' => CompHecho::class ,"label" => "Comportamiento del presunto autor al momento del hecho",]
                  )
            ->add('comp_hecho_otro', TextType::class, [ "label" =>
            "Otro comportamiento del presunto autor al momento del hecho",])
          
        

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetalleHecho::class,
        ]);
    }
}
