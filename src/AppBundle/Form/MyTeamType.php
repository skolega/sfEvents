<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MyTeamType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array('label' => 'Nazwa'))
        ->add('imageFile', 'vich_image', array(
        'required' => false,
        'allow_delete' => true, // not mandatory, default is true
        'download_link' => true, // not mandatory, default is true
        ))
        ->add('category', 'entity', array(
        'class' => 'AppBundle:Category',
        'placeholder' => 'Wybierz kategorie',
        'label' => 'Kategoria',
        )        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Team'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_team';
    }

}
