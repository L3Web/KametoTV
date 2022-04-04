<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void

    {
        $builder
            ->add('username', TextType::class, [
                "label" => "Registration.username"
            ])
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Registration.password.invalidMessage',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options' => ['label' => 'Registration.password.notRepeat'],
                    'second_options' => ['label' => 'Registration.password.repeat'],
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Registration.password.blank',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Registration.password.minMessage.debut {{ limit }} Registration.password.minMessage.fin',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ]
            )
            ->add('first_name', TextType::class, [
                "label" => "Registration.firstName"
            ])
            ->add('last_name', TextType::class, [
                "label" => "Registration.lastName"
            ])
            ->add('register', SubmitType::class, [
                "label" => "Registration.register"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
