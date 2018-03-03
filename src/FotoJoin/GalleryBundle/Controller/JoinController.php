<?php

namespace FotoJoin\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use FotoJoin\AdminBundle\Entity\Category;
use FotoJoin\GalleryBundle\Form\CategoryFilterType;

use FotoJoin\GalleryBundle\Entity\Gallery;
use FotoJoin\GalleryBundle\Form\GalleryType;

use FotoJoin\GalleryBundle\Entity\Appraisement;
use FotoJoin\GalleryBundle\Form\AppraisementType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class JoinController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $session = $request->getSession();
//        $session->clear();
//        $serializer = new Serializer(array(new ObjectNormalizer(), new ArrayDenormalizer()), array(new JsonEncoder()));

/*
        $category = new Category();


        $categoryForm = $this->createForm('FotoJoin\GalleryBundle\Form\CategoryType', $category);

        if('POST' === $request->getMethod() && $request->request->has('category_join')) {
            $categoryForm->handleRequest($request);
            if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
                $session->set('categorySelected', $serializer->serialize($category, 'json'));
            }
        } else {
            if ($session->has('categorySelected')) {
                $categorySelected = $serializer->deserialize($session->get('categorySelected'),'FotoJoin\AdminBundle\Entity\Category', 'json');
                $categoryForm->get('category')->setData($categorySelected);
            }            
        }
*/

/*
        $categoryForm = $this->createForm('FotoJoin\GalleryBundle\Form\CategoryFilterType');

        if('POST' === $request->getMethod() && $request->request->has('category_filter')) {
            $categoryForm->handleRequest($request);
            $session->set('category_filter', $request->request->get('category_filter'));
        } elseif($session->has('category_filter')) {
            $request->request->set("category_filter", $session->get('category_filter'));
            $request->setMethod('POST');
            $categoryForm->handleRequest($request);
        }
*/
        $categoryForm = $this->createCategoryFilterForm();

        if ($session->has('category_filter') and $session->get('category_filter') != null) {
            $category = $session->get('category_filter');
            $categoryForm->get('category')->setData($this->getDoctrine()->getEntityManager()->merge($category));
        } else {
            $category = null;
        }

        $photography = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getRandomPhotography($category);


//        $photographyQuery = $photographyRepository->createQueryBuilder('ph')
//            ->select('COUNT(ph)')
//            ->leftJoin('ph.categories', 'categories');
//        if (NULL != $categories && !$categories->isEmpty()) {
//            $photographyQuery = $photographyQuery
//                ->andWhere('categories IN (:categories)')
//                ->setParameter('categories', $categories);
//        }
//        $photographyQuery = $photographyRepository->createQueryBuilder('ph')
//        $photographyQuery = $photographyQuery->getQuery();
//
//        $count = $photographyQuery->getSingleScalarResult();
//
//        $photographyQuery = $photographyRepository->createQueryBuilder('ph')
//            ->select('ph')
//            ->leftJoin('ph.categories', 'categories');
//        if (NULL != $categories && !$categories->isEmpty()) {
//            $photographyQuery = $photographyQuery
//                ->andWhere('categories IN (:categories)')
//                ->setParameter('categories', $categories);
//        }
//        $photographyQuery = $photographyQuery
//            ->setFirstResult(rand(0, $count - 1))
//            ->setMaxResults(1)
//            ->getQuery();
//
//        $photography = $photographyQuery->getOneOrNullResult();

        if(!$photography) return $this->redirectToRoute('fos_user_profile_show');

        $appraisement = new Appraisement();
        $appraisement->setPhotography($photography);
        $appraisement->setUser($user);
        $appraisement->setIp($request->getClientIp());

//        $appraisementForm = $this->createForm('FotoJoin\GalleryBundle\Form\AppraisementType', $appraisement);
        $appraisementForm = $this->createAppraisementForm($appraisement);
/*
        if ('POST' === $request->getMethod() && $request->request->has('appraisement')) {
            $appraisementForm->handleRequest($request);
            if ($appraisementForm->isSubmitted() && $appraisementForm->isValid()) {
                $value = $appraisement->getValue();
                $average = $this->getDoctrine()->getManager()
                    ->createQueryBuilder()
                    ->addSelect('AVG(a.value) as average')
                    ->from('FotoJoinGalleryBundle:Appraisement', 'a')
                    ->where('a.photography = (:photography)')
                    //->andWhere('a.delay < 15000')
                    //->andWhere('a.delay > 5000')
                    ->setParameter('photography', $photography)
                    ->getQuery()
                    ->getSingleScalarResult();
                if(!$average) $average = $value;
                $calculator = array(
                    0   =>  1000,
                    1   =>  1000,
                    2   =>  368,
                    3   =>  135,
                    4   =>  50,
                    5   =>  18,
                    6   =>  7,
                    7   =>  2,
                    8   =>  1,
                    9   =>  0,
                    10  =>  0
                );
                $appraisement->setScore( $calculator[abs(round($average) - $value)] );
//                $appraisement->getPhotography()->setValue($appraisement->getValue());
                $em = $this->getDoctrine()->getManager();
                $em->persist($appraisement);
                $em->flush();
//                $request->getSession()->getFlashBag()->add( 'warning', 'Puntaje promedio: ' . $average );
//                $request->getSession()->getFlashBag()->add( 'warning', 'Voto generado: ' . $value);
                $request->getSession()->getFlashBag()->add( 'success', 'Puntos obtenidos: ' . $appraisement->getScore() );
                return $this->redirectToRoute('foto_join_gallery_join');
            }
        }
*/
        return $this->render('FotoJoinGalleryBundle:Join:join.html.twig', array(
            'user' => $user,
            'photography' => $photography,
            'categoryForm' => $categoryForm->createView(),
            'appraisementForm' => $appraisementForm->createView(),
        ));

    }

    private function createAppraisementForm(Appraisement $appraisement)
    {
        return $this->createForm(new AppraisementType(), $appraisement, array(
            'action' => $this->generateUrl('foto_join_gallery_appraisement'),
        ));
    }

    public function appraisementAction(Request $request)
    {
        $appraisement = new Appraisement();
        $appraisementForm = $this->createAppraisementForm($appraisement);
        $appraisementForm->handleRequest($request);
        if ($appraisementForm->isSubmitted() && $appraisementForm->isValid()) {
            $value = $appraisement->getValue();
            $photography = $appraisement->getPhotography();

            $em = $this->getDoctrine()->getManager();
            $average = $em->getRepository('FotoJoinControlPanelBundle:Photography')->getAverage($photography);
//            $request->getSession()->getFlashBag()->add( 'warning', 'Promedio: ' . $average );
            if($average > 0) {
                $calculator = array(
                    0   =>  1000,
                    1   =>  1000,
                    2   =>  368,
                    3   =>  135,
                    4   =>  50,
                    5   =>  18,
                    6   =>  7,
                    7   =>  2,
                    8   =>  1,
                    9   =>  0,
                    10  =>  0
                );
                $dist = abs(round($average) - $value);
                $appraisement->setScore( $calculator[$dist] );
                switch ($dist) {
                    case 0: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Perfecto! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 1: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Perfecto! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 2: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Excelente! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 3: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Muy bien! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 4: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Bien! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 5: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 6: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Humm! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 7: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Ouch! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 8: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Mal! Has obtenido ' . $appraisement->getScore() . ' punto.'; break;
                    case 9: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Muy mal! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    case 10: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Pésimo! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                    default: $icon = 'fa fa-fw fa-lg fa-star'; $message = 'Eres lo peor! Has obtenido ' . $appraisement->getScore() . ' puntos.'; break;
                }
                $request->getSession()->getFlashBag()->add( $icon, $message );
            } else {
                $appraisement->setScore(0);
                $request->getSession()->getFlashBag()->add( 'fa fa-fw fa-lg fa-thumbs-up', 'Gracias! le diste el primer voto a la fotografía.' );
            }

            $em->persist($appraisement);
            $em->flush();
        }
        return $this->redirectToRoute('foto_join_gallery_join');
    }

    private function createCategoryFilterForm()
    {
        return $this->createForm(new CategoryFilterType(), null, array(
            'action' => $this->generateUrl('foto_join_gallery_categoryfilter'),
        ));
    }

    public function categoryFilterAction(Request $request)
    {
        $categoryFilterForm = $this->createCategoryFilterForm();
        $categoryFilterForm->handleRequest($request);
        if ($categoryFilterForm->isSubmitted() && $categoryFilterForm->isValid()) {
            $session = $request->getSession();
            $session->set('category_filter', $categoryFilterForm->get('category')->getData());
            $request->getSession()->getFlashBag()->add( 'warning', 'Cambio de Categoría: ' . $categoryFilterForm->get('category')->getData() );
        }
        return $this->redirectToRoute('foto_join_gallery_join');
    }

}
