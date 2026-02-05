<?php

namespace App\Helpers;

use App\Models\CartItem;

/*
 * @author Nehad Altimimi <nehad.al.timimi@gmail.com>
 * @package    App\Http\Helpers
 *
 */

class Cart
{
    public static function getCartItemsCount(): int
    {
        // return session()->has('cart') ? count(session()->get('cart')) : 0;
        $request = request();
        // $user = session()->get('user');
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            $cartItems = self::getCookieCartItems();

            //  return array_reduce(
            //     $cartItems,
            //     fn($carry, $item) {
            //         return $carry + $item['quantity'];
            //     },
            //     0
            //  );
            return array_reduce(
                $cartItems,
                fn ($carry, $item) => $carry + $item['quantity'],
                0
            );
        }

    }

    public static function getCartItems()
    {
        // return session()->get('cart', []);
        $request = \request();
        // $user = session()->get('user');
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->get()->map(
                fn ($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );
        } else {
            return self::getCookieCartItems();
        }
        // if ($user) {
        //     return CartItem::where('user_id', $user->id)->get()->map(
        //         function($item) {
        //             return ['product_id' => $item->product_id, 'quantity' => $item->quantity];
        //         }
        //     )->toArray();
        // } else {
        //     return self::getCookieCartItems();
        // }
    }

    public static function getCookieCartItems(): array
    {
        // return session()->get('cart', []);
        $request = \request();

        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    public static function getCountFromItems($cartItems)
    {
        return array_reduce(
            $cartItems,
            fn ($carry, $item) => $carry + $item['quantity'], 0
            // function ($carry, $item) {
            //     return $carry + $item['quantity'];
            // },
            // 0
        );
    }

    public static function moveCartItemsIntoDb()
    {
        $request = \request();
        $cartItems = self::getCookieCartItems();
        $dbCartItems = CartItem::where(['user_id' => $request->user()->id])->get()->keyBy('product_id');
        $newCartItems = [];
        foreach ($cartItems as $cartItem) {
            if (isset($dbCartItems[$cartItem['product_id']])) {
                continue;
            }
            $newCartItems[] = [
                'user_id' => $request->user()->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
            ];
        }

        if (! empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }
    }
}
