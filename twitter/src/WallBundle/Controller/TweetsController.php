<?php

namespace WallBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WallBundle\Entity\Tweets;
use WallBundle\Form\TweetsType;

/**
 * Tweets controller.
 *
 * @Route("/tweets")
 */
class TweetsController extends Controller
{
    /**
     * Lists all Tweets entities.
     *
     * @Route("/", name="tweets_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tweets = $em->getRepository('WallBundle:Tweets')->findAll();

        return $this->render('tweets/index.html.twig', array(
            'tweets' => $tweets,
        ));
    }

    /**
     * Creates a new Tweets entity.
     *
     * @Route("/new", name="tweets_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tweet = new Tweets();
        $form = $this->createForm('WallBundle\Form\TweetsType', $tweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tweet);
            $em->flush();

            return $this->redirectToRoute('tweets_show', array('id' => $tweets->getId()));
        }

        return $this->render('tweets/new.html.twig', array(
            'tweet' => $tweet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tweets entity.
     *
     * @Route("/{id}", name="tweets_show")
     * @Method("GET")
     */
    public function showAction(Tweets $tweet)
    {
        $deleteForm = $this->createDeleteForm($tweet);

        return $this->render('tweets/show.html.twig', array(
            'tweet' => $tweet,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tweets entity.
     *
     * @Route("/{id}/edit", name="tweets_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tweets $tweet)
    {
        $deleteForm = $this->createDeleteForm($tweet);
        $editForm = $this->createForm('WallBundle\Form\TweetsType', $tweet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tweet);
            $em->flush();

            return $this->redirectToRoute('tweets_edit', array('id' => $tweet->getId()));
        }

        return $this->render('tweets/edit.html.twig', array(
            'tweet' => $tweet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Publish tweet
     *
     * @Route("/{id}/publish", name="tweet_publish")
     * @Method("POST")
     */
    function publishAction(Request $request, Tweets $tweet) {

        $em = $this->getDoctrine()->getManager();

        $tweet->setPublish(1);
        $em->persist($tweet);
        $em->flush();

        return $this->redirectToRoute('admin_tweets', array('id' => $tweet->getWall()->getId()));
    }

    /**
     * Unpublish tweet
     *
     * @Route("/{id}/unpublish", name="tweet_unpublish")
     * @Method("POST")
     */
    function unpublishAction(Request $request, Tweets $tweet) {

        $em = $this->getDoctrine()->getManager();

        $tweet->setPublish(0);
        $em->persist($tweet);
        $em->flush();

        return $this->redirectToRoute('admin_tweets', array('id' => $tweet->getWall()->getId()));
    }

    /**
     * Deletes a Tweets entity.
     *
     * @Route("/{id}", name="tweets_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tweets $tweet)
    {
        $form = $this->createDeleteForm($tweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tweet);
            $em->flush();
        }

        return $this->redirectToRoute('tweets_index');
    }

    /**
     * Creates a form to delete a Tweets entity.
     *
     * @param Tweets $tweet The Tweets entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tweets $tweet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tweets_delete', array('id' => $tweet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
