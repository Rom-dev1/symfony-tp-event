<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{   
    protected $repository;
    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/event', name: 'app_event')]
    public function listEvent(): Response
    {   

        return $this->render('event/index.html.twig', [
            'events' => $this->repository->findAll()
        ]);
    }
}
