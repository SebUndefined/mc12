<?php

namespace MC12\SubscriptionBundle\Form;

use MC12\SubscriptionBundle\Entity\Race;
use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'required' => true
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
            ->add('group', TextType::class)
            ->add('licence', LicenceType::class)
            ->add('motorbike', MotorbikeType::class)
            ->add('club', ClubType::class)
            ->add('driveLicence', DriveLicenceType::class)
            ->add('category', EntityType::class, array(
                'class'     => 'MC12\SubscriptionBundle\Entity\Category',
                'choice_label' => 'name',
                'choices' => $options['categories'],
                'expanded'  => true,
                'multiple'  =>false
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MC12\SubscriptionBundle\Entity\Competitor',
            'categories' => null
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
