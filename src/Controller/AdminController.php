<?php

namespace App\Controller;

use App\Repository\ReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route ("/statificalManager", name="app_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('admin/statifical/adminHome.html.twig');
    }

    /**
     * @Route ("/reportManager", name="app_report")
     */
    public function reportManagerdAction(ReportRepository $reportRepository)        
    {
        $totalReport=$reportRepository->getTotalReport();
        $reportInfor=$reportRepository->getReport();
        return new JsonResponse(['totalReport'=>$totalReport,'reportInfor'=>$reportInfor]);

    }

     /**
     * @Route ("/reportDetail/{id}", name="app_reportDetail")
     */
    public function reportDetaildAction(ReportRepository $reportRepository,$id)        
    {
        $reportDetail=$reportRepository->getReportDetail($id);
        return new JsonResponse(['reportDetail'=>$reportDetail,]);

    }

}
