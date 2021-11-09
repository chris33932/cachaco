<?php

namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
     public function getFilters()
     {
         return array(
            new TwigFilter(
                 'fechaCorta',
                 array($this, 'fechaCorta'),
                 array('is_safe' => array('html'))
            ),
            new TwigFilter(
                'fechaHora',
                array($this, 'fechaHora')
            ),
            new TwigFilter(
                'precio',
                array($this, 'precio')
            ),
            new TwigFilter(
                'numeroConDecimales',
                array($this, 'numeroConDecimales')
            ),
        );
     }

     public function fechaCorta(\DateTime $fecha){
         return $fecha->format('d-m-Y');
     }

     public function fechaHora(\DateTime $fecha){
         return $fecha->format('d-m-Y H:i:s');
     }

     public function precio($precio, $digitos = 2){
         return '$ '.number_format($precio, $digitos, ',', '.');
     }

    public function numeroConDecimales($numero, $digitos = 2){
        return number_format($numero, $digitos, ',', '.');
    }
     public function getName()
     {
         return 'app_extension';
     }
}