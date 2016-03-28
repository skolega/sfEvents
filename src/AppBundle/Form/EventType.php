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
                ->add('capacity', 'integer', array('label' => 'Ilość uczestników'))
                ->add('startDate', 'datetime', [
                    'widget' => 'single_text',
                    'format' => 'yyyy-mm-ddT hh:ii',
                    'label' => 'Rozpoczęcie wydarzenia',
                    'attr' => [
                        'class' => 'form-control controls input-append date form_datetime',
                        'data-provide' => 'datetimepicker',
                        'data-format' => 'yyyy-mm-ddThh:ii'
                    ]
                        ]
                )
                ->add('endDate', 'datetime', [
                    'widget' => 'single_text',
                    'format' => 'yyyy-mm-ddT hh:ii',
                    'label' => 'Zakończenie wydarzenia',
                    'attr' => [
                        'class' => 'form-control controls input-append date form_datetime',
                        'data-provide' => 'datetimepicker',
                        'date-format' => 'yyyy-mm-ddThh:ii'
                    ]
                        ]
                )
                ->add('featured', 'checkbox', array(
                    'label' => 'Wyróżnione wydarzenie',
                    'attr' => [
                        'class' => 'checkbox',
                         ]
                    )
                )
                ->add('category', 'entity', array(
                    'class' => 'AppBundle:Category',
                    'placeholder' => 'Wybierz kategorie',
                    'label' => 'Kategoria',
                        )
                )
                ->add('type', 'choice', array(
                    'choices' => array(
                        '5' => 'Bez drużyn - publiczny',
                        '6' => 'Bez drużyn - prywatny',
                        '1' => 'Gra - publiczny',
                        '2' => 'Gra - prywatny',
                        '3' => 'Drużynowy - publiczny',
                        '4' => 'Drużynowy - prywatny',
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
