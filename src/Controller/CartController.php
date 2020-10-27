<?php

namespace App\Controller;

use App\Service\Assortment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function indexAction(Request $request, Assortment $assortmentService)
    {
        $assortmentData = $assortmentService->getAssortmentData();
        $locale = $request->getLocale();

        return $this->render('main/cart.html.twig', [
            'assortment' => $assortmentData,
            'locale' => $locale
        ]);
    }
}
