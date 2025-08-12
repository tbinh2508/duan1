<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;


class CartService
{
    // protected $cartRepository;
    // public function __construct(CartRepository $cartRepository)
    // {
    //     $this->cartRepository = $cartRepository;
    // }
    public function showProductVariantsCart()
    {
        $user_id = Auth::user()->id;

        $cart = Cart::query()->where('user_id', $user_id)->first();

        if (!empty($cart)) {

            $cartItem = CartItem::query()->where('cart_id', $cart->id)->get();
            // dd($cartItem);
            $productVariants = [];

            foreach ($cartItem as $item) {
                $productVariant = ProductVariant::with(
                    'capacity',
                    'color',
                    'product',
                    'cartitem'
                )->where('id', $item->product_variant_id)->first();
                $productVariant->cart_id = $item->cart_id;
                $productVariants[] = $productVariant;
            }
        } else {
            $productVariants = null;
        }
        return $productVariants;
    }


    public function showProductVariantsCartCheckout()
    {
        $user_id = Auth::user()->id;

        $cart = Cart::query()->where('user_id', $user_id)->first();

        if (!empty($cart)) {

            $cartItem = CartItem::query()->where('cart_id', $cart->id)->where('is_check', 1)->get();
            // dd($cartItem);
            $productVariants = [];

            foreach ($cartItem as $item) {
                $productVariant = ProductVariant::with(
                    'capacity',
                    'color',
                    'product',
                    'cartitem'
                )->where('id', $item->product_variant_id)->first();
                $productVariant->cart_id = $item->cart_id;
                $productVariants[] = $productVariant;
            }
        } else {
            $productVariants = null;
        }
        return $productVariants;
    }
    
}