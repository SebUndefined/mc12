<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 02/10/17
 * Time: 15:51
 */

namespace MC12\AdminBundle\Controller;


use FOS\UserBundle\Form\Type\RegistrationFormType;
use MC12\SubscriptionBundle\Entity\Race;
use MC12\SubscriptionBundle\Entity\Subscription;
use MC12\SubscriptionBundle\Form\RaceType;
use MC12\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends Controller
{
    public function indexAction()
    {

        return $this->render('MC12AdminBundle::index.html.twig');
    }

    public function racesAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('MC12SubscriptionBundle:Race');

        $races = $repository->findAll();

        return $this->render('@MC12Admin/races.html.twig', array(
            'races' => $races
        ));

    }

    public function seeRaceAction(Race $race)
    {
        return $this->render('@MC12Admin/viewRace.html.twig', array(
            'race' => $race
        ));

    }

    public function seeRaceSubscriptionAction(Race $race)
    {
        $repoSubscription = $this->getDoctrine()->getManager()->getRepository('MC12SubscriptionBundle:Subscription');
        $subscription = $repoSubscription->findBy(array('race'=> $race->getId(), 'paymentDone' => true));
        return $this->render('@MC12Admin/viewRaceSubscr.html.twig', array(
            'subscriptions' => $subscription,
            'race' => $race
        ));
    }

    /**
     * @Route("/admin/races/{raceId}/subscription/{subscriptionId}")
     * @param Race $race
     * @param Subscription $subscription
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("race", class="MC12SubscriptionBundle:Race", options={"mapping": {"raceId": "id"}})
     * @ParamConverter("subscription", class="MC12SubscriptionBundle:Subscription", options={"mapping": {"subscriptionId": "id"}})
     *
     *
     */
    public function seeRaceSubscriptionOneAction(Race $race, Subscription $subscription)
    {

        return $this->render('@MC12Admin/viewRaceSubscrOne.html.twig', array(
            'subscription' => $subscription,
            'race' => $race
        ));

    }

    /**
     * @param Race $race
     * @param Subscription $subscription
     * @param Request $request
     * @ParamConverter("race", class="MC12SubscriptionBundle:Race", options={"mapping": {"raceId": "id"}})
     * @ParamConverter("subscription", class="MC12SubscriptionBundle:Subscription", options={"mapping": {"subscriptionId": "id"}})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateRaceSubscriptionAction(Request $request, Race $race, Subscription $subscription)
    {
        if ($subscription->getValidated() == true) {
            $request->getSession()->getFlashBag()->add('alert', 'Inscription déjà validé');
        } else {
            $subscription->setValidated(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($race);
            $em->flush();
            $serviceMailer = $this->get("mc12_core.services.mailer");
            $serviceMailer->sendEmail($subscription, "Inscription Validée !", "@MC12Admin/validateSubscrEmail.html.twig");
            $request->getSession()->getFlashBag()->add('info', 'Inscription validé !');
        }
        return $this->redirectToRoute('mc12_admin_see_race_subscription_one',
            array(
                'raceId' =>$race->getId(),
                'subscriptionId' => $subscription->getId()
            ));
    }
    public function addRaceAction(Request $request)
    {
        $race = new Race();
        $form = $this->get('form.factory')->create(RaceType::class, $race);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($race);
                $em->flush();
                return $this->redirectToRoute('mc12_admin_homepage');
            }
        }


        return $this->render('@MC12Admin/addRace.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function addUserAction()
    {
        $user = new User();
        $form = $this->get('form.factory')->create(RegistrationFormType::class, $user);
        var_dump($user);
        return $this->render('@MC12Admin/addUser.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function activeOrDesactiveAction(Race $race)
    {
        if ($race->getOpen()) {
            $race->setOpen(false);
        }
        else {
            $race->setOpen(true);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($race);
        $em->flush();
        return $this->redirectToRoute('mc12_admin_races');
    }

}