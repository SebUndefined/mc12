<?php

namespace MC12\SubscriptionBundle\Repository;

/**
 * SubscriptionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubscriptionRepository extends \Doctrine\ORM\EntityRepository
{

    public function getSusbscriptionBefore(\DateTime $date) {
        return $this->createQueryBuilder('subscription')
            ->where('subscription.creationDate <= :date')
            ->andWhere('subscription.paymentDone = false')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }
}
