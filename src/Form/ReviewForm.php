<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class ReviewForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
        ->add('comment', TextType::class)
        ->add('note', NumberType::class, ['label' => 'Note(/10)', 'constraints' => [new Range(['min' => 0, 'max' => 10])]])
        ->add('submit', SubmitType::class, ['label' => 'Add review']);
    }
}