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

    public function pilotAction(Request $request, Race $race, $id)
    {
        if ($race->getOpen() === false) {
            return $this->redirectToRoute("mc12_subscription_homepage");
        }
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
            //Setting the price depending of the race price
            $subscription->setTotalPrice($subscription->getRace()->getSubscriptionPrice());
            //Checking the licence price
            if ($subscription->getCompetitor()->getLicence()->getType() == "OneDay") {
                $subscription->setTotalPrice(
                    $subscription->getTotalPrice() +
                    $subscription->getRace()->getOneDayLicencePrice());
            }
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
        return $this->render('MC12SubscriptionBundle:Pages:pilot.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function checkoutAction(Request $request) {
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
            //$serviceMail = $this->get("seb_undefined_shop.services.mailer");
            $subscription->setPaymentDone(true);
            $em->flush();
            //$serviceMail->sendEmail($order);
            $request->getSession()->remove("subscriptionId");
            return $this->render('@MC12Subscription/Pages/final.html.twig');
        }catch (Card $exception) {
            return "nope...";
        }

    }

}
