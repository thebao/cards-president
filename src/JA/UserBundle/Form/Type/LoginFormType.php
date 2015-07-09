<?php

namespace JA\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gameHandle')
        ;
    }

    public function getParent()
    {
        return 'fos_user_login';
    }

    public function getName()
    {
        return 'ja_user_login';
    }
}
