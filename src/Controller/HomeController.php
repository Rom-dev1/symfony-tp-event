<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\EventRepository;
use App\SearchData;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
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

        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form,
            'search' => $newSearch
        ]);
    }
}
