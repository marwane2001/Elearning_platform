<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/order/payment', name: 'app_payment')]
    public function index(): Response
    {
        $stripeApiKey = $_ENV['STRIPE_API_KEY'];
        Stripe::setApiKey($stripeApiKey);
        $YOUR_DOMAIN = 'http://127.0.0.1:3000';


        $checkout_session = Session::create([
            'line_items' => [[
                'price_data' =>[
                    'currency' => 'eur',
                    'unit_amount' => 10020,
                    'product_data' => [
                        'name' => 'Test Product',
                    ]
                ] ,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);
        header("HTTP/1.1 301 See Other");
        return $this->redirect($checkout_session->url);

    }
}
