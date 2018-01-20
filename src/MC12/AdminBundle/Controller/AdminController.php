<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 02/10/17
 * Time: 15:51
 */

namespace MC12\AdminBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use MC12\AdminBundle\Form\RegistrationType;
use MC12\SubscriptionBundle\Entity\Category;
use MC12\SubscriptionBundle\Entity\Meal;
use MC12\SubscriptionBundle\Entity\Race;
use MC12\SubscriptionBundle\Entity\RaceCategory;
use MC12\SubscriptionBundle\Entity\Stage;
use MC12\SubscriptionBundle\Entity\Subscription;
use MC12\SubscriptionBundle\Entity\SubscriptionMeal;
use MC12\SubscriptionBundle\Form\CategoryType;
use MC12\SubscriptionBundle\Form\MealType;
use MC12\SubscriptionBundle\Form\RaceCategoryType;
use MC12\SubscriptionBundle\Form\RaceEditType;
use MC12\SubscriptionBundle\Form\RaceType;
use MC12\SubscriptionBundle\Form\SubscriptionType;
use MC12\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


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
	    $param = [];
	    $param['race'] = $race->getId();
    	if ($request->query->get('payment') == "false") {
		    $param['paymentDone'] = false;
	    }

	    if ($request->query->get('validated') == "false") {
		    $param['validated'] = false;
        }

	    $subscription = $repoSubscription->findBy($param);

        return $this->render('@MC12Admin/viewRaceSubscr.html.twig', array(
            'subscriptions' => $subscription,
            'race' => $race
        ));
    }

	public function seeRaceSubscriptionAddAction(Request $request, Race $race) {
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
				$subscription->setPaymentDone(true);
				//Saving the subscription
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($subscription);

				$entityManager->flush();
				//set the Id in session
				$session->set("subscriptionId", $subscription->getId());
				return $this->redirectToRoute('mc12_admin_see_race_subscription_one', array(
					'subscriptionId' => $subscription->getId(),
					'raceId' => $race->getId()

				));
			}

		}
		return $this->render('MC12AdminBundle::pilot.html.twig', array(
			'form' => $form->createView()
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
     * @param Request $request
     * @param Race $race
     * @param Subscription $subscription
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("race", class="MC12SubscriptionBundle:Race", options={"mapping": {"raceId": "id"}})
     * @ParamConverter("subscription", class="MC12SubscriptionBundle:Subscription", options={"mapping": {"subscriptionId": "id"}})
     */
    public function seeRaceSubscriptionOneEditAction(Request $request, Race $race, Subscription $subscription)
    {
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
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($subscription);

                $entityManager->flush();
                //set the Id in session
                return $this->redirectToRoute('mc12_admin_see_race_subscription_one', array(
                    'raceId' => $subscription->getRace()->getId(),
                    'subscriptionId' => $subscription->getId()
                ));
            }
        }
        return $this->render('MC12AdminBundle::pilot.html.twig', array(
            'form' => $form->createView()
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
    public function addCategoryToRaceAction(Race $race, Request $request)
    {
        $raceCategory = new RaceCategory();
        $raceCategory->setRace($race);
        $form = $this->createForm(RaceCategoryType::class, $raceCategory);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($raceCategory);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', 'Catégorie ajouté !');
                return $this->redirectToRoute('mc12_admin_see_race', array(
                    'id' => $race->getId()
                ));
            }
        }
        return $this->render('@MC12Admin/addCategorytoRace.html.twig', array(
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

    /**
     * @param Race $race
     * @return string
     * @ParamConverter("race", class="MC12SubscriptionBundle:Race", options={"mapping": {"raceId": "id"}})
     */
    public function exportSubscriptionOfRaceAction(Race $race) {
        $repoSubscription = $this->getDoctrine()->getManager()->getRepository('MC12SubscriptionBundle:Subscription');
        $subscriptions = $repoSubscription->findBy(array('race'=> $race->getId(), 'paymentDone' => true, 'validated' => true));

        $response = new StreamedResponse();
        $response->setCallback(function () use ($subscriptions){
            $handler = fopen('php://output', 'w+');
            fputcsv($handler,
                ['id',
                    'Nom',
                    'Prénom',
                    'Date de naissance',
                    'Complément Adresse',
                    'Adresse',
                    'Code Postal',
                    'Ville',
                    'Pays',
                    'Nationalité',
                    'Tel',
                    'Email',
                    'Groupe',
                    'Licence Type',
                    'Licence Numéro',
                    'Marque Moto',
                    'Cylindré moto',
                    'Immatriculation',
                    'Companie assurance',
                    'Numéro Assurance',

                    ],
                ";");
            foreach ($subscriptions as $subscription) {
                fputcsv($handler,
                    array(
                        $subscription->getId(),
                        $subscription->getCompetitor()->getFirstName(),
                        $subscription->getCompetitor()->getLastName(),
                        $subscription->getCompetitor()->getBirthDate()->format('d-m-Y'),
                        $subscription->getCompetitor()->getAdressComp(),
                        $subscription->getCompetitor()->getAddress(),
                        $subscription->getCompetitor()->getPostalCode(),
                        $subscription->getCompetitor()->getCity(),
                        $subscription->getCompetitor()->getCountry(),
                        $subscription->getCompetitor()->getNationality(),
                        $subscription->getCompetitor()->getPhone(),
                        $subscription->getCompetitor()->getEmail(),
                        $subscription->getCompetitor()->getGroup(),
                        $subscription->getCompetitor()->getLicence()->getType(),
                        $subscription->getCompetitor()->getLicence()->getNumber(),
                        $subscription->getCompetitor()->getMotorbike()->getBrand(),
                        $subscription->getCompetitor()->getMotorbike()->getCylinder(),
                        $subscription->getCompetitor()->getMotorbike()->getRegistrationNumber(),
                        $subscription->getCompetitor()->getMotorbike()->getInsurance()->getInsuranceCompanyName(),
                        $subscription->getCompetitor()->getMotorbike()->getInsurance()->getInsuranceRegistrationNumber(),

                        ),
                    ";");
            }
            fclose($handler);

        });
        //die(var_dump($subscriptions));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition','attachment; filename="export-users.csv"');

        return $response;
    }

    public function disableCategoryAction(RaceCategory $raceCategory) {

        if ($raceCategory->getAvailable() === true) {
            $raceCategory->setAvailable(false);
        }
        else {
            $raceCategory->setAvailable(true);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($raceCategory);
        $em->flush();
        return $this->redirectToRoute('mc12_admin_see_race', array(
            'id' =>$raceCategory->getRace()->getId(),
        ));
    }

}