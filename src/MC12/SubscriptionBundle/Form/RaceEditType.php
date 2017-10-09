<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 09/10/17
 * Time: 17:08
 */

namespace MC12\SubscriptionBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RaceEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('dateBegin')
            ->remove('dateEnd');
    }
    public function getParent()
    {
        return RaceType::class;
    }

}