<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{   
    protected $repository;
    protected $entityManager;

    public function __construct(EventRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    #[Route('event/create', name:'app_event_create')]
    public function create(Request $request)
    {
        $event = new Event();
        $event->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $this->addFlash('success','Votre événement à été créer, merci!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/event', name: 'app_event')]
    public function listEvent(): Response
    {   
        return $this->render('event/index.html.twig', [
            'events' => $this->repository->findAll(),
            'nbevent' => $this->repository->findAllToCome()
        ]);
    }


    #[Route('event/{id}', name:'app_event_one')]
    public function show($id)
    {
        $event = $this->repository->find($id);

        if(!$event){
            throw $this->createNotFoundException();
        }

        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
    }

    

}
