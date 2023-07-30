<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //




    public function add_to_cart(Product $product, Request $request)
    {

        $user_id = Auth::id();
        $product_id = $product->id;

        $stocks = Stock::where('product_id', $product_id)->get();
        // dd($stocks);
        if ($stocks->count() > 1) {
            // If 'id_stocks' exists, use its value
            $stockRequest = $request->id_stocks;
            $stockId = Stock::where('id', $stockRequest)->value('stock');
            $cartStockStatus = Cart::where('optional', $stockRequest)->value('optional');
            $existing_cart = Cart::where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->where('optional', $request->id_stocks)
                ->first();

        } else {
            $stockRequest = $product->id;
            $stockId = Stock::where('product_id', $stockRequest)->value('stock');
            $cartStockStatus = Cart::where('product_id', $stockRequest)->value('product_id');
            $existing_cart = Cart::where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->first();
        }

        // dd($existing_cart);

        //$existing_cart == null ||
        if ($existing_cart == null) {

            $request->validate([
                //documentasi laravel validataion 
                'amount' => 'required|gte:1|lte:' . $stockId
            ]);


            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'amount' => $request->amount,
                'optional' => $request->id_stocks

            ]);

        } else {

            $request->validate([
                //documentasi laravel validataion 
                //TOTAL 5  2 = 3
                'amount' => 'required|gte:1|lte:' . ($stockId - $existing_cart->amount)
            ]);

            $existing_cart->update([
                'amount' => $existing_cart->amount + $request->amount
            ]);
            return Redirect::route('show_cart');
        }


        return Redirect::route('index_product');
    }



    public function show_cart()
    {

        // $stock = Stock::find(1);
        // dd($stock);
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
        return view('user.cart.index', compact('carts'));
    }

    public function update_cart(Cart $cart, Request $request)
    {
        $productId = $request->productId;
        $stockId = $request->stockId;
        $stocks = Stock::where('product_id', $productId)->get();
        // dd($stocks);
        if ($stocks->count() > 1) {
            $stockQuantity = Stock::where('id', $stockId)->value('stock');
        } else {
            $stockQuantity = Stock::where('product_id', $productId)->value('stock');

        }

        //lte agar tidak melebihi batas stock asli
        $request->validate([
            'amount' => 'required|gte:1|lte:' . $stockQuantity
        ]);

        $cart->update([
            'amount' => $request->amount
        ]);
        return Redirect::route('show_cart');
    }

    public function delete_cart(Cart $cart)
    {
        $cart->delete();
        return Redirect::back();
    }
}