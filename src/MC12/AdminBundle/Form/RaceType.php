<?php

namespace MC12\AdminBundle\Form;

use Doctrine\DBAL\Types\DecimalType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('dateBegin', DateType::class, array(
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyyy',
                'input' => 'datetime',
                'html5' => false,
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('dateEnd', DateType::class, array(
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyyy',
                'input' => 'datetime',
                'html5' => false,
                'widget' => 'single_text',
                'required' => false
            ))
            ->add('open', CheckboxType::class)
            ->add('competitorSize', NumberType::class)
            ->add('subscriptionPrice', NumberType::class)
            ->add('oneDayLicencePrice', NumberType::class)
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save')
            ))
            ->add('categories', EntityType::class, array(
                'class' => 'MC12\SubscriptionBundle\Entity\Category',
                'choice_label' => 'name',
                'multiple' => true,

            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MC12\SubscriptionBundle\Entity\Race'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mc12_subscriptionbundle_race';
    }


}
