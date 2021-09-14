<?php

namespace App\Form;

use App\Entity\DetalleHecho;

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
                   
                ],
             
            ])

            ->add('vinculo_fam_vic', TextType::class, [ "label" =>
            "Vínculo familiar entre la víctima y el presunto autor",])
            ->add('vinculo_fam_otro', TextType::class, [ "label" =>
            "Otro vínculo familiar entre la víctima y el presunto autor",])
            ->add('vinc_no_fam_otro_vic', TextType::class, [ "label" =>
            "Vínculo extrafamiliar entre la víctima y el presunto autor",])
            ->add('vinc_no_fam_otro_vic', TextType::class, [ "label" =>
            "Otro vínculo extrafamiliar entre la víctima y el presunto autor",])
            ->add('conviviente', TextType::class, [ "label" =>
            "Convivencia entre la víctima y el presunto autor al momento del hecho",])
            
            ->add('est_intox', ChoiceType::class, [ "label" =>
            "Estado de intoxicación del presunto autor",
                'choices' => [
                    'Sin datos' => 'Sin datos',
                    'Si' => 'Si',
                    'No' => 'No',
                    'Sin determinar' => 'Sin determinar',
                   
                ],
             
            ])
            ->add('tipo_e_intox', TextType::class, [ "label" =>
            "Tipo de estado de intoxicación del presunto autor al momento del hecho",])
            ->add('est_intox_otro', TextType::class, [ "label" =>
            "Otro estado de intoxicación del presunto autor al momento del hecho",])
            ->add('sit_procesal', TextType::class, [ "label" =>
            "Situación procesal del presunto autor al momento del hecho",])
            ->add('comp_hecho', TextType::class, [ "label" =>
            "Comportamiento del presunto autor al momento del hecho",])
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
