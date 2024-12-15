<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        // Validate checkout request
        $validatedData = $request->validate([
            'payment_method' => 'required|in:cash,credit_card,paypal',
            'shipping_address' => 'required|string|max:500'
        ]);

        // Get user's current cart
        $cart = Auth::user()->getOrCreateCart();

        // Check if cart is empty
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create new order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $cart->total,
                'status' => 'pending',
                'payment_method' => $validatedData['payment_method'],
                'shipping_address' => $validatedData['shipping_address']
            ]);

            // Transfer cart items to order items
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'medication_name' => $cartItem->medication_name,
                    'price' => $cartItem->price,
                    'quantity' => $cartItem->quantity,
                    'medication_type' => $cartItem->medication_type,
                    'image_url' => $cartItem->image_url
                ]);
            }

            // Clear the cart after successful order
            $cart->items()->delete();

            // Commit the transaction
            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with('orderItems')
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        return view('orders.confirmation', compact('order'));
    }

    public function userOrders()
    {
        $cart = Auth::user()->getOrCreateCart();
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}
