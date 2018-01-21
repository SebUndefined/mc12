<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 07/10/17
 * Time: 08:54
 */

namespace MC12\CoreBundle\Service;


use MC12\SubscriptionBundle\Entity\Subscription;

class Mailer
{

    private $mailer;
    private  $templating;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    public function sendEmail(Subscription $subscription, $subject, $view) {
        $message = new \Swift_Message("Sujet");
        $message->setFrom("mc12@sebundefined.fr");
        $message->setTo($subscription->getCompetitor()->getEmail());
        $message->setSubject("MC12 -  " .$subject);
        $message->setBody(
            $this->templating->render(
                $view,
                array('subscription' => $subscription))
        );
        $message->setContentType('text/html');


        $this->mailer->send($message);
    }

}