<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Validator\Tests\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository,Request $request,PaginatorInterface $paginator): Response
    {
    
      
      
       
       //initialement le tableau des membre est vide, 
       //c.a.d on affiche les membre que lorsque l'utilisateur clique sur le bouton rechercher
        $events= [];
        
      $events= $this->getDoctrine()->getRepository(Event::class)->findAll();
      // Paginate the results of the query
      $events = $paginator->paginate(
        // Doctrine Query, not results
        $events,
        // Define the page parameter
        $request->query->getInt('page', 1),
        // Items per page
        5);
        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
     
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $file = $event-> getImage();
           $fileName = md5(uniqid()).'.'.$file->guessExtension();
           try{
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName );
           }
           catch (FileException $e)
           {
               //
           }
            $entityManager = $this->getDoctrine()->getManager();
            $event->SetImage($fileName);
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

   
 /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {


    $event->setImage( new File($this->getParameter('brochures_directory').'/'.$event->getImage()));
       
     $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);

        }
    
    /**
     * @Route("/{id}", name="event_delete", methods={"POST"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
