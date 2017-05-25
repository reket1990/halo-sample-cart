<?php
namespace Hautelook;

class Cart
{
    public $items = array();

    public function subtotal()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    public function addItem($dollars, $product_name, $quantity=1)
    {
        if (array_key_exists($product_name, $this->items)) {
            $this->items[$product_name]['quantity'] = 2;
            return;
        }

        $this->items[$product_name] = array(
            'price' => $dollars,
            'quantity' => $quantity
        );
    }

    public function quantity($product_name)
    {
        if (array_key_exists($product_name, $this->items)) {
            return $this->items[$product_name]['quantity'];
        }

        return 0;
    }
} 
