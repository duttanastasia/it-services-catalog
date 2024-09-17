<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = [
            // Cloud solutions
            ['name' => 'Google Cloud Platform (GCP)', 'logo' => 'gcp.png', 'description' => 'description.cloud_computing_google', 'category' => 'category.cloud_solutions'],
            ['name' => 'Amazon Web Services (AWS)', 'logo' => 'aws.png', 'description' => 'description.cloud_solutions_amazon', 'category' => 'category.cloud_solutions'],
            ['name' => 'Microsoft Azure', 'logo' => 'azure.png', 'description' => 'description.cloud_computing_microsoft', 'category' => 'category.cloud_solutions'],

            // Collaboration tools
            ['name' => 'Microsoft Teams', 'logo' => 'teams.png', 'description' => 'description.team_communication_microsoft', 'category' => 'category.collaboration_tools'],
            ['name' => 'Slack', 'logo' => 'slack.png', 'description' => 'description.communication_collaboration', 'category' => 'category.collaboration_tools'],
            ['name' => 'Zoom', 'logo' => 'zoom.png', 'description' => 'description.video_conferencing', 'category' => 'category.collaboration_tools'],

            // Project management systems
            ['name' => 'Jira', 'logo' => 'jira.png', 'description' => 'description.project_management_atlassian', 'category' => 'category.project_management'],
            ['name' => 'Trello', 'logo' => 'trello.png', 'description' => 'description.task_project_management', 'category' => 'category.project_management'],
            ['name' => 'Asana', 'logo' => 'asana.png', 'description' => 'description.project_task_management', 'category' => 'category.project_management'],

            // Databases
            ['name' => 'PostgreSQL', 'logo' => 'postgresql.png', 'description' => 'description.object_relational_database', 'category' => 'category.databases'],
            ['name' => 'MySQL', 'logo' => 'mysql.png', 'description' => 'description.open_source_database', 'category' => 'category.databases'],
            ['name' => 'MongoDB', 'logo' => 'mongodb.png', 'description' => 'description.document_oriented_database', 'category' => 'category.databases'],

            // Version control systems
            ['name' => 'GitHub', 'logo' => 'github.png', 'description' => 'description.code_hosting_version_control', 'category' => 'category.version_control'],
            ['name' => 'GitLab', 'logo' => 'gitlab.png', 'description' => 'description.devops_repository_management', 'category' => 'category.version_control'],
            ['name' => 'Bitbucket', 'logo' => 'bitbucket.png', 'description' => 'description.repository_management_cicd', 'category' => 'category.version_control'],

            // Operating systems
            ['name' => 'Ubuntu', 'logo' => 'ubuntu.png', 'description' => 'description.popular_linux_distribution', 'category' => 'category.operating_systems'],
            ['name' => 'CentOS', 'logo' => 'centos.png', 'description' => 'description.community_version_rhel', 'category' => 'category.operating_systems'],
            ['name' => 'Windows Server', 'logo' => 'windows_server.png', 'description' => 'description.server_os_microsoft', 'category' => 'category.operating_systems'],

            // Virtualization and containerization
            ['name' => 'Docker', 'logo' => 'docker.png', 'description' => 'description.containerizing_applications', 'category' => 'category.virtualization'],
            ['name' => 'Kubernetes', 'logo' => 'kubernetes.png', 'description' => 'description.container_orchestration', 'category' => 'category.virtualization'],
            ['name' => 'VMware', 'logo' => 'vmware.png', 'description' => 'description.virtualization_cloud_solutions', 'category' => 'category.virtualization'],

            // Security systems
            ['name' => 'Zabbix', 'logo' => 'zabbix.png', 'description' => 'description.it_infrastructure_management', 'category' => 'category.security'],
            ['name' => 'Splunk', 'logo' => 'splunk.png', 'description' => 'description.data_analysis_monitoring', 'category' => 'category.security'],
            ['name' => 'Palo Alto Networks', 'logo' => 'palo_alto.png', 'description' => 'description.network_data_security', 'category' => 'category.security'],
        ];

        foreach ($services as $serviceData) {
            $service = new Service();
            $service->setName($serviceData['name']);
            $service->setLogo($serviceData['logo']);
            $service->setDescription($serviceData['description']);
            $service->setCategory($serviceData['category']);

            $manager->persist($service);
        }

        $manager->flush();
    }
}