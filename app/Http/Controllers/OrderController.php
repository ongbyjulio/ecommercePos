<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index_order()
    {
        $user = Auth::user();
        $is_admin = $user->is_admin;
        if ($is_admin) {
            $orders = Order::all();
        } else {
            $orders = Order::where('user_id', $user->id)->get();
        }


        return view('user.order.index', compact('orders'));
    }


    public function api()
    {
        $user = Auth::user();
        $is_admin = $user->is_admin;

        if ($is_admin) {
            $orders = Order::all();
        } else {
            $orders = Order::where('user_id', $user->id)->get();
        }

        $orders->transform(function ($order) {
            $order->user_id = getNameUser($order->user_id);
            $order->created_at = date_Iso($order->created_at);
            return $order;
        });

        return json_encode($orders);
    }

    public function api_edit($orderId)
    {
        $orders = Order::where('id', $orderId)->get();
        return json_encode($orders);
    }


    public function detail_order(Order $order)
    {

        return view('user.order.detail', compact('order'));
    }


    public function message_order(Order $order, Request $request)
    {
        $orders = $order->id;
        $user = Auth::user();
        $request->validate([
            'message' => 'required'
        ]);

        Message::create([
            'message' => $request->message,
            'order_id' => $orders,
            'user_id' => $user->id
        ]);

        return redirect()->back();

    }

    public function checkout(Request $request)
    {


        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();

        $user = User::find($user_id);

        // dd($user->name);
        //jika carts kosong
        if ($carts == null) {
            return Redirect::route('index_product');
        }

        if ($user->alamat == null && $user->telp == null) {
            return Redirect::route('show_cart')->with('danger', 'Address or Telp required.');
        }

        //jika carts ada 
        $order = Order::create([
            'user_id' => $user_id,
            'comment' => $request->comment
        ]);

        foreach ($carts as $cart) {

            if ($cart->optional == null) {
                $stocks = Stock::where('product_id', $cart->product_id)->get();
                $totalAmount = $cart->amount;

                foreach ($stocks as $stock) {
                    $stock->update([
                        'stock' => $stock->stock - $totalAmount
                    ]);
                }
            } else {

                $selectedIds = explode(',', $cart->optional); // Jika $cart->optional berisi daftar id yang dipisahkan dengan koma, pisahkan id-nya
                $stocks = Stock::whereIn('id', $selectedIds)->get();

                $totalAmount = $cart->amount;
                foreach ($stocks as $stock) {

                    $stock->update([
                        'stock' => $stock->stock - $totalAmount
                    ]);
                }
            }

            Transaction::create([
                'amount' => $totalAmount,
                'order_id' => $order->id,
                'optional' => $cart->optional,
                'product_id' => $cart->product_id
            ]);
            $cart->delete();
        }
        return Redirect::route('index_order');
    }


    public function submit_payment_receipt(Order $order, Request $request)
    {
        $request->validate([
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('payment_receipt');
        $path = time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();

        //untuk setup handle file jalankan perintah php artisan storage:link supaya file bisa diakses oleh publik 
        Storage::disk('local')->put('public/' . $path, file_get_contents($file));
        $order->update([
            'payment_receipt' => $path
        ]);

        return Redirect::back();
    }

    public function confirm_payment(Order $order)
    {
        if ($order->payment_receipt === null) {
            return redirect()->back()->withErrors('Payment receipt is not available.');
        }


        $order->update([
            'is_paid' => true
        ]);

        return Redirect::back();
    }
    public function confirm_status(Order $order, Request $request)
    {
        $status = $request->status;
        if ($order->payment_receipt === null) {
            return redirect()->back()->withErrors('Payment receipt is not available.');
        }
        if ($request->status == null) {
            $status = $order->status;
        }

        $order->update([
            'status' => $status
        ]);

        return Redirect::back();
    }
}