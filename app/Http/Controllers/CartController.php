<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->getOrCreateCart();
        return view('cart.index', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'medication_name' => 'required|string',
            'price' => 'required|numeric',
            'medication_type' => 'required|string',
            'image_url' => 'nullable|string',
            'quantity' => 'integer|min:1|max:10'
        ]);

        $cart = Auth::user()->getOrCreateCart();

        // Check if item already exists in cart
        $cartItem = $cart->items()->where('medication_name', $validatedData['medication_name'])->first();

        if ($cartItem) {
            // Update quantity if item exists
            $cartItem->update([
                'quantity' => $cartItem->quantity + ($validatedData['quantity'] ?? 1)
            ]);
        } else {
            // Create new cart item
            $cart->items()->create([
                'medication_name' => $validatedData['medication_name'],
                'price' => $validatedData['price'],
                'medication_type' => $validatedData['medication_type'],
                'image_url' => $validatedData['image_url'] ?? null,
                'quantity' => $validatedData['quantity'] ?? 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Medication added to cart successfully!');
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);

        // Ensure the cart belongs to the current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Medication removed from cart.');
    }

    public function updateQuantity(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cartItem = CartItem::findOrFail($id);

        // Ensure the cart belongs to the current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $cartItem->update(['quantity' => $validatedData['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }
}
