<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{

    public function searchUsersQuery($data)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('u')
                ->from('AppBundle:User', 'u')
                ->where('u.username LIKE :query')
                ->orWhere('u.name LIKE :query')
                ->orWhere('u.surname LIKE :query')
                ->setParameter('query', '%' . $data . '%')
                ->orderBy('u.username', 'DESC')
                ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }

    public function getLastAdded()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
                ->from('AppBundle:Event', 'e')
                ->orderBy('e.id', 'DESC')
                ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }

    public function getFriendsEventQuery($friends)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $friendsIds = array();
        foreach ($friends as $w) {
            $friendsIds[] = $w->getId();
        }
        
        $qb->select('e')
                ->from('AppBundle:Event', 'e')
                ->join('e.players', 'u')
                ->where('u.id IN (:players)')
//                ->andWhere('e.startDate >= :startDate')
//                ->setParameter('startDate', date('now'))
                ->setParameter('players', $friendsIds)
                ->setMaxResults(4);

        return $qb->getQuery()->getResult();
    }

    public function getProposeFriends($user, $friendsIds, $hiddenFriends)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $userId = $user->getId();

        $hiddenFriendsUsername = array();
        foreach ($hiddenFriends as $friend) {
            $hiddenFriendsUsername[] = $friend;
        }

        $qb->select('u')
                ->from('AppBundle:User', 'u')
                ->join('u.friendsWithMe', 'f')
                ->where('f.id IN (:friends)')
                ->andWhere('u.id NOT IN (:friends)')
                ->andWhere('u.id <> :userId');
        if ($hiddenFriendsUsername) {
            $qb->andWhere('u.id NOT IN (:hiddenFriends)')
                    ->setParameter('hiddenFriends', $hiddenFriendsUsername);
        }
        $qb->setParameter('friends', $friendsIds)
                ->setParameter('userId', $userId)
                ->setMaxResults(6);

        return $qb->getQuery()->getResult();
    }

}
