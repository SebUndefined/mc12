<?php

namespace MC12\SubscriptionBundle\Controller;

use MC12\SubscriptionBundle\Entity\Competitor;
use MC12\SubscriptionBundle\Form\CompetitorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class SubscriptionController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('MC12SubscriptionBundle:Race');
        $races = $repository->findAll();
        return $this->render('MC12SubscriptionBundle:Pages:index.html.twig', array(
            'races' => $races
        ));
    }

    public function pilotAction()
    {
        $competitor = new Competitor();
        $form = $this->get('form.factory')->create(CompetitorType::class, $competitor);
        $repository = $this->getDoctrine()->getManager()->getRepository('MC12SubscriptionBundle:Race');
        $races = $repository->findAll();
        return $this->render('MC12SubscriptionBundle:Pages:pilot.html.twig', array(
            'form' => $form->createView()
        ));
    }



}
