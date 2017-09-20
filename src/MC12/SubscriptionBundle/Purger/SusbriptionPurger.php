<?php

namespace MC12\SubscriptionBundle\Purger;

use Doctrine\ORM\EntityManagerInterface;

class SusbriptionPurger
{


    private $entityManager;

    /**
     * SusbriptionPurger constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function purge($days) {
        $date = new \DateTime($days.' days ago');
        $subscriptionsList = $this->entityManager
            ->getRepository('MC12SubscriptionBundle:Subscription')
            ->getSusbscriptionBefore($date);
        foreach ($subscriptionsList as $subscription) {
            $this->entityManager->remove($subscription);
        }

        $this->entityManager->flush();
    }

}