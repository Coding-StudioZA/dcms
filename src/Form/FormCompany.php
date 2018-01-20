<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;


class FormCompany extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company_name', TextareaType::class)
            ->add('name', TextareaType::class, ['required' => false])
            ->add('surname', TextareaType::class, ['required' => false])
            ->add('telephone', TextareaType::class, ['required' => false])
            ->add('cellphone', TextareaType::class, ['required' => false])
            ->add('email', TextareaType::class, ['required' => false])
            ->add('save', SubmitType::class, ['label' => 'Zapisz']);
    }

}