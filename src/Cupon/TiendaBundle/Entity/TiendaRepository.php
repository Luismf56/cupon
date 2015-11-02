<?php

namespace Cupon\TiendaBundle\Entity;
use Doctrine\ORM\EntityRepository;

class TiendaRepository extends EntityRepository
{
    
    public function findUltimasOfertasPublicadas($tienda_id, $limite = 10)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, t
            FROM OfertaBundle:Oferta o JOIN o.tienda t
            WHERE o.revisada = true AND o.tienda = :id
        ');
        $consulta->setMaxResults($limite);
        $consulta->setParameter('id', $tienda_id);
        return $consulta->getResult();
    }
    
    public function findCercanas($tienda, $ciudad)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT t, c
            FROM TiendaBundle:Tienda t JOIN t.ciudad c
            WHERE c.slug = :ciudad AND t.slug != :tienda
        ');
        $consulta->setMaxResults(5);
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setParameter('tienda', $tienda);
        
        return $consulta->getResult();
    }
    
    public function findOfertasRecientes($tienda_id, $limite = 5)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, t
            FROM OfertaBundle:Oferta o JOIN o.tienda t
            WHERE o.tienda = :id
        ');
        $consulta->setMaxResults($limite);
        $consulta->setParameter('id', $tienda_id);
        $consulta->useResultCache(true, 3600);
        return $consulta->getResult();
    }
}