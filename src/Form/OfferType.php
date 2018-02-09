<?php
/**
 * Created by PhpStorm.
 * User: loegel
 * Date: 19/01/18
 * Time: 15:26
 */

namespace App\Form;

use App\Entity\Ticket;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ticket',EntityType::class,['class'=>'App\Entity\Ticket','choice_label'=>'id'])
            ->add('user',EntityType::class,['class'=>'App\Entity\User','choice_label'=>'id'])
            ->add('insurance',CheckboxType::class)
            ->add('time',TimeType::class)
            ->add('amount',IntegerType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Ticket::class,
        ]);
    }
}