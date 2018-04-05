<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * RegionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegionRepository extends \Doctrine\ORM\EntityRepository
{
    public function getActive()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()->select('r')
            ->from('FotoJoinAdminBundle:Region', 'r')
            ->join('r.provinces', 'p')
            ->join('p.communes', 'c')
            ->join('c.users', 'u')
            ->join('u.albums', 'a')
            ->join('a.photographies', 'ph')
            ->groupBy('r.id')
        ;

        return $qb->getQuery()->getResult();
    }
}
