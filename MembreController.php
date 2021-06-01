<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * @Route("/membre")
 */
class MembreController extends AbstractController
{
    /**
     * @Route("/", name="membre_index", methods={"GET"})
     */
    public function index(Request $request)
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
       //initialement le tableau des membre est vide, 
       //c.a.d on affiche les membre que lorsque l'utilisateur clique sur le bouton rechercher
        $membres= [];
        
      $membres= $this->getDoctrine()->getRepository(Membre::class)->findAll();
          return  $this->render('membre/index.html.twig',[ 'form' =>$form->createView(), 'membres' => $membres]);  
     
      
      }
 
      
    
    
 

    
    /**
     * @Route("/new", name="membre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('membre_index');
        }

        return $this->render('membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membre_show", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        return $this->render('membre/show.html.twig', [
            'membre' => $membre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="membre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Membre $membre): Response
    {
        
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membre_index');
        }

        return $this->render('membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membre_delete", methods={"POST"})
     */
    public function delete(Request $request, Membre $membre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($membre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('membre_index');
    }

    /**
    *@Route("/",name="membre_list")
    */
    public function home(Request $request)
    {
      $propertySearch = new PropertySearch();
      $form = $this->createForm(PropertySearchType::class,$propertySearch);
      $form->handleRequest($request);
     //initialement le tableau des membre est vide, 
     //c.a.d on affiche les membre que lorsque l'utilisateur clique sur le bouton rechercher
      $membres= [];
      
     if($form->isSubmitted() && $form->isValid()) {
      //on récupère le nameMembre d'membre tapé dans le formulaire
        $nameMembre = $propertySearch-> getNameMembre();   
        if ($nameMembre!="") 
        //si on a fourni un nameMembre d'membre on affiche tous les membre ayant ce nameMembre
       { 
           $membres= $this->getDoctrine()->getRepository(Membre::class)->findBy(['nameMembre' => $nameMembre] );
       }
       else   
        //si si aucun nameMembre n'est fourni on affiche tous les membre
       {  $membres= $this->getDoctrine()->getRepository(Membre::class)->findAll();
        return  $this->render('membre/index.html.twig',[ 'form' =>$form->createView(), 'membres' => $membres]);  
     }
    
    }
    return  $this->render('membre/index.html.twig',[ 'form' =>$form->createView(), 'membres' => $membres]);  
    }
}


