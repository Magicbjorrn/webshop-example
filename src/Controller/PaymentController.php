<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function indexAction(Request $request)
    {
        $request->getSession()->clear();
        
        return $this->render('main/success.html.twig', [
            // Page variables
        ]);
    }
}
