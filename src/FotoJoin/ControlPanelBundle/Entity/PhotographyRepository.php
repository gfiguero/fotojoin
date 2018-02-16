<?php

namespace FotoJoin\ControlPanelBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use FotoJoin\GalleryBundle\Entity\Gallery;

class PhotographyRepository extends EntityRepository
{
    public function getRandomPhotography($category = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('COUNT(DISTINCT ph.id)')
            ->from('FotoJoinControlPanelBundle:Photography', 'ph')
            ->leftJoin('ph.categories', 'c');

        if($category)
            $qb
            ->where(':category = c.id')
            ->setParameters(array('category' => $category->getId()));

        $total = $qb
            ->getQuery()
            ->getSingleScalarResult();

        $photography = $qb
            ->select('ph')
            ->groupBy('ph.id')
            ->setFirstResult(rand(0, $total - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $photography;
    }

    public function getPhotographies(Gallery $gallery = null)
    {
        $cities = $gallery->getCities();
        $categories = $gallery->getCategories();
        $users = $gallery->getUsers();
        $parameters = array();

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb ->select('ph as photography')
            ->addSelect('COUNT(DISTINCT(ap.id)) as quantity', 'AVG(ap.value) as average', 'u.exigency as exigency')
            ->from('FotoJoinControlPanelBundle:Photography', 'ph')
            ->leftJoin('FotoJoinGalleryBundle:Appraisement', 'ap', 'WITH', 'ap.photography = ph.id')
            ->leftJoin('ph.categories', 'c')
            ->leftJoin('ph.user', 'u')
            ->leftJoin('u.city1', 'c1')
            ->leftJoin('u.city2', 'c2')
            ->leftJoin('u.city3', 'c3')
            ->groupBy('ph.id')
        ;

        $qb->having('quantity >= 3', 'average >= exigency');

        if(!$cities->isEmpty()) {
            $qb->andWhere('(c1.id IN (:cities)) OR (c2.id IN (:cities)) OR (c3.id IN (:cities))');
            $parameters['cities'] =  $cities;
        }

        if(!$categories->isEmpty()) {
            $qb->andWhere('c.id IN (:categories)');
            $parameters['categories'] =  $categories;
        }

        if(!$users->isEmpty()) {
            $qb->andWhere('u.id IN (:users)');
            $parameters['users'] =  $users;
        }

        $qb->setParameters($parameters);

        switch($gallery->getOrder()) {
            case 0: $photographyNodes = $qb->getQuery()->getResult(); shuffle($photographyNodes); break;
            case 1: $photographyNodes = $qb->orderBy('average', 'DESC')->getQuery()->getResult(); break;
            case 2: $photographyNodes = $qb->orderBy('quantity', 'DESC')->getQuery()->getResult(); break;
            case 3: $photographyNodes = $qb->orderBy('ph.DateTimeOriginal', 'DESC')->getQuery()->getResult(); break;
        }

        $photographies = array_column($photographyNodes, 'photography');
        $appraisementAverages = array_column($photographyNodes, 'average');
        $appraisementQuantities = array_column($photographyNodes, 'quantity');

        return array(
            'photographies' => $photographies,
            'appraisementAverages' => $appraisementAverages,
            'appraisementQuantities' => $appraisementQuantities
        );
    }

    public function getPhotography($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb ->select('ph as photography')
            ->addSelect('COUNT(DISTINCT(ap.id)) as quantity', 'AVG(ap.value) as average')
            ->from('FotoJoinControlPanelBundle:Photography', 'ph')
            ->leftJoin('FotoJoinGalleryBundle:Appraisement', 'ap', 'WITH', 'ap.photography = ph.id')
            ->where('ph.id = :id')
            ->setParameter('id', $id->getId())
            ->groupBy('ph.id')
        ;

        $result = $qb->getQuery()->getSingleResult();

        $photography = $result['photography'];
        $appraisementAverage = $result['average'];
        $appraisementQuantity = $result['quantity'];

        return array(
            'photography' => $photography,
            'appraisementAverage' => $appraisementAverage,
            'appraisementQuantity' => $appraisementQuantity
        );
    }

    public function getAverage($photography)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('AVG(a.value) as average')
            ->from('FotoJoinGalleryBundle:Appraisement', 'a')
            ->where('a.photography = (:photography)')
            //->andWhere('a.delay < 15000')
            //->andWhere('a.delay > 5000')
            ->setParameter('photography', $photography)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

}