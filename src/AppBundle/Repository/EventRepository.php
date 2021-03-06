<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends EntityRepository
{
    public function getUserEvents($user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('e')
                ->from('AppBundle:Event', 'e')
                ->join('e.players', 'p')
                ->where('p  = :user')
                ->setParameter('user', $user)
                ->setMaxResults(4);

        return $qb->getQuery()->getResult();
    }
}
