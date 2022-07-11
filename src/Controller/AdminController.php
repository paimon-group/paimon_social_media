<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\ReportRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Notification;

class AdminController extends AbstractController
{
    /**
     * @Route ("/reportManager", name="app_report")
     */
    public function reportManagerdAction(ReportRepository $reportRepository)        
    {
        $totalReport = $reportRepository->getTotalReport();
        $reportInfor = $reportRepository->getReport();

        return $this->render('admin/report/adminReport.html.twig',[
            'totalReport'=>$totalReport,
            'reportInfor'=>$reportInfor
        ]);
    }

     /**
     * @Route ("/reportDetail", name="api_reportDetail", methods="GET")
     */
    public function reportDetaildAPI(Request $request,ReportRepository $reportRepository)
    {
        $request = $this->tranform($request);
        $reportId = $request->get('reportId');

        $reportDetail = $reportRepository->getReportDetail($reportId);

        if($reportDetail)
        {
            return new JsonResponse(['status_code' => 200, 'reportDetail' => $reportDetail]);
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Not found report detail with id: '.$reportId]);
        }

    }

    /**
     * @Route ("/deletePostIsRuleViolation", name="api_delete_post_is_rule_violation", methods="DELETE")
     */
    public function deletePostIsRuleViolationAPI(Request $request, PostRepository $postRepository, ReportRepository $reportRepository,ManagerRegistry $managerRegistry)
    {
        $request = $this->tranform($request);
        $postId = $request->get('postId');
        $reportId = $request->get('reportId');

        $post = $postRepository->find($postId);
        $report = $reportRepository->find($reportId);

        if ($post && $report)
        {
            $database = $managerRegistry->getManager();

            $post->setDeleted('true');

            $database->persist($post);
            $database->flush();
            $database->remove($report);
            $database->flush();

            $recevier = $post->getUser();
            $deletePostNotification = new Notification();
            $deletePostNotification->setSender($this->getUser());
            $deletePostNotification->setReceiver($recevier);
            $deletePostNotification->setType('report');
            $deletePostNotification->setSeen('no');

            $database->persist($deletePostNotification);
            $database->flush();

            return new JsonResponse(['status_code' => 200, 'Message' => 'delete success post id:'.$postId.' and report id: '.$reportId]);
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Not found post id:'.$postId.' and report id: '.$reportId]);
        }

    }

    /**
     * @Route ("/postIsHarmless", name="api_post_is_harmless", methods="DELETE")
     */
    public function postIsHarmlessAPI(Request $request, ReportRepository $reportRepository, ManagerRegistry $managerRegistry)
    {
        $request = $this->tranform($request);
        $reportId = $request->get('reportId');

        $report = $reportRepository->find($reportId);

        if($report)
        {
            $database = $managerRegistry->getManager();
            $database->remove($report);
            $database->flush();

            return new JsonResponse(['status_code' => 200, 'Message' => 'Delete success report id: '.$reportId]);
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Not found report id: '.$reportId]);
        }
    }

    public function tranform($request){
        $data = json_decode($request->getContent(), true);
        if($data === null){
            return $request;
        }
        $request->request->replace($data);
        return $request;
    }

}
