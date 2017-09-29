<?php

namespace MC12\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MC12CoreBundle:Default:index.html.twig');
    }
}
