<?php

namespace App\Service;

use App\Entity\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ServiceHelper
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function handleLogo(UploadedFile $logoFile = null, Service $service): void
    {
        if ($logoFile) {
            $newFilename = uniqid() . '.' . $logoFile->guessExtension();
            $logoFile->move($this->params->get('uploads_directory'), $newFilename);
            $service->setLogo($newFilename);
        }
    }
}
