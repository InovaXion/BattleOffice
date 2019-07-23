<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Orders;
use App\Entity\Address;
use App\Form\OrderType;
use App\Manager\OrderManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GuzzleHttp\Client as ClientsGuzzle;

class LandingPageController extends Controller
{
    /**
     * @Route("/", name="landing_page")
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $order = new Orders;

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            $client = new ClientsGuzzle([
                'base_uri' => 'https://api-commerce.simplon-roanne.com/',
                'headers' => ['Authorization' => 'Bearer mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX']
                ]);

            $response = $client->request('POST', '/order', [
                'json'    => [
                    "order"=> [
                    "id"=> $order->getId(),
                    "product"=>$order->getProduct(),
                    "payment_method"=>$order->getPaymentMethod(),
                    "status"=>$order->getStatus(),
                    "client"=> [
                      "firstname"=> $order->getClient()->getFirstname(),
                      "lastname"=> $order->getClient()->getLastname(),
                      "email"=> $order->getClient()->getEmail()
                    ],
                    "addresses"=> [
                      "billing"=> [
                        "address_line1"=> $order->getAddressesBilling()->getAddressLine1(),
                        "address_line2"=>$order->getAddressesBilling()->getAddressLine2(),
                        "city"=> $order->getAddressesBilling()->getCity(),
                        "zipcode"=> $order->getAddressesBilling()->getZipCode(),
                        "country"=> $order->getAddressesBilling()->getCountry(),
                        "phone"=> $order->getAddressesBilling()->getPhone()
                      ],
                      "shipping"=> [
                        "address_line1"=> $order->getAddressesShipping()->getAddressLine1(),
                        "address_line2"=> $order->getAddressesShipping()->getAddressLine2(),
                        "city"=> $order->getAddressesShipping()->getCity(),
                        "zipcode"=> $order->getAddressesShipping()->getZipCode(),
                        "country"=> $order->getAddressesShipping()->getCountry(),
                        "phone"=> $order->getAddressesShipping()->getPhone()
                      ]
                    ]
                  ]
          ]
      ]);
      
      dd($response->getBody()->getContents());


            return $this->redirectToRoute('payment');
        }

        return $this->render('landing_page/test.html.twig', [

            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmation()
    {
        return $this->render('landing_page/confirmation.html.twig', []);
    }
    /**
     * @Route("/payment", name="payment")
     */
    public function payment(Request $request)
    {
         return $this->render('landing_page/confirmation.html.twig', []);
    }




    // /**
    //  * @Route("/", name="OrderType_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {


    //     $order = new Orders;

    //     $form = $this->createForm(OrderType::class, $order);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($order);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('payment');
    //     }

    //     return $this->render('landing_page/test.html.twig', [

    //         'form' => $form->createView(),
    //     ]);
    // }
}
