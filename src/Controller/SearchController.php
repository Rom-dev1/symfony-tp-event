<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function index(Request $request)
    {   
        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            dump($data);
        }
    }
}
