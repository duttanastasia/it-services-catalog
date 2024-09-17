<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Form\ServiceType;
use App\Service\ServiceHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_service_list')]
    #[IsGranted('ROLE_ADMIN')]
    public function list(ServiceRepository $serviceRepository, ServiceHelper $serviceHelper): Response
    {
        $services = $serviceRepository->findAll();
        $categories = $serviceHelper->getUniqueCategories();

        return $this->render('service/list.html.twig', [
            'services' => $services,
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/service/new', name: 'admin_service_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $logoFile */
            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $newFilename = uniqid() . '.' . $logoFile->guessExtension();
                $logoFile->move($this->getParameter('uploads_directory'), $newFilename);
                $service->setLogo($newFilename);
            }

            $entityManager->persist($service);
            $entityManager->flush();

            return $this->json(['success' => true]);
        }

        return $this->render('admin/service/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/service/{id}/edit', name: 'admin_service_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request, ServiceRepository $serviceRepository, EntityManagerInterface $entityManager): Response
    {
        $service = $serviceRepository->find($id);
        if (!$service) {
            throw new \Exception('Service not found');
        }

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $logoFile */
            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $newFilename = uniqid() . '.' . $logoFile->guessExtension();
                $logoFile->move($this->getParameter('uploads_directory'), $newFilename);
                $service->setLogo($newFilename);
            }

            $entityManager->flush();

            return $this->json(['success' => true]);
        }

        if (!$request->isXmlHttpRequest()) {
            return $this->render('admin/service/edit.html.twig', [
                'form' => $form->createView(),
                'service' => $service
            ]);
        }

        return $this->json(['error' => 'Form is invalid'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/admin/service/{id}/delete', name: 'admin_service_delete')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, ServiceRepository $serviceRepository, EntityManagerInterface $entityManager): Response
    {
        $service = $serviceRepository->find($id);
        $entityManager->remove($service);
        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}
