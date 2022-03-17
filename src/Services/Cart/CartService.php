<?php

namespace App\Services\Cart;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected SessionInterface $session;

    public function __construct( SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add(int $id)
    {

    }
    public function remove(int $id)
    {
        $cart = $this->session->get('panier' , []);

        if(!empty($cart[$id]))
        {
            unset($cart[$id]);
        }
        $this->session->set('panier' , $cart);

    }
/*
    public function getFullCart() : array
    {

    }
    public function getTotal() : float
    {

    }
*/
}