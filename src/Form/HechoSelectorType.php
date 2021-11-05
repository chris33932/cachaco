<?php

namespace App\Form;


use App\Form\DataTransformer\HechoToDescripcionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\Extension\Core\Type\SearchType;

use AppBundle\Form\DataTransformer\ProductoToDescripcionTransformer;

class HechoSelectorType extends AbstractType
{
    private $transformer;

    public function __construct(HechoToDescripcionTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'El hecho seleccionado no existe.',
            'empty_value' => null,
        ));
    }

    public function getParent()
    {
        return SearchType::class;
    }
}