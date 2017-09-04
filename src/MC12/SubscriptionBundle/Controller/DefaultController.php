<?php

namespace MC12\SubscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MC12SubscriptionBundle:Default:index.html.twig');
    }
}
