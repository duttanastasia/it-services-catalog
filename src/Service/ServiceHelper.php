<?php

namespace App\Service;

use App\Repository\ServiceRepository;

class ServiceHelper
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getUniqueCategories(): array
    {
        $allCategories = [
            'category.cloud_solutions' => 'Cloud Solutions',
            'category.collaboration_tools' => 'Collaboration Tools',
            'category.project_management' => 'Project Management Systems',
            'category.databases' => 'Databases',
            'category.version_control' => 'Version Control Systems',
            'category.operating_systems' => 'Operating Systems',
            'category.virtualization' => 'Virtualization and Containerization',
            'category.security' => 'Security Systems',
        ];

        $services = $this->serviceRepository->findAll();

        $uniqueCategoriesFromDb = array_unique(array_map(function($service) {
            return $service->getCategory();
        }, $services));

        $categories = array_merge(
            $uniqueCategoriesFromDb,
            array_keys($allCategories)
        );

        return array_unique($categories);
    }
}
