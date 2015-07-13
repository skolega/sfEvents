<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class TeamTeamsType extends AbstractType
{

    public $anArray;

    public function __construct($anArray)
    {
        $this->anArray = $anArray;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'entity', array(
                    'label' => 'Drużyna',
                    'class' => 'AppBundle:Team',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                                ->leftJoin('t.teamAdmin', 'u')
                                ->where('u.id IN (:user)')
                                ->setParameter('user', $this->anArray['user_id'])
                                ->orderBy('u.username', 'ASC')
                        ;
                    },
                ))
        ;
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
        return 'appbundle_team_teams';
    }

}
