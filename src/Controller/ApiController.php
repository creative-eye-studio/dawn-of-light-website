<?php

namespace App\Controller;

use App\Services\FormsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $request;
    private $formService;

    function __construct(RequestStack $request, FormsService $formService)
    {
        $this->request = $request->getCurrentRequest();
        $this->formService = $formService;
    }

    #[Route(path: '/api/brevo-api', name: 'brevo_api')]
    public function getBrevoApiKey(): JsonResponse
    {
        return $this->json([
            'brevoApiKey' => $this->getParameter('brevo_api')
        ]);
    }

    #[Route(path: '/api/recaptcha', name: 'recaptcha')]
    public function recaptcha(): JsonResponse
    {
        $recaptchaPublic = $this->getParameter('recaptcha_public');
        $recaptchaPrivate = $this->getParameter('recaptcha_private');

        return $this->json([
            'public' => $recaptchaPublic,
            'private' => $recaptchaPrivate
        ]);
    }

    #[Route(path: '/api/analytics', name: 'analytics')]
    public function analytics(): JsonResponse
    {
        $analyticsKey = $this->getParameter('google_analytics');

        return $this->json([
            'key' => $analyticsKey
        ]);
    }

    #[Route('/contact-form', name: 'api_contact_form')]
    public function contactForm(): JsonResponse
    {
        $datas = json_decode($this->request->getContent());

        $mailto = 'rifakev@gmail.com';
        $subject = "Candidature au projet Dawn of Light";
        $template = "contact";

        $context = [
            'nom' => $datas->nom,
            'prenom' => $datas->prenom,
            'surnom' => $datas->surnom ? $datas->surnom : "Pas de surnom",
            'mail' => $datas->mail,
            'discord' => $datas->discord ? $datas->discord :  "Aucun Discord",
            'skills' => $datas->skills,
            'parcours' => $datas->parcours,
            'motivations' => $datas->motivations,
        ];

        $this->formService->send(
            $datas->mail,
            $mailto,
            $subject,
            $template,
            $context
        );

        return $this->json([
            'response'=>'Le mail a bien été envoyé'
        ]);
    }
}
