<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Orders;
use App\Entity\Product;
use App\Form\OrderType;
use App\Manager\OrderManager;
use Symfony\Component\Form\Form;
use App\Entity\Clientdeliveryaddress;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
       $client = New Client;
       $clientAddress = New Clientdeliveryaddress;
       $order = New Orders;
       $product = New Product;


        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client, $clientAddress, $product, $order);
            $entityManager->flush();

            return $this->redirectToRoute('confirmation');
        } 

        return $this->render('landing_page/test.html.twig', [
           
            'form' => $form->createView(),
        ]);
    
}


}