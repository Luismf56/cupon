<?php

namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
	public function findOfertaDelDia($ciudad)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o, c, t
            FROM OfertaBundle:Oferta o JOIN o.ciudad c JOIN o.tienda t
            WHERE c.slug = :ciudad
            ');
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);
        return $consulta->getOneOrNullResult();
    }
    
    public function findOferta($ciudad, $slug)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
			SELECT o, c, t
			FROM OfertaBundle:Oferta o JOIN o.ciudad c JOIN o.tienda t
			WHERE o.slug = :slug
			AND c.slug = :ciudad
			');
		$consulta->setParameter('slug', $slug);
		$consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);
        return $consulta->getOneOrNullResult();
    }
    
    public function findRelacionadas($ciudad)
	{
		$em = $this->getEntityManager();
		$consulta = $em->createQuery('
			SELECT o, c
			FROM OfertaBundle:Oferta o JOIN o.ciudad c
			WHERE o.revisada = true
			AND c.slug != :ciudad
			');
		$consulta->setMaxResults(5);
		$consulta->setParameter('ciudad', $ciudad);
		return $consulta->getResult();
	}
	
	public function findRecientes($ciudad_id)
	{
		$em = $this->getEntityManager();
		$consulta = $em->createQuery('
			SELECT o, t
			FROM OfertaBundle:Oferta o
			JOIN o.tienda t
			WHERE o.revisada = true
			AND o.ciudad = :id
			');

		$consulta->setMaxResults(5);
		$consulta->setParameter('id', $ciudad_id);

		return $consulta->getResult();
	}
	
    public function findVentasByOferta($oferta)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT v, o, u
            FROM OfertaBundle:Venta v JOIN v.oferta o JOIN v.usuario u
            WHERE o.id = :id
        ');
        $consulta->setParameter('id', $oferta);
        return $consulta->getResult();
    }
}