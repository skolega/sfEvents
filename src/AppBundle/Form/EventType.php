<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EventType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array('label' => 'Nazwa'))
                ->add('city', 'text', array('label' => 'Miasto'))
                ->add('loacation', 'text', array('label' => 'Adres'))
                ->add('description', 'textarea', array('label' => 'Opis'))
                ->add('image', 'file', array('label' => 'Obrazek'))
                ->add('capacity', 'integer', array('label' => 'Liczba graczy'))
                ->add('startDate', 'datetime', array('label' => 'Rozpoczęcie wydarzenia'))
                ->add('endDate', 'datetime', array('label' => 'Zakończenie wydarzenia'))
                ->add('featured', 'checkbox', array('label' => 'Wyróżnione wydarzenie'))
                ->add('category', 'entity', array(
                    'class' => 'AppBundle:Category',
                    'placeholder' => 'Wybierz kategorie',
                    'label' => 'Kategoria',
                        )
                )
                ->add('type', 'choice', array(
                    'choices' => array(
                        '1' => 'Dwie drużyny - publiczny',
                        '2' => 'Dwie drużyny - prywatny',
                        '3' => 'Dwie drużyny - drużynowy publiczny',
                        '4' => 'Dwie drużyny - drużynowy prywatny',
                        '5' => 'Bez drużyn - publiczny',
                        '6' => 'Bez drużyn - prywatny',
                    ),
                    'placeholder' => 'Wybierz typ wydarzenia',
                    'label' => 'Rodzaj wydarzenia',
                    'required' => true,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event';
    }

}
