<?php

namespace App\Service\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    protected $session;

    /**
     * PanierService constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    public function add(int $id)
    {

    }

    public function remove(int $id)
    {

    }

//    public function getFullPanier() : array
//    {
//
//    }
//
//    public function getTotal() : float
//    {
//
//    }
}
