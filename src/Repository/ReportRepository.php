<?php

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeZone;
/**
 * @extends ServiceEntityRepository<Report>
 *
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

date_default_timezone_set('Asia/Ho_Chi_Minh');
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
    // get information about report 
    public function getReport()
    {
        $conn=$this->getEntityManager()->getConnection();
        $query ="SELECT rep.id, u.avatar as user_send_report_avatar,u.fullname as user_send_report_name
        ,us.avatar as user_reported_avatar,  us.fullname as user_reported_name
        ,rep.report_time, rep.post_id 
        from user as u , report as rep, user as us 
        WHERE u.id=rep.user_send_report_id AND us.id=rep.user_reported_id";
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }

    public function getReportDetail($report_id)
    {
        $conn=$this->getEntityManager()->getConnection();
        $query ="SELECT rep.id ,p.caption,
        us.avatar as user_reported_avatar, us.id as user_reported_id, us.fullname as user_reported_name,
        p.id as post_id, p.image ,p.total_like ,p.total_comment ,p.upload_time,
        u.avatar as user_send_report_avatar, u.fullname as user_send_report_name,
        rep.reason, rep.report_time from 
        user as u , report as rep, user as us, post as p 
        WHERE rep.id=:report_id AND u.id=rep.user_send_report_id AND us.id=rep.user_reported_id AND p.id=rep.post_id 
        ORDER BY rep.id ASC";
        $stmt=$conn->prepare($query);
        $resultSet=$stmt->executeQuery(['report_id'=>$report_id]);
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
