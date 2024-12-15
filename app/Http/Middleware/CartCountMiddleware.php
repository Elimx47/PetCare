<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CartCountMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->getOrCreateCart();

            // Share these variables with all views
            View::share('cartItemCount', $cart->items()->count());
            View::share('cartTotal', $cart->total);
            View::share('cart', $cart);

            // Also make them available in the request for controllers
            $request->attributes->set('cartItemCount', $cart->items()->count());
            $request->attributes->set('cartTotal', $cart->total);
            $request->attributes->set('cart', $cart);
        } else {
            View::share('cartItemCount', 0);
            View::share('cartTotal', 0);
            View::share('cart', null);
        }

        return $next($request);
    }
}
