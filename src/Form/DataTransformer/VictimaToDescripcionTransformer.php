<?php

namespace App\Form\DataTransformer;

use App\Entity\Victima;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class VictimaToDescripcionTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (victima) to a string (descripcion).
     *
     * @param  Victima|null $victima
     * @return string
     */
    public function transform($victima)
    {
        if (null === $victima) {
            return '';
        }

        return $victima->__toString();
    }

    /**
     * Transforms a string (descripcion) to an object (victima).
     *
     * @param  string $descripcion
     * @throws TransformationFailedException si el objeto (Victima) no es encontrado.
     */
    public function reverseTransform($id_apellido)
    {
        @list($nomeimporta, $apellido) = explode(' - ', $id_apellido);

         
        $victima = $this->entityManager
            ->getRepository(Victima::class)
            ->findOneByApellido($apellido)
        ;

        if (null === $victima) {
            // causa un error de validadción
            // este mensage no se muestra al usuario
            // ver la opcióninvalid_message
            throw new TransformationFailedException(sprintf(
                'Un Victima con descripción "%s" no existe!',
                $apellido
            ));
        }

        return $victima;
    }
}
