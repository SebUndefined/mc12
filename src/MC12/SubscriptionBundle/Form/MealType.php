<?php

namespace MC12\SubscriptionBundle\Form;

use MC12\SubscriptionBundle\Repository\MealRepository;
use MC12\SubscriptionBundle\Repository\StageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
            ->add('place', TextType::class)
            ->add('price', NumberType::class)
            ->add('stage', EntityType::class, array(
                'class' => 'MC12\SubscriptionBundle\Entity\Stage',
                'choice_label' => 'name',
                'multiple' => false,
                'choices' => $options['stage']
            ))
            ->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MC12\SubscriptionBundle\Entity\Meal',
            'stage' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mc12_subscriptionbundle_meal';
    }


}
