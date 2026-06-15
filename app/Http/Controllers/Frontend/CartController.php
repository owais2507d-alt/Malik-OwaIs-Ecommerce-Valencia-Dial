<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Watch;

class CartController extends Controller
{
      // show cart items :::
      public function index(){
        $cart =session()->get('cart',[]);
        return view('frontend.cart',compact('cart'));
      }

      ////push item to cart session 

      public function add(Request $request){
        $watch =Watch::findOrFail($request->watch_id);
        $cart =session()->get('cart',[]);

        //// if item already exists in cart 

        if(isset($cart[$watch->id])){
            return redirect()->back()->with('success','Watch already allocated in your vault session.');
        }

        /// structure map for watch entry 
$cart[$watch->id] = [
            "name" => $watch->name,
            "brand" => $watch->brand,
            "price" => $watch->price,
            "image" => $watch->image,
            "reference" => $watch->reference_number ?? 'N/A'
        ];
        session()->put('cart',$cart);
        return redirect()->route('cart.index')->with('success', 'Masterpiece added to your vault access.');

}

public function remove($id){
   $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Allocation request revoked.');
    }
}