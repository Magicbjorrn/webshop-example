<?php

namespace App\Controller;

use App\Service\Assortment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $faviconURL;

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param Assortment $assortmentService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, Assortment $assortmentService)
    {
        $assortmentData = $assortmentService->getAssortmentData();
        $locale = $request->getLocale();

        return $this->render('main/home.html.twig', [
            'assortment' => $assortmentData,
            'locale' => $locale
        ]);
    }

    /**
     * @Route("/addtocart/{id}", name="add_to_cart")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function addToCartAction(Request $request, $id) {
        $cartItems = $request->getSession()->get('cart');

        if (gettype($cartItems) != 'array') {
            $cartItems = [];
        }

        array_push($cartItems, $id);

        $request->getSession()->set('cart', $cartItems);
        echo print_r($request->getSession()->get('cart'), true);

        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent(json_encode($cartItems));

        return $response;
    }
}
