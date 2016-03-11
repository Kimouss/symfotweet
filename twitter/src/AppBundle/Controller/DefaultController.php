<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Abraham\TwitterOAuth\TwitterOAuth;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $oauth = new TwitterOAuth("s2fapmwjTKVbXx3MzmVAXPFyk", "Y9uDfIiWwZR59Vv1WqSwkyO6MYuC9zNHV7WZEDy7lHzA0zyYP8");

        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);
        $search = null;
        $tweets = null;
        $twitter = new TwitterOAuth("s2fapmwjTKVbXx3MzmVAXPFyk", "Y9uDfIiWwZR59Vv1WqSwkyO6MYuC9zNHV7WZEDy7lHzA0zyYP8", null, $accessToken->access_token);
        if (!empty($_GET['box'])) {
            $search = $_GET['box'];
            $tweets = $twitter->get('search/tweets', [
                'q' => $search,
                'exclude_replies' => true,
                'count' => 10
            ]);
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                'tweets' => $tweets->statuses,
                'search' => "Vous avez cherché ".$search,
            ]);
        }
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'tweets' => $tweets,
            'search' => "Commencez votre wall",
        ]);
    }
}
