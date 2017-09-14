<?php

namespace MC12\SubscriptionBundle\Controller;

use MC12\SubscriptionBundle\Entity\Competitor;
use MC12\SubscriptionBundle\Entity\Race;
use MC12\SubscriptionBundle\Entity\Subscription;
use MC12\SubscriptionBundle\Form\CompetitorType;
use MC12\SubscriptionBundle\Form\SubscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function pilotAction(Request $request, Race $race, $id)
    {
        $subscription = new Subscription();
        $subscription->setRace($race);
        $form = $this->get('form.factory')
            ->createBuilder(SubscriptionType::class, $subscription, array(
                'trait_choices' => $race->getCategories()
            ))->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $session = $request->getSession();
            $session->set('subscription', $subscription);
            return $this->redirectToRoute('mc12_subscription_checkout', array(
                'id' => $race->getId()
            ));
        }
        return $this->render('MC12SubscriptionBundle:Pages:pilot.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function checkoutAction(Request $request) {
        $session = $request->getSession();
        if (!$session->get('subscription')) {
            return $this->redirectToRoute('/subscribe/');
        }
        $subscription = $session->get('subscription');
        die(var_dump($subscription));

    }

}
