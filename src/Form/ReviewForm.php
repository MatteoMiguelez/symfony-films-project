<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ReviewForm
{
    public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
        ->add('review', TextType::class)
        ->add('rating', NumberType::class)
        ->add('submit', SubmitType::class, ['label' => 'Search']);
    }
}