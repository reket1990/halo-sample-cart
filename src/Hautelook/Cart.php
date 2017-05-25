<?php
namespace Hautelook;

class Cart
{
    public $items = array();
    public $payment_percentage = 1;

    /* Cost functions */
    public function applyCoupon($discount)
    {
        // Note: Should a user be allowed to apply more than one discount?

        $this->payment_percentage *= 1 - $discount/100;
    }

    public function subtotal()
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return $subtotal * $this->payment_percentage;
    }

    public function total()
    {
        $subtotal = $this->subtotal();

        // Check free shipping
        if ($subtotal >= 100) {
            $free = true;
            foreach ($this->items as $item) {
                if ($item['weight'] >= 10) {
                    $free = false;
                }
            }

            if ($free) {
                return $subtotal;
            }
        }

        // Calculate standard shipping
        $shipping = 0;

        // Check whether flat rate should be charged
        if ($subtotal < 100) {
            $flat_rate = false;
            foreach ($this->items as $item) {
                if ($item['weight'] < 10) {
                    $flat_rate = true;
                }
            }
            $shipping = $flat_rate ? 5 : 0;
        }

        // Additional shipping for each overweight item
        foreach ($this->items as $item) {
            if ($item['weight'] >= 10) {
                $shipping += 20;
            }
        }

        return $subtotal + $shipping;
    }
    /* End: Cost functions */

    /* Item management functions */
    public function addItem($dollars, $product_name, $quantity=1, $weight=0)
    {
        if (array_key_exists($product_name, $this->items)) {
            $this->items[$product_name]['quantity'] = 2;
            return;
        }

        $this->items[$product_name] = array(
            'price' => $dollars,
            'quantity' => $quantity,
            'weight' => $weight
        );
    }

    public function quantity($product_name)
    {
        if (array_key_exists($product_name, $this->items)) {
            return $this->items[$product_name]['quantity'];
        }

        return 0;
    }
    /* End: Item management functions */
}
