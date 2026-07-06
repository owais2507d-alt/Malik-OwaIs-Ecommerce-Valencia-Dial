<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.cart', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
                'stock' => $product->stock,
                'brand' => $product->brand,
            ];
        }

        if ($cart[$product->id]['quantity'] > $product->stock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        session()->put('cart', $cart);

        return redirect()->route('user.cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Product not in cart.');
        }

        $quantity = max(1, (int) $request->input('quantity'));

        if ($quantity > $cart[$id]['stock']) {
            return back()->with('error', 'Not enough stock.');
        }

        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return redirect()->route('user.cart.index')->with('success', 'Cart updated.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('user.cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('user.cart.index')->with('success', 'Cart cleared.');
    }
}
