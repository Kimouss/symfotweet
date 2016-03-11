<?php

namespace WallBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WallBundle\Entity\wall;
use WallBundle\Form\wallType;
use Abraham\TwitterOAuth\TwitterOAuth;
use AppBundle\Entity\User;
use WallBundle\Entity\Tweets;
use WallBundle\Form\TweetsType;

/**
 * wall controller.
 *
 * @Route("/wall")
 */
class wallController extends Controller
{
    /**
     * Lists all wall entities.
     *
     * @Route("/", name="wall_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $walls = $em->getRepository('WallBundle:wall')->findBy(array('user' => $currentUser->getId()));

        return $this->render('wall/index.html.twig', array(
            'walls' => $walls,
        ));
    }

    /**
     * Creates a new wall entity.
     *
     * @Route("/new", name="wall_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $wall = new wall();
        $form = $this->createForm('WallBundle\Form\wallType', $wall);
        $form->handleRequest($request);
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $wall->setUser($this->getUser());
            $em->persist($wall);
            $em->flush();

            return $this->redirectToRoute('wall_show', array('id' => $wall->getId()));
        }

        return $this->render('wall/new.html.twig', array(
            'wall' => $wall,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a wall entity.
     *
     * @Route("/{id}", name="wall_show")
     * @Method("GET")
     */
    public function showAction(wall $wall)
    {
        $oauth = new TwitterOAuth("s2fapmwjTKVbXx3MzmVAXPFyk", "Y9uDfIiWwZR59Vv1WqSwkyO6MYuC9zNHV7WZEDy7lHzA0zyYP8");

        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);
        $tweets = null;
        if($wall->getTypeSearch() === "key") {
            $search = $wall->getSearch();
        } else {
            $search = $wall->getTypeSearch() . $wall->getSearch();
        }
        $twitter = new TwitterOAuth("s2fapmwjTKVbXx3MzmVAXPFyk", "Y9uDfIiWwZR59Vv1WqSwkyO6MYuC9zNHV7WZEDy7lHzA0zyYP8", null, $accessToken->access_token);
        $tweets = $twitter->get('search/tweets', [
            'q' => $search,
            'exclude_replies' => true,
            'count' => 20
        ]);

        if ($wall->getAdmin() === true) {
            return $this->adminTrue($tweets, $wall, $search);
        } else {
            return $this->adminFalse($tweets, $wall, $search);
        }
    }

    /**
     * Set publish 1 quand administrable
     *
     * @param $tweets
     * @param $wall
     * @param $search
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function adminTrue($tweets, $wall, $search)
    {
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($wall);
        for($i = 0; $i < count($tweets->statuses); $i++) {
            ${'tweet'.$i }= new Tweets();
            $em = $this->getDoctrine()->getManager();
            ${'tweet'.$i }->setWall($wall)
                ->setUserTweet($tweets->statuses[$i]->user->screen_name)
                ->setTweet($tweets->statuses[$i]->text)
                ->setDate($tweets->statuses[$i]->created_at)
                ->setPublish(0);
            $em->persist(${'tweet'.$i });
            $em->flush();
        }
        $tweets = $this->getDoctrine()
            ->getRepository('WallBundle:Tweets')
            ->findBy(array('wall' => $wall));

        return $this->render('wall/show.html.twig', [
            'tweets' => $tweets,
            'wall' => $wall,
            'user' => $user,
            'search' => $search,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Delete tweet before push database when admin false
     */
    function deleteFalse($wall) {

        $em = $this->getDoctrine()->getRepository('WallBundle:Tweets');
        $tweets = $em->findBy(array('wall' => $wall->getId()));
        for($i = 0; $i < count($tweets); $i++) {
            $toto = $em->findBy(array('id' => $tweets[$i]->getId()));
            exit(dump($toto[0]));
            $em->remove($toto[0]);
            $em->flush();
        }
    }

    /**
     * set publish 0 quand non administrable
     *
     * @param $tweets
     * @param $wall
     * @param $search
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function adminFalse($tweets, $wall, $search)
    {
        $user = $this->getUser();
        $deleteForm = $this->createDeleteForm($wall);

        for($i = 0; $i < count($tweets->statuses); $i++) {
            ${'tweet'.$i }= new Tweets();
            $em = $this->getDoctrine()->getManager();
            ${'tweet'.$i }->setWall($wall)
                ->setUserTweet($tweets->statuses[$i]->user->screen_name)
                ->setTweet($tweets->statuses[$i]->text)
                ->setDate($tweets->statuses[$i]->created_at)
                ->setPublish(1);
            $em->persist(${'tweet'.$i });
            $em->flush();
        }
        $tweets = $this->getDoctrine()
            ->getRepository('WallBundle:Tweets')
            ->findBy(array('wall' => $wall));

        return $this->render('wall/show.html.twig', [
            'tweets' => $tweets,
            'wall' => $wall,
            'user' => $user,
            'search' => $search,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Gestion de tweets par mur
     *
     * @Route("/{id}/tweets", name="admin_tweets")
     * @Method({"GET", "POST"})
     */
    public function adminTweetsAction(Request $request, wall $wall)
    {

        $em = $this->getDoctrine()->getManager();
        $tweets = $em->getRepository('WallBundle:Tweets')->findBy(array('wall' => $wall->getId()));

        return $this->render('tweets/index.html.twig', array(
            'tweets' => $tweets,
        ));
    }

    /**
     * Displays a form to edit an existing wall entity.
     *
     * @Route("/{id}/edit", name="wall_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, wall $wall)
    {
        $deleteForm = $this->createDeleteForm($wall);
        $editForm = $this->createForm('WallBundle\Form\wallType', $wall);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wall);
            $em->flush();

            return $this->redirectToRoute('wall_edit', array('id' => $wall->getId()));
        }

        return $this->render('wall/edit.html.twig', array(
            'wall' => $wall,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wall entity.
     *
     * @Route("/{id}", name="wall_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, wall $wall)
    {
        $form = $this->createDeleteForm($wall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wall);
            $em->flush();
        }

        return $this->redirectToRoute('wall_index');
    }

    /**
     * Creates a form to delete a wall entity.
     *
     * @param wall $wall The wall entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(wall $wall)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wall_delete', array('id' => $wall->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
