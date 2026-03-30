<?php

namespace App\Helpers;

class Cart
{
    private const CART_KEY = 'cart_products';
    private static function ensureSessionStarted(): void{
        if (session_status() !== PHP_SESSION_ACTIVE){
            @session_start();
        }
    }

    public static function get():array
    {
        self::ensureSessionStarted();
        //Alan's note: I'm using SessionManager rather than invoking the session superglobaL because I want to learn to use the helper class
        $products = SessionManager::get(self::CART_KEY) ?? [];
        self::clear();
        return $products;
    }

    public static function has(): bool
    {
        return SessionManager::has(self::CART_KEY)&&!empty(SessionManager::get(self::CART_KEY));
    }

    public static function clear(): void
    {
        SessionManager::remove(self::CART_KEY);
    }

}
