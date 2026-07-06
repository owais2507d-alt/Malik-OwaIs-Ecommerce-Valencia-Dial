<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart.index')->with('error', 'Your collection is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('user.cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'shipping_name' => 'required|max:255',
            'phone' => 'required|max:20',
            'address' => 'required',
            'city' => 'required|max:255',
            'postal_code' => 'nullable|max:20',
            'country' => 'required|max:255',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product || $product->stock < $item['quantity']) {
                return back()->with('error', "Insufficient stock for {$item['name']}.");
            }
            $total += $item['price'] * $item['quantity'];
        }

        $order = DB::transaction(function () use ($request, $cart, $total) {
            $orderNumber = 'VD-' . now()->format('Ymd') . '-' . str_pad(Order::max('id') + 1 ?? 1, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_postal_code' => $request->postal_code,
                'shipping_country' => $request->country,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
            ]);

            foreach ($cart as $id => $item) {
                $order->items()->create([
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                Product::where('id', $id)->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('user.home')
            ->with('success', "Order {$order->order_number} placed successfully! Thank you for your purchase.");
    }
}
