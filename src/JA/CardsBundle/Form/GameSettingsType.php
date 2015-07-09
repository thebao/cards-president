<?php

namespace JA\CardsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GameSettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('revolution',     'checkbox',         array('required' => false))
            ->add('jokers',         'checkbox',         array('required' => false))
            ->add('decks',          'integer',          array('attr' => array(
                'min' => '1',
                'max' => '2')))
            ->add('players',        'integer',          array('attr' => array(
                'min' => '2',
                'max' => '2')))
            ->add('chat',           'checkbox',         array('required' => false))
            ->add('private',        'checkbox',         array('required' => false))
            ->add('password',       'text',             array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JA\CardsBundle\Entity\GameSettings'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ja_cardsbundle_gamesettings';
    }
}
