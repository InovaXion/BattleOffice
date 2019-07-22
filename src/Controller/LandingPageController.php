<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends Controller
{
    /**
     * @Route("/", name="landing_page")
     * @throws \Exception
     */
    public function index(Request $request)
    {
        //Your code here

        return $this->render('landing_page/index_new.html.twig', [

        ]);
    }
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmation()
    {
        return $this->render('landing_page/confirmation.html.twig', [

        ]);
    }


    /**
     * @Route("/test", name="OrderType_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
       
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);

       /*  if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderType);
            $entityManager->flush();

            return $this->redirectToRoute('OrderType_index');
        } */

        return $this->render('OrderType/new.html.twig', [
           
            'form' => $form->createView(),
        ]);
    
}


}