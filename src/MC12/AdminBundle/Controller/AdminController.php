<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 02/10/17
 * Time: 15:51
 */

namespace MC12\AdminBundle\Controller;


use MC12\AdminBundle\Form\RegistrationType;
use MC12\SubscriptionBundle\Entity\Meal;
use MC12\SubscriptionBundle\Entity\Race;
use MC12\SubscriptionBundle\Entity\Stage;
use MC12\SubscriptionBundle\Entity\Subscription;
use MC12\SubscriptionBundle\Form\MealType;
use MC12\SubscriptionBundle\Form\RaceEditType;
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
            'races' => $races,
        ));

    }

    public function seeRaceAction(Race $race)
    {
        return $this->render('@MC12Admin/viewRace.html.twig', array(
            'race' => $race
        ));
    }

    public function seeRaceSubscriptionAction(Race $race, Request $request)
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
                $startDate = $race->getDateBegin();
                $endDate = $race->getDateEnd()->modify('+1 day');
                $intervalDate = \DateInterval::createFromDateString('1 day');
                $racePeriod = new \DatePeriod($startDate, $intervalDate, $endDate);
                $i = 1;
                foreach ($racePeriod as $dt) {
                    $stage = new Stage();
                    $stage->setBeginDate($dt);
                    $stage->setEndDate($dt);
                    $stage->setName('Jour ' . $i);
                    $stage->setRace($race);
                    $race->getStages()->add($stage);
                    $i++;
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($race);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', 'Course ajoutée !');
                return $this->redirectToRoute('mc12_admin_homepage');
            }
        }
        return $this->render('@MC12Admin/addRace.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function editRaceAction(Race $race, Request $request)
    {
        $form = $this->get('form.factory')->create(RaceEditType::class, $race);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($race);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', 'Course modifiée');
                return $this->redirectToRoute('mc12_admin_see_race', array(
                   'id' => $race->getId()
                ));
            }
        }
        return $this->render('@MC12Admin/editRace.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function addUserAction(Request $request)
    {
        $user = new User();
        $form = $this->get('form.factory')->create(RegistrationType::class, $user);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $userManager = $this->get('fos_user.user_manager');
                $user->setEnabled(true);
                $userManager->updateUser($user);
                $request->getSession()->getFlashBag()->add('info', 'Utilisateur ajouté');
                return $this->redirectToRoute('mc12_admin_user');
            }
        }
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

    public function addMealAction(Race $race, Request $request)
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal, array(
            'stage' => $race->getStages(),
        ));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($meal);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', 'Repas ajouté !');
                return $this->redirectToRoute('mc12_admin_see_race', array(
                    'id' => $race->getId()
                ));
            }
        }
        return $this->render('@MC12Admin/addMeal.html.twig', array(
            'form' => $form->createView()
        ));

    }


    public function UserAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('MC12UserBundle:User');

        $users = $repository->findAll();

        return $this->render('@MC12Admin/user.html.twig', array(
            'users' => $users
        ));
    }

}