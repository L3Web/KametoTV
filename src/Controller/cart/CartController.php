<?php

namespace App\Controller\cart;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

class CartController extends AbstractController
{

    /**
     * @Route("/panier", name="app_cart")
     */
    public function cart( SessionInterface $session , ProductRepository $productRepository)
    {
        $cart = $session->get('panier',[]);
        $cartData = [];

        foreach ($cart as $id => $quantity)
        {
            $cartData [] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        //var_dump($cartData);
        return $this->render('cart/cart.html.twig',[
            'items' => $cartData
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="app_add")
     */
    public function add($id , SessionInterface $session)
    {
        $cart = $session->get('panier',[]);

        if(!empty($cart[$id]))
        {
            $cart[$id]++;
        }else
        {
            $cart[$id] = 1;
        }


        $session->set('panier' , $cart);

        dd($session->get('panier'));
    }
}