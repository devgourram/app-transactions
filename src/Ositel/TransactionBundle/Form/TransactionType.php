<?php

namespace Ositel\TransactionBundle\Form;

use Ositel\TransactionBundle\Entity\Category;
use Ositel\TransactionBundle\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('amount', MoneyType::class)
            ->add('isValid', CheckboxType::class)
            ->add('isOutput', CheckboxType::class)
            ->add('isInput', CheckboxType::class)
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'empty_data' => 'Select your category',
                'placeholder' => 'Select your choice',
                'required' => false
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ositel\TransactionBundle\Entity\Transaction'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ositel_transactionbundle_transaction';
    }


}
