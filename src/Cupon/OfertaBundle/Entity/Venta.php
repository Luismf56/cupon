<?php

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Venta
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**

    /**

    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

    }

    public function getFecha()
    {
        return $this->fecha;
    }

    
    public function setOferta(\Cupon\OfertaBundle\Entity\Oferta $oferta)

    public function getUsuario()

}
