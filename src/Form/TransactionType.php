<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender',EntityType::class,['class'=>'App\Entity\User','choice_label'=>'sender'])
            ->add('receiver',EntityType::class,['class'=>'App\Entity\User','choice_label'=>'receiver'])
            ->add('amount',NumberType::class)
            ->add('comment',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Transaction::class,
        ]);
    }
}
