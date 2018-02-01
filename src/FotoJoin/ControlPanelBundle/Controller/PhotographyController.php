<?php

namespace FotoJoin\ControlPanelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\UserBundle\Model\UserInterface;

use FotoJoin\ControlPanelBundle\Entity\Photography;
use FotoJoin\ControlPanelBundle\Form\PhotographyType;
use FotoJoin\ControlPanelBundle\Form\DropzoneType;

use FotoJoin\ControlPanelBundle\Entity\Album;
use FotoJoin\ControlPanelBundle\Form\PhotographyFilterType;

/**
 * Photography controller.
 *
 */
class PhotographyController extends Controller
{
    /**
     * Lists all Photography entities.
     *
     */
    public function indexAction(Request $request, Album $album = null)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $session = $request->getSession();

        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if ($album) {
            if ($sort) $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findBy(array('user' => $user,'album' => $album), array($sort => $direction));
            else $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findBy(array('user' => $user,'album' => $album));
        } else {
            if ($sort) $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findBy(array('user' => $user), array($sort => $direction));
            else $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findBy(array('user' => $user));
        }
        $paginator = $this->get('knp_paginator');
        $photographies = $paginator->paginate($photographies, $request->query->getInt('page', 1), 64);

        $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user));

        return $this->render('FotoJoinControlPanelBundle:Photography:index.html.twig', array(
            'photographies' => $photographies,
            'album' => $album,
            'albums' => $albums,
            'direction' => $direction,
            'sort' => $sort,
            'user' => $user,
        ));
    }

    /**
     * Creates a new Photography entity.
     *
     */
    public function dropzoneAction(Request $request, Album $album = null)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if($request->isXmlHttpRequest()) {

            $file = $this->getRequest()->files->get('photography');
            $exif = exif_read_data($file);
            $photography = new Photography();
            $photography->setUser($user);
            $photography->setFile($file);
            $photography->setExif($exif);
            $photography->setAlbum($album);
            $em = $this->getDoctrine()->getManager();
            $em->persist($photography);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array(
                'success' => 200
            ));
            return $response;
        }

        $dropzoneForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\DropzoneType', null, array('action' => $this->generateUrl('photography_dropzone', array('album' => $album->getId()))));
        $dropzoneForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user));

        return $this->render('FotoJoinControlPanelBundle:Photography:dropzone.html.twig', array(
            'dropzone_form' => $dropzoneForm->createView(),
            'user' => $user,
            'album' => $album,
            'albums' => $albums,
        ));
    }

    public function showAction(Request $request, Photography $photography)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user));
        return $this->render('FotoJoinControlPanelBundle:Photography:show.html.twig', array(
            'photography' => $photography,
            'albums' => $albums,
            'user' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing Photography entity.
     *
     */
    public function editAction(Request $request, Photography $photography)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if (!is_object($photography) || !$photography instanceof Photography || $photography->getUser() != $user) {
            return $this->redirectToRoute('photography_index');
        }
        $editForm = $this->createEditForm($photography);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($photography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'photography.edited' );
            return $this->redirectToRoute('photography_show', array('id' => $photography->getId()));
        }

        $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user));

        return $this->render('FotoJoinControlPanelBundle:Photography:edit.html.twig', array(
            'photography' => $photography,
            'albums' => $albums,
            'editForm' => $editForm->createView(),
            'user' => $user,
        ));

    }

    /**
     * Creates a form to edit a Photography entity.
     *
     * @param Photography $photography The Photography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Photography $photography)
    {
        return $this->createForm('FotoJoin\ControlPanelBundle\Form\PhotographyType', $photography, array(
            'action' => $this->generateUrl('photography_edit', array('id' => $photography->getId()))
        ));
    }

    /**
     * Deletes a Photography entity.
     *
     */
    public function deleteAction(Request $request, Photography $photography)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $deleteForm = $this->createDeleteForm($photography);
        $deleteForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user));

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em->remove($photography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'photography.deleted' );
            return $this->redirectToRoute('photography_index', array('album' => $photography->getAlbum()->getId()));
        }

        return $this->render('FotoJoinControlPanelBundle:Photography:delete.html.twig', array(
            'photography' => $photography,
            'albums' => $albums,
            'user' => $user,
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Photography entity.
     *
     * @param Photography $photography The Photography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photography $photography)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photography_delete', array('id' => $photography->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function exifAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $photography = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findOneById(1);
        $exif = exif_read_data($photography->getFile());
        $data = array();
        if(array_key_exists('Model', $exif)) {
            $data['Model'] = $exif['Model'];
        }
        if(array_key_exists('DateTimeOriginal', $exif)) {
            $data['DateTimeOriginal'] = $exif['DateTimeOriginal'];
        }
        if(array_key_exists('ShutterSpeedValue', $exif)) {
            $data['ShutterSpeedValue'] = $exif['ShutterSpeedValue'];
            $data['ShutterSpeedValue'] = explode('/',$data['ShutterSpeedValue']);
            $data['ShutterSpeedValue'] = $data['ShutterSpeedValue'][0]/$data['ShutterSpeedValue'][1];
        }
        if(array_key_exists('ApertureValue', $exif)) {
            $data['ApertureValue'] = $exif['ApertureValue'];
            $data['ApertureValue'] = explode('/',$data['ApertureValue']);
            $data['ApertureValue'] = $data['ApertureValue'][0]/$data['ApertureValue'][1];
        }
        if(array_key_exists('ISOSpeedRatings', $exif)) {
            $data['ISOSpeedRatings'] = $exif['ISOSpeedRatings'];
        }
        if(array_key_exists('FocalLength', $exif)) {
            $data['FocalLength'] = $exif['FocalLength'];
            $data['FocalLength'] = explode('/',$data['FocalLength']);
            $data['FocalLength'] = $data['FocalLength'][0]/$data['FocalLength'][1];
        }
        if(array_key_exists('FNumber', $exif)) {
            $data['FNumber'] = $exif['FNumber'];
            $data['FNumber'] = explode('/',$data['FNumber']);
            $data['FNumber'] = $data['FNumber'][0]/$data['FNumber'][1];
        }
        return $this->render('FotoJoinControlPanelBundle:Photography:exif.html.twig', array(
            'photography' => $photography,
            'totalvalue' => $photography->getTotalValue($photography->getCategories()->getValues()),
            'exif' => $exif,
            'data' => $data,
        ));
    }
}
