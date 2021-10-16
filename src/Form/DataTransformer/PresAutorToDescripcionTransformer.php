<?php

namespace App\Form\DataTransformer;

use App\Entity\PresAutor;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

class PresAutorToDescripcionTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an object (presautor) to a string (descripcion).
     *
     * @param  PresAutor|null $presautor
     * @return string
     */
    public function transform($presautor)
    {
        if (null === $presautor) {
            return '';
        }

        return $presautor->__toString();
    }

    /**
     * Transforms a string (descripcion) to an object (presautor).
     *
     * @param  string $descripcion
     * @throws TransformationFailedException si el objeto (PresAutor) no es encontrado.
     */
    public function reverseTransform($id_apellido)
    {
        @list($nomeimporta, $apellido) = explode(' - ', $id_apellido);

         
        $presautor = $this->entityManager
            ->getRepository(PresAutor::class)
            ->findOneByApellido($apellido)
        ;

        if (null === $presautor) {
            // causa un error de validadción
            // este mensage no se muestra al usuario
            // ver la opcióninvalid_message
            throw new TransformationFailedException(sprintf(
                'Un Presunto autor con descripción "%s" no existe!',
                $apellido
            ));
        }

        return $presautor;
    }
}
