<?php

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Report>
 *
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function add(Report $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Report $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    // count all report that have been sent
    public function getTotalReport()
    {
        $conn=$this->getEntityManager()->getConnection();
        $query='SELECT COUNT(rep.id) as total_report from report as rep';
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }
    // count all user in this website
    // all in this website
    // total of online or offline users
    public function countAll()
    {
        $conn=$this->getEntityManager()->getConnection();
        $query ="select(SELECT COUNT(u.id) from user as u) as total_user, 
        (SELECT COUNT(p.id) from post as p where p.deleted='false') as total_post,
        (SELECT COUNT(u.id)from user as u WHERE u.login_status='login') as total_online_user, 
        (SELECT COUNT(u.id)from user as u WHERE u.login_status='logout') as total_offline_user";
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }


//    /**
//     * @return Report[] Returns an array of Report objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Report
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
