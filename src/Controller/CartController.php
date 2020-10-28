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
        $cartItems = $request->getSession()->get('cart');

        $cartData = [];
        $totalPrice = 0;
        $locale = $request->getLocale();

        if ($cartItems) {
            $uniqueCartItems = array_count_values($cartItems);

            $assortmentData = $assortmentService->getAssortmentData()->$locale;

            foreach ($cartItems as $item) {
                foreach ($assortmentData as $assortmentItem) {
                    if ($item == $assortmentItem->id) {
                        $itemToAdd = new \stdClass;

                        $itemToAdd->count = $uniqueCartItems[$assortmentItem->id];
                        $itemToAdd->item = $assortmentItem;

                        if (count($cartData) == 0) {
                            array_push($cartData, $itemToAdd);
                        } else if (array_search($itemToAdd, $cartData) === false) {
                            array_push($cartData, $itemToAdd);
                        }
                    }
                }
            }

            foreach ($cartData as $item) {
                $totalPrice += $item->count * $item->item->price;
            }
        }

        return $this->render('main/cart.html.twig', [
            'assortment' => $cartData,
            'locale' => $locale,
            'totalprice' => $totalPrice
        ]);
    }
}
