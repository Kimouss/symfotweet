<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use Abraham\TwitterOAuth\TwitterOAuth;
use AppBundle\Entity\User;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class UserController extends Controller
{
    /**
     * @Route("twitter/link", name="twitter_link")
     */
    public function twitterAction(Request $request)
    {
        $request_token = [];
        $session = new Session();
        $request_token['oauth_token'] = $session->get('client_id');
        $request_token['oauth_token_secret'] = $session->get('client_server');
        if (empty($_GET['oauth_token']) || $request_token['oauth_token'] !== $_GET['oauth_token']) {
            return $this->redirectToRoute('fos_user_profile_show');
        } else {
            $connection = new TwitterOAuth("s2fapmwjTKVbXx3MzmVAXPFyk", "Y9uDfIiWwZR59Vv1WqSwkyO6MYuC9zNHV7WZEDy7lHzA0zyYP8", $request_token['oauth_token'], $request_token['oauth_token_secret']);
            $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
            $em = $this->getDoctrine()->getManager();
            $id = $this->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($id);
            $user->setTwitter(1)->setClientId($access_token['oauth_token'])->setClientSecret($access_token['oauth_token_secret']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('fos_user_profile_show');
        }
    }
}
