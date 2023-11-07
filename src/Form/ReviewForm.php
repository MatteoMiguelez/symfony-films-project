<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ReviewForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
        ->add('comment', TextType::class)
        ->add('note', NumberType::class)
        ->add('submit', SubmitType::class, ['label' => 'Add review']);
    }
}