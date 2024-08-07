<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TJType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('process_number', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Process number is required',
                    ]),
                ],
            ])
            ->add('tj_uf', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'TJ UF is required',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
