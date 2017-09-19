<?php

namespace MC12\SubscriptionBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use MC12\SubscriptionBundle\Entity\Race;
use MC12\SubscriptionBundle\Entity\Subscription;
use MC12\SubscriptionBundle\Entity\SubscriptionMeal;
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
        $mealsAvailable = $this->getDoctrine()
            ->getManager()
            ->getRepository('MC12SubscriptionBundle:Meal')
            ->findAllByRaceId($id);
        $mealsSubscription = new ArrayCollection();
        foreach ($mealsAvailable as $meal) {
            $mealSubscription = new SubscriptionMeal();
            $mealSubscription->setMeal($meal);
            $mealSubscription->setSubscription($subscription);
            $mealsSubscription->add($mealSubscription);
        }
        $subscription->setSubscriptionMeals($mealsSubscription);
        $form = $this->get('form.factory')
            ->createBuilder(SubscriptionType::class, $subscription, array(
                'trait_choices' => $race->getCategories(),
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
        //die(var_dump($subscription->getSubscriptionMeals()));
        $subscription->setTotalPrice($subscription->getRace()->getSubscriptionPrice());
        if ($subscription->getCompetitor()->getLicence()->getType() == "OneDay") {
            $subscription->setTotalPrice(
                $subscription->getTotalPrice() +
                $subscription->getRace()->getOneDayLicencePrice());
        }
        foreach ($subscription->getSubscriptionMeals() as $meal) {
            $price = $meal->getMeal()->getPrice();
            $subscription->setTotalPrice($subscription->getTotalPrice() + $price * $meal->getNumber());
        }
        return $this->render('MC12SubscriptionBundle:Pages:checkout.html.twig', array(
            'subscription' =>$subscription,
        ));
    }

    public function finalAction(Request $request) {
        $session = $request->getSession();
        if (!$session->get('subscription')) {
            return $this->redirectToRoute('/subscribe/');
        }
        $subscription = $session->get('subscription');
        //die(var_dump($subscription->getCompetitor()->getCategory()));
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($subscription);

        $entityManager->flush();
        die(var_dump($subscription));
    }

}
