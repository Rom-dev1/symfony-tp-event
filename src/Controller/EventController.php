<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function create(Request $request,SluggerInterface $slugger)
    {   
        $event = new Event();
        // @todo 
        // modifier date de création pour avoir la date du jour 
        // générer automatiquement la création de l'evenement
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setStartEvent(new \DateTimeImmutable());
        $event->setEndEvent(new DateTimeImmutable());
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // $event->setCreatedAt(new \DateTImeImmutable)
            $coverFile = $form->get('cover')->getData();
            dump($coverFile);
            if($coverFile){
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFileName = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();
                $coverFile->move($this->getParameter('cover_directory'), $newFileName);
            }
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $this->addFlash('success','Votre événement à été créer, merci!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/events', name: 'app_event')]
    //@todo pagination, ajouter le requirement avec le digit dans les parametres de la route
    // faire requete dans le repository
    // possibilié d'utiliser un bundle ou de le faire à la main
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
        $lock = $event->getEndEvent();
        dump($lock);

        if(!$event){
            throw $this->createNotFoundException();
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'lock' => $lock
        ]);
    }

    

}
