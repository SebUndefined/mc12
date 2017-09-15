<?php

namespace MC12\SubscriptionBundle\Form;

use MC12\SubscriptionBundle\Entity\MotorBikeBrandEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotorbikeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, array(
                'required' => true,
                'choices' => MotorBikeBrandEnum::getAvailableTypes(),
                'attr' => array('class' => 'brandType'),
                'choice_label' => function($choice) {
                    return MotorBikeBrandEnum::getTypeName($choice);
                }
            ))
            ->add('cylinder')
            ->add('registrationNumber')
            ->add('insurance', InsuranceType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MC12\SubscriptionBundle\Entity\Motorbike'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mc12_subscriptionbundle_motorbike';
    }


}
