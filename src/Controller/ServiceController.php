<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Service\ServiceHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/services', name: 'app_service_list')]
    public function listAction(ServiceRepository $serviceRepository, ServiceHelper $serviceHelper): Response
    {
        $services = $serviceRepository->findActiveServices();
        $categories = $serviceRepository->getUniqueCategories();

        return $this->render('service/list.html.twig', [
            'services' => $services,
            'categories' => $categories,
        ]);
    }
}