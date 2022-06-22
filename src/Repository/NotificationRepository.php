<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function add(Notification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Notification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    #this function will count all the like of other user who was react the current user's post
    public function getLikeFromOtherUser($user_id)
    {
        $conn=$this->getEntityManager()->getConnection();

        $query ='SELECT COUNT(n.id) as total_like FROM notification as n where n.type="like" AND n.seen="no" AND n.receiver_id=:user_id';

        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['user_id'=>$user_id]);

        return $resultSet->fetchAllAssociative();
    }
     #this function will count all the comment of other user who was react the current user's post
    public function getCommentFromOtherUser($user_id)
    {
        $conn=$this->getEntityManager()->getConnection();
        $query='SELECT COUNT(n.id) as total_comment FROM notification as n where n.type="comment" AND n.seen="no" AND n.receiver_id=:user_id';
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['user_id'=>$user_id]);
        return $resultSet->fetchAllAssociative();
    }

    #count all invite friend request for current user
    public function getInvitefriend($user_id)
    {
        $conn=$this->getEntityManager()->getConnection();

        $query ='
        SELECT COUNT(r.friend_id) as invite_friend_request
        FROM relationship as r ,user as u
        WHERE r.friend_id=:user_id and r.status=0 and u.id=r.user_id';

        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['user_id'=>$user_id]);

        return $resultSet->fetchAllAssociative();
    }
    // get who has like or comment
    public function getCommentAndLikeDetailFromOtherUser($user_id)
    {
        $conn=$this->getEntityManager()->getConnection();

        $query ='SELECT u.fullname,n.type FROM notification as n ,user as u WHERE n.receiver_id=:user_id AND u.id=n.sender_id';

        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['user_id'=>$user_id]);

        return $resultSet->fetchAllAssociative();
    }


//    /**
//     * @return Notification[] Returns an array of Notification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notification
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
