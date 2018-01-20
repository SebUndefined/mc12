<?php

namespace MC12\SubscriptionBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use MC12\SubscriptionBundle\Entity\Race;
use MC12\SubscriptionBundle\Entity\Subscription;
use MC12\SubscriptionBundle\Entity\SubscriptionMeal;
use MC12\SubscriptionBundle\Form\SubscriptionType;
use MC12\SubscriptionBundle\Stripe\ConfigStripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionController extends Controller
{
    public function indexAction()
    {
        //Purge of the subscriptions that are not paid and before than 1 day ago
        $repository = $this->getDoctrine()->getManager()->getRepository('MC12SubscriptionBundle:Race');
        $races = $repository->findAll();
        return $this->render('MC12SubscriptionBundle:Pages:index.html.twig', array(
            'races' => $races
        ));
    }

    /**
     * @param Request $request
     * @param Race $race
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function pilotAction(Request $request, Race $race)
    {
        if ($race->getOpen() === false) {
            $request->getSession()->getFlashBag()->add('alert', 'Inscription impossible à cette course !');
            return $this->redirectToRoute("mc12_subscription_homepage");
        }
        $subscription = new Subscription();
        $subscription->setRace($race);
        $mealsAvailable = $this->getDoctrine()
            ->getManager()
            ->getRepository('MC12SubscriptionBundle:Meal')
            ->findAllByRaceId($race->getId());
        $mealsSubscription = new ArrayCollection();
        foreach ($mealsAvailable as $meal) {
            $mealSubscription = new SubscriptionMeal();
            $mealSubscription->setMeal($meal);
            $mealSubscription->setSubscription($subscription);
            $mealsSubscription->add($mealSubscription);
        }
        $subscription->setSubscriptionMeals($mealsSubscription);
        //die(var_dump($race->__load()));
        $raceCategories = $this->getDoctrine()
        ->getManager()
        ->getRepository('MC12SubscriptionBundle:RaceCategory')
        ->findBy(array('race' => $race, 'available' => true));
        $categories = new ArrayCollection();
        foreach ($raceCategories as $raceCategory) {
            $categories->add($raceCategory->getCategory());
        }
        $form = $this->get('form.factory')
            ->createBuilder(SubscriptionType::class, $subscription, array(
                'categories' => $categories,
            ))->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $session = $request->getSession();
                //die(var_dump($subscription->getCompetitor()));
                //Setting the price depending of the category Price
                $raceCategory = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('MC12SubscriptionBundle:RaceCategory')
                    ->findOneBy(array('race' => $race, 'category' => $subscription->getCompetitor()->getCategory()));
                $subscription->setTotalPrice($raceCategory->getPrice());

                //Calculating price of the order
                foreach ($subscription->getSubscriptionMeals() as $meal) {
                    $price = $meal->getMeal()->getPrice();
                    $subscription->setTotalPrice($subscription->getTotalPrice() + $price * $meal->getNumber());
                }
                //Saving the subscription
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($subscription);

                $entityManager->flush();
                //set the Id in session
                $session->set("subscriptionId", $subscription->getId());
                return $this->redirectToRoute('mc12_subscription_checkout', array(
                    'id' => $race->getId()
                ));
            }

        }
        return $this->render('MC12SubscriptionBundle:Pages:pilot.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function checkoutAction(Race $race, Request $request) {
        $session = $request->getSession();
        if (!$session->get('subscriptionId')) {
            return $this->redirectToRoute('mc12_subscription_homepage');
        }
        else {
            $subscriptionId = $session->get('subscriptionId');
        }
        $repository = $this->getDoctrine()->getManager()->getRepository('MC12SubscriptionBundle:Subscription');
        $subscription = $repository->find($subscriptionId);
        return $this->render('MC12SubscriptionBundle:Pages:checkout.html.twig', array(
            'subscription' =>$subscription,
        ));
    }

    public function finalAction(Request $request) {
        $session = $request->getSession();
        if (!$session->get('subscriptionId')) {
            return $this->redirectToRoute('mc12_subscription_homepage');
        }
        $subscriptionId = $session->get('subscriptionId');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('MC12SubscriptionBundle:Subscription');
        $subscription = $repository->find($subscriptionId);
        $stripeConfig = new ConfigStripe();
        Stripe::setApiKey($stripeConfig->getPrivKey());
        $theToken = $_POST['stripeToken'];
        $email = $_POST['stripeEmail'];
        $customer = Customer::create(array(
            'email'=> $email,
            'source' => $theToken
        ));
        try {
            Charge::create(array(
                'customer' =>$customer->id,
                'amount' => $subscription->getTotalPrice() * 100,
                'currency' => 'eur'
            ));
            $serviceMail = $this->get("mc12_core.services.mailer");
            $subscription->setPaymentDone(true);
            $em->flush();
            $serviceMail->sendEmail($subscription, "Commande confirmée !", '@MC12Subscription/Pages/validateOrderEmail.html.twig');
            $request->getSession()->remove("subscriptionId");
            return $this->render('@MC12Subscription/Pages/final.html.twig');
        }catch (Card $exception) {
            return $this->render('@MC12Subscription/Pages/finalErr.html.twig',
                array(
                    'error' => $exception
                ));
        }


    }

}
