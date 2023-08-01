<?php

namespace App\Form;

use App\Entity\MenuLink;
use App\Entity\PagesList;
use App\Entity\PostsList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NavUpdateLinkFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order_link', HiddenType::class)
            ->add('cus_name', TextType::class, [
                'label' => 'Nom personnalisé',
                'required' => false
            ])
            ->add('cus_link', TextType::class, [
                'label' => 'URL (Si champ personnalisé)',
                'required' => false
            ])
            ->add('blank', CheckboxType::class, [
                'label' => 'Lien externe',
                'required' => false
            ])
            ->add('menu', HiddenType::class, [
                'mapped' => false
            ])
            ->add('page', HiddenType::class, [
                'mapped' => false
            ])
            ->add('post', HiddenType::class, [
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MenuLink::class,
        ]);
    }
}