<?php

namespace App\Form\DataTransformer;

use App\Entity\Hecho;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class HechoToDescripcionTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (hecho) to a string (descripcion).
     *
     * @param  Hecho|null $hecho
     * @return string
     */
    public function transform($hecho)
    {
        if (null === $hecho) {
            return '';
        }

        return $hecho->__toString();
    }

    /**
     * Transforms a string (descripcion) to an object (hecho).
     *
     * @param  string $descripcion
     * @throws TransformationFailedException si el objeto (Hecho) no es encontrado.
     */
    public function reverseTransform($id_nro_preventivo)
    {
        @list($nomeimporta, $nro_preventivo) = explode(' - ', $id_nro_preventivo);

         
        $hecho = $this->entityManager
            ->getRepository(Hecho::class)
            ->findOneByPreventivo($nro_preventivo)
        ;

        if (null === $hecho) {
            // causa un error de validadción
            // este mensage no se muestra al usuario
            // ver la opcióninvalid_message
            throw new TransformationFailedException(sprintf(
                'Un hecho con descripción "%s" no existe!',
                $nro_preventivo
            ));
        }

        return $hecho;
    }
}
