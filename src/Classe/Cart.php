<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {

    }


    /*
   * getCart()
   * Fonction retourne le panier
   */
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }

    /*
     * add()
     * Fonction permettant l'ajout d'un produit au panier
     */
    public function add($product)
    {
        $cart = $this->getCart();

        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1,
            ];
        } else {
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1,
            ];
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }


    /*
     * decrease()
     * Fonction permettant la suppression d'un produit au panier
     */
    public function decrease($id)
    {
        $cart = $this->getCart();

        if ($cart[$id]['qty'] > 1) {
            $cart[$id]['qty']--;
        } else {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
   * remove()
  * Fonction permettant vider le panier
  */
    public function remove()
    {
        return $this->requestStack->getSession()->remove('cart');
    }

    /*
     * totalQty
    * Fonction retourne quantité totale des produits au panier
    */
    public function totalQty()
    {

        $cart = $this->getCart();
        $qty = 0;
        if (!isset($cart)) return $qty;
        foreach ($cart as $product) {
            $qty += $product['qty'];
        }
        return $qty;
    }

    /*
     * Fonction retourne prix total  HORS TAXES au panier
     */
    public function getTotalPriceWt()
    {
        $cart = $this->getCart();
        $totalPrice = 0;
        if (!isset($cart)) return $totalPrice;
        foreach ($cart as $product) {
            $totalPrice = $totalPrice + $product['object']->getPriceWt() * $product['qty'];
        }
        return $totalPrice;
    }
}