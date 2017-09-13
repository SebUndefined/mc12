<?php

namespace MC12\SubscriptionBundle\Form;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetitorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('birthDate', DateType::class, array(
                'attr' => ['class' => 'datepicker'],
                'format' => 'dd/MM/yyyy',
                'input' => 'datetime',
                'html5' => false,
                'widget' => 'single_text',
            ))
            ->add('adressComp', TextType::class, array(
                'required' => false
            ))
            ->add('address', TextType::class)
            ->add('postalCode', TextType::class)
            ->add('city', TextType::class)
            ->add('country', CountryType::class)
            ->add('nationality', CountryType::class)
            ->add('phone', TextType::class)
            ->add('email', EmailType::class)
            ->add('licence', LicenceType::class)
            ->add('motorbike', MotorbikeType::class)
            ->add('club', ClubType::class)
            ->add('driveLicence', DriveLicenceType::class)
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
            'data_class' => 'MC12\SubscriptionBundle\Entity\Competitor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mc12_subscriptionbundle_competitor';
    }


}
