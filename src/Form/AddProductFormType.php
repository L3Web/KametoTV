<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_name', TextType::class ,[
                "label" => "AddProduct.name"
            ])
            ->add('price', TextType::class ,[
                "label" => "AddProduct.price"
            ])
            ->add('product_qtt', TextType::class ,[
                "label" => "AddProduct.productqtt"
            ])
            ->add('category_id', ChoiceType::class ,[
                'choices' => [
                    'Vetement' => 1,
                    'Autre' => 2,
                ],
            ])
            ->add('product_desc', TextType::class ,[
                "label" => "Description"
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (JPG)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

            ])
            ->add('Add', SubmitType::class,[
                'label' => 'AddProduct.add'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'translation_domain' => 'forms'
        ]);
    }
}
