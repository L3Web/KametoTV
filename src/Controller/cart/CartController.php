<?php

namespace App\Controller\cart;


use App\Entity\Cart;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    /**
     * @Route("/{_locale<%app.supported_locales%>}/panier", name="app_cart")
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
        $total = 0;
        foreach ($cartData as $item)
        {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total = $total + $totalItem;
        }

        return $this->render('cart/cart.html.twig',[
            'items' => $cartData,
            'total' => $total
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
        return $this->redirectToRoute('app_boutique');
    }

    /**
     * @Route("/panier/remove/{id}", name="app_remove")
     */
    public function remove ($id , SessionInterface $session)
    {
        $cart = $session->get('panier' , []);

        if(!empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $session->set('panier' , $cart);

        return $this->redirectToRoute("app_cart");
    }
}