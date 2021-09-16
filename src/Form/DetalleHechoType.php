<?php

namespace App\Form;

use App\Entity\CompHecho;
use App\Entity\DetalleHecho;
use App\Entity\EstadoIntox;
use App\Entity\SitProcesal;
use phpDocumentor\Reflection\PseudoTypes\False_;
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
            ->add('pres_autor')
            
            ->add('den_previa', ChoiceType::class, [ "label" =>
            "Denuncia previa de la víctima contra el presunto autor",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('den_prev_desc', TextType::class, [ 'required'=>False, "label" =>
            "Descripción denuncias previas"])
            
            ->add('vinculo', ChoiceType::class, [
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',                  
                    'Sin determinar' => 'Sin determinar',
                    'Sin datos' => 'Sin datos',
                    "label" =>
                    "Vínculo entre la víctima y el presunto autor",
                   
                ],
             
            ])
            ->add('vinculo_familiar', ChoiceType::class, ["label" =>
            "Vínculo familiar entre la víctima y el presunto autor",
                'choices' => [     
                    'Sin datos' => 'Sin datos',                           
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
                   
                   
                ],
             
            ])

                      
            
           
            ->add('vinculo_familiar_otro', TextType::class, [ 'data_class' => null, 'required'=>false,"label" =>
            "Otro vínculo familiar entre la víctima y el presunto autor",])

            ->add('vinculo_no_familiar', ChoiceType::class, [
                'choices' => [        
                    'Sin datos' => 'Sin datos',                        
                    'Socio(a)' => 'Socio(a)',
                    'Empleado(a)' => 'Empleado(a)',
                    'Empleador(a)' => 'Empleador(a)',
                    'Cliente/proveedor' => 'Cliente/proveedor',
                    
                    'Otras relaciones laborales' => 'Otras relaciones laborales',
                    'Otras relaciones' => 'Otras relaciones',
                    'Sin vínculo extrafamiliar' => 'Sin vínculo extrafamiliar',
                    
                    'Sin determinar' => 'Sin determinar',
                    
                  
                   
                ],  "label" =>
                "Vínculo extrafamiliar entre la víctima y el presunto autor",
             
            ])

            ->add('vinculo_no_familiar_otro', TextType::class, [ 'required' => false,"label" =>
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

            ->add('est_intox_otro', TextType::class, [ 'required'=>false, "label" =>
            "Otro estado de intoxicación del presunto autor al momento del hecho"])
            
            
            ->add('sit_procesal', EntityType::class, [ 'class' => SitProcesal::class ,"label" => "Situación procesal del presunto autor al momento del hecho",]
                  )
           
            ->add('comp_hecho', EntityType::class, [ 'class' => CompHecho::class ,"label" => "Comportamiento del presunto autor al momento del hecho",]
                  )
            ->add('comp_hecho_otro', TextType::class, ['required'=>false, "label" =>
            "Otro comportamiento del presunto autor al momento del hecho"])
          
        

           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetalleHecho::class,
        ]);
    }
}
