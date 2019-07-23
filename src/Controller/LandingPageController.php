<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\Address;
use App\Form\OrderType;
use App\Manager\OrderManager;
use Symfony\Component\Form\Form;
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

        return $this->render('landing_page/index_new.html.twig', []);
    }
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmation()
    {
        return $this->render('landing_page/confirmation.html.twig', []);
    }


    /**
     * @Route("/test", name="OrderType_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {


        $order = new Order;
        $addres_billing = new Address;
        $address_shipping = new Address;
        $client = new Client;

        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client, $addres_billing, $address_shipping, $order);
            $entityManager->flush();

            return $this->redirectToRoute('confirmation');
        }

        return $this->render('landing_page/test.html.twig', [

            'form' => $form->createView(),
        ]);
    }
}
