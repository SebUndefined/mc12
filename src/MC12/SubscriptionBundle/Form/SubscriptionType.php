<?php

namespace MC12\SubscriptionBundle\Form;

use MC12\SubscriptionBundle\Entity\SubscriptionMeal;
use MC12\SubscriptionBundle\Repository\MealRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->traitChoices = $options['trait_choices'];

        $builder->add('competitor', CompetitorType::class, array(
            'trait_choices' => $this->traitChoices
        ))
            ->add('subscriptionMeals', CollectionType::class, array(
                'entry_type' => SubscriptionMealType::class,
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('save', SubmitType::class, array(
            'attr' => array('class' => 'save')
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MC12\SubscriptionBundle\Entity\Subscription',
            'trait_choices' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mc12_subscriptionbundle_subscription';
    }


}
