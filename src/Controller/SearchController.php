<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\EventRepository;
use App\SearchData;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, EventRepository $eventRepository)
    {
        $search = new SearchData();
        $form = $this->createForm(SearchType::class, $search, [
            'action' => $this->generateUrl('app_search')
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newSearch = $eventRepository->findBySearch($search);
            $nbEvent = [];
            foreach($newSearch as $new){
                if($new->getStartEvent() > new DateTimeImmutable()){
                    $nbEvent[] = $new;
                }
            }
            
            return $this->render('search/search.html.twig', [
                'searchs' => $newSearch,
                'form' => $form,
                'nbEvent' => $nbEvent
                
            ]);

        }
        return $this->render('search/index.html.twig', [
            'form' => $form
        ]);
    }
}
