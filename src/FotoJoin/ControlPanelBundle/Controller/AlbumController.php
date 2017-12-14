<?php

namespace FotoJoin\ControlPanelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\UserBundle\Model\UserInterface;
use Vich\UploaderBundle\Handler\UploadHandle;
use Vich\UploaderBundle\Form\DataTransformer\FileTransformer;
use Doctrine\Common\Collections\ArrayCollection;

use FotoJoin\ControlPanelBundle\Entity\Album;
use FotoJoin\ControlPanelBundle\Form\AlbumType;

use FotoJoin\ControlPanelBundle\Entity\Photography;
use FotoJoin\ControlPanelBundle\Form\PhotographyType;
use FotoJoin\ControlPanelBundle\Form\PhotographyFileType;
use FotoJoin\ControlPanelBundle\Form\PhotographyCollectionType;

/**
 * Album controller.
 *
 */
class AlbumController extends Controller
{
    /**
     * Lists all Album entities.
     *
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user), array($sort => $direction));
        else $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('user' => $user));
        $paginator = $this->get('knp_paginator');
        $albums = $paginator->paginate($albums, $request->query->getInt('page', 1), 10);

        $album = new Album();
        $albumForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\AlbumType', $album, array('action' => $this->generateUrl('album_new')))->createView();

        return $this->render('FotoJoinControlPanelBundle:Album:index.html.twig', array(
            'albums' => $albums,
            'direction' => $direction,
            'sort' => $sort,
            'user' => $user,
            'albumForm' => $albumForm,
        ));
    }

    /**
     * Creates a new Album entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $album = new Album();
        $newForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\NewAlbumType', $album);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $album->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'album.created' );    

            return $this->redirectToRoute('album_edit', array('id' => $album->getId()));
        }

        return $this->render('FotoJoinControlPanelBundle:Album:new.html.twig', array(
            'user' => $user,
            'newForm' => $newForm->createView(),
        ));
    }

    public function dropzoneAction(Request $request, Album $album)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if($request->isXmlHttpRequest()) {

            $file = $this->getRequest()->files->get('photography');
            $photography = new Photography();
            if(exif_imagetype($file)) {
                $photography->setExif(exif_read_data($file));
            }
            $photography->setUser($user);
            $photography->setAlbum($album);
            $photography->setFile($file);
            $em = $this->getDoctrine()->getManager();
            $em->persist($photography);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array(
                'success' => 200
            ));
            return $response;
        }
    }

    public function addAction(Request $request, Album $album)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $deleteForm = $this->createDeleteForm($album);
        $addForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\DropzoneType', $album, array(
            'action' => $this->generateUrl('album_dropzone', array('id' => $album->getId())),
        ));

        $em = $this->getDoctrine()->getManager();
        $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findByAlbum($album);

        return $this->render('FotoJoinControlPanelBundle:Album:add.html.twig', array(
            'album' => $album,
            'photographies' => $photographies,
            'add_form' => $addForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user,
        ));
    }


    /**
     * Displays a form to edit an existing Album entity.
     *
     */
    public function editAction(Request $request, Album $album)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $originalPhotographies = new ArrayCollection();
        foreach ($album->getPhotographies() as $photography) {
            $originalPhotographies->add($photography);
        }

        $deleteForm = $this->createDeleteForm($album);
        $editForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\AlbumType', $album);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $newPhotographies = $album->getPhotographies();
            foreach ($originalPhotographies as $originalPhotography) {
                if (false === $newPhotographies->contains($originalPhotography)) {
                    $em->remove($originalPhotography);
                }
            }

            $em->persist($album);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'album.edit.flash' );

            return $this->redirectToRoute('album_edit', array('id' => $album->getId()));
        }

//        $em = $this->getDoctrine()->getManager();
//        $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findByAlbum($album);
//        $files = array();
//        foreach ($photographies as $key => $photography) { $files[] = $photography->getFile(); }
//        $photographyCollectionForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\PhotographyCollectionType', $files);
//        $editForm->get('file')->setData($files);

        return $this->render('FotoJoinControlPanelBundle:Album:edit.html.twig', array(
            'album' => $album,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user' => $user,
        ));
    }

    /**
     * Deletes a Album entity.
     *
     */
    public function deleteAction(Request $request, Album $album)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $form = $this->createDeleteForm($album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($album);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'album.deleted' );    
        }

        return $this->redirectToRoute('album_index');
    }

    /**
     * Creates a form to delete a Album entity.
     *
     * @param Album $album The Album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Album $album)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $album->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
