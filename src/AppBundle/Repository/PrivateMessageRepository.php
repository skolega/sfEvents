<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PrivateMessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PrivateMessageRepository extends EntityRepository
{
    public function getNotReadedMessages($user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->select('m')
                ->from('AppBundle:PrivateMessage', 'm')
                ->where('m.sendTo = :user')
                ->andWhere('m.readed = false')
                ->setParameter('user', $user);
        
        return $qb->getQuery()->getResult();
    }
}
