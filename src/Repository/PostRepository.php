<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    #get all friend's post and don't over 3 days 
    public function getPost($user_id)
    {
        $conn=$this->getEntityManager()->getConnection();
        $query ='SELECT u.avatar,u.fullname,p.caption,p.image,p.total_like,p.total_comment,p.upload_time 
        FROM post as p, user as u, relationship as r WHERE
        r.user_id=:user_id AND p.user_id=r.friend_id AND u.id=r.friend_id 
        AND r.status=1 AND DATE(P.upload_time)+3>DATE(NOW()) ORDER BY RAND()';
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['user_id'=>$user_id]);
        return $resultSet->fetchAllAssociative();
    }

    public function getPostProfile($user_id)
    {
        $conn=$this->getEntityManager()->getConnection();
        $query ='SELECT u.avatar,u.fullname, p.id,p.caption,p.image,p.total_like,p.total_comment,p.upload_time 
        FROM post as p, user as u WHERE
         p.user_id=:user_id and p.user_id=u.id
         ORDER BY p.upload_time DESC ';
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['user_id'=>$user_id]);
        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
