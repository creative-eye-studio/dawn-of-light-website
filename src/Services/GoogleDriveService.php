<?php

namespace App\Services;

use Google\Service\Drive\Drive;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GoogleDriveService extends AbstractController
{
    private $client;
    private $driveService;
}
