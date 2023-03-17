<?php

namespace App\Controller;

use App\Form\SearchType;
use App\SearchData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request)
    {   
        $searchBar = new SearchData($request);
        dump($searchBar);
        $form = $this->createForm(SearchType::class, $searchBar);
        dump($form);
        $form->handleRequest($request);
        dump($form);
        if($form->isSubmitted() && $form->isValid()){
            dump($searchBar);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form
        ]);
    }
}
