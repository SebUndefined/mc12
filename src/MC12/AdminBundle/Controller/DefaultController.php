<?php

namespace MC12\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MC12AdminBundle:Default:index.html.twig');
    }
}
