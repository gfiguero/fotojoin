<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCategoriesByCities($cities)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from('FotoJoinAdminBundle:Category', 'c')
            ->leftJoin('c.photographies', 'ph')
            ->leftJoin('ph.user', 'u')
            ->leftJoin('u.city1', 'city1')
            ->leftJoin('u.city2', 'city2')
            ->leftJoin('u.city3', 'city3')
        ;

        $qb
            ->where('city1.id IN (:cities)')
            ->orWhere('city2.id IN (:cities)')
            ->orWhere('city3.id IN (:cities)')
            ->groupBy('c.id')
            ->setParameter('cities', $cities)
        ;

        return $qb;
    }
}
