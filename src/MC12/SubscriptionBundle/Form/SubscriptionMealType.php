<?php

namespace MC12\SubscriptionBundle\Form;

use MC12\SubscriptionBundle\Entity\SubscriptionMeal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionMealType extends AbstractType
{
    private $label;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($builder)
            {
                $form = $event->getForm();
                $suscriptionMeal = $event->getData();
                //
                if ($suscriptionMeal instanceof SubscriptionMeal) {
                    $suscriptionMeal = $suscriptionMeal->getMeal();
                    $this->label = $suscriptionMeal->getPlace()
                        . " " . $suscriptionMeal->getStage()->getName()
                        . " " . $suscriptionMeal->getPrice() . " €";
                    $form->add('number', NumberType::class, array(
                        'label' => $this->label,
                    ) );
                }

            }
        );


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MC12\SubscriptionBundle\Entity\SubscriptionMeal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mc12_subscriptionbundle_subscriptionmeal';
    }


}
