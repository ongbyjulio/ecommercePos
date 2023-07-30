<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    public function api($orderId)
    {
        // $user = Auth::user();

        // $order = Order::where('')->get();
        // $messages = Message::where('order_id', 3)->get();
        // return json_encode($messages);

        $messages = Message::where('order_id', $orderId)->get();
        return json_encode($messages);
    }


}