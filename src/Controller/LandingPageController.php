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

            // Vérifie et set l'adresse de livraison par l'adresse de facturation si l'adresse de livraison
            // n'est pas renseigné
            $adressBilling = $order->getAddressesBilling();
            $adressShipping = $order->getAddressesShipping();
            
            if (!$adressShipping)
            {
                $order->setAddressesShipping($adressBilling);
            }
            
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

    $orderapijson = json_decode($response->getBody()->getContents());

    $order->setorderapi($orderapijson->order_id);
    $entityManager->flush();

    // Set le Prix de la commande
    if ($order->getProduct() == "1 Nerf Elite Rapid Strike")
    {
        $amount = 3990;
    } else if ($order->getProduct() == "4 Nerf Elite Disruptor")
    {
        $amount = 5190;
    } else {
        $amount = 6490;
    }
                        
    return $this->render('landing_page/payement.html.twig', [
                'orderapiid' => $order->getOrderapi(),
                'amount' => $amount
            ]);
        }


        return $this->render('landing_page/index_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
    /**
     * @Route("/payment", name="payement")
     */
    public function payment(Request $request)
    {
         return $this->render('landing_page/payement.html.twig', []);
    }

    /**
     * @Route("/confirmation", name="stripe")
     */
    public function stripe(Request $request):Response
    {
         // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_9woza1rc2Y1XDxCvsds7AskG00MAqnNBRc');

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];
        $amount = $_POST['amount'];
        $orderapiid = $_POST['orderapiid'];
        $repo = $this->getDoctrine()->getRepository(Orders::class);

        $order = $repo->findOneBy([
            'orderapi' => $orderapiid,
        ]);


           
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'eur',
            'description' => 'BattleOffice',
            'source' => $token,
        ]);


        $client = new ClientsGuzzle([
            'base_uri' => 'https://api-commerce.simplon-roanne.com/',
            'headers' => ['Authorization' => 'Bearer mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX']
            ]);
        $response = $client->request('POST', '/order/' . $orderapiid . '/status', [
            'json'    => [
                'status' => 'PAID',
            ]
            
            ]);

        $order->setStatus('PAID');
                
            

        return $this->render('landing_page/confirmation.html.twig', [
            'orderapiid' => $orderapiid,
            'amount' => $amount
        ]);
    }
}
