<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Entity\NewsletterTokens;
use App\Services\FormsService;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
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
        return $this->json([
            'private' => $this->getParameter('recaptcha_private')
        ]);
    }

    #[Route(path: '/api/analytics', name: 'analytics')]
    public function analytics(): JsonResponse
    {
        return $this->json([
            'key' => $this->getParameter('google_analytics')
        ]);
    }

    #[Route(path: '/newsletter-confirm/{token}', name: 'news_confirm')]
    public function validNewsRegist(string $token, EntityManagerInterface $em): Response
    {
        $token = $em->getRepository(NewsletterTokens::class)->findOneBy([
            'token' => $token
        ]);

        if ($token && !$token->isExpired()) {
            $token->getUser()->setAccepted(true);
            $em->persist($token);
            $em->flush();

            $message = "Votre inscription a bien été confirmée";
        } else {
            $message = "Le token a expiré. Veuillez renouveler votre inscription !";
        }

        return $this->render('newsletter/newsletter.html.twig', [
            'message' => $message
        ]);
    }

    #[Route(path: '/apî/newsletter', name: 'newsletter', methods: ['POST'])]
    public function newsletter(EntityManagerInterface $em): JsonResponse
    {
        $datas = json_decode($this->request->getContent());

        $context = [
            'email' => $datas->email,
            'date' => new DateTime('now'),
        ];

        // Création de l'inscrit
        $newsletter = new Newsletter();
        $newsletter
            ->setEmail($context['email'])
            ->setDateInsc($context['date'])
            ->setAccepted(false);

        $em->persist($newsletter);
        $em->flush();

        // Création du Token
        $token = new NewsletterTokens();
        $token
            ->setToken(uniqid())
            ->setUser($newsletter);

        $em->persist($token);
        $em->flush();

        $this->formService->send(
            'no-reply@dawn-of-light.fr',
            $context['email'],
            "Inscription à la newsletter",
            "newsletter",
            [
                'token' => $token->getToken()
            ]
        );

        return $this->json([
            'Le mail a bien été inscrit'
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
            'response' => 'Le mail a bien été envoyé'
        ]);
    }
}
