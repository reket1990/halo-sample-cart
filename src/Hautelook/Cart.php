<?php
namespace Hautelook;

class Cart
{
    protected $products;

    public function __construct()
    {
        $this->products = [];
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function subtotal()
    {
        $subtotal = 0;
        foreach ($this->products as $product) {
            $subtotal += $product->getPrice();
        }

        return $subtotal;
    }
} 
