<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\EventRepository;
use App\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, EventRepository $eventRepository)
    {
        $search = new SearchData();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            dump($search);
            dump($request);
            $newSearch = $eventRepository->findBySearch($search);
            // dump($search);
            empty($form);

            return $this->render('search/search.html.twig', [
                'searchs' => $newSearch
            ]);

        }
        return $this->render('search/index.html.twig', [
            'form' => $form
        ]);
    }
}
