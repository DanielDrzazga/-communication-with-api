<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'disabled' => true,
                    'required' => false,
                ],
            ])
            ->add('currency', TextType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('estimatedRevenue', NumberType::class)
            ->add('adImpressions', NumberType::class)
            ->add('adEcpm', NumberType::class)
            ->add('clicks', NumberType::class)
            ->add('adCTR', NumberType::class)
            ->add('url', AdUrlsType::class)
            ->add('tag', AdTagsType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
