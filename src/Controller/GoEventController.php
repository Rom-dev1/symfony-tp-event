<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class GoEventController extends AbstractController
{
    #[Route('/go/event', name: 'app_go_event')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer) 
    {   
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $contact = $form->getData();
                $entityManager->persist($contact);
                $entityManager->flush();
                $this->addFlash('sucess', 'Votre mail à bien été envoyé');
                $email = (new Email())
                ->from($contact->getEmail()) // récupère le mail de l'emmeteur
                ->to('you@example.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                //->subject('Time for Symfony Mailer!')
                // ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');
                $mailer->send($email);
                return $this->redirectToRoute('app_event');
            }

        return $this->render('go_event/email.html.twig', [
            'form' => $form
        ]);
    }

    
    
}
