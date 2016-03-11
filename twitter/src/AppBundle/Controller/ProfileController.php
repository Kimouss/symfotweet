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

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $connection = new TwitterOAuth("s2fapmwjTKVbXx3MzmVAXPFyk", "Y9uDfIiWwZR59Vv1WqSwkyO6MYuC9zNHV7WZEDy7lHzA0zyYP8", $user->getClientId(), $user->getClientSecret());
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => "http://127.0.0.1:8000/twitter/link"));
        $content = $connection->get("account/verify_credentials");

        if ($user->getTwitter() != 1) {

            $session = new Session();
            $session->set('client_id', $request_token['oauth_token']);
            $session->set('client_server', $request_token['oauth_token_secret']);

            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
            return $this->render('FOSUserBundle:Profile:show.html.twig', array(
                'user' => $user,
                'url' => $url,
            ));
        } else {
            return $this->render('FOSUserBundle:Profile:show.html.twig', array(
                'user' => $user,
                'userTwitter' => $content,
            ));
        }
    }
}
