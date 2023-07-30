<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $costumer = User::all();

        $data_products = Product::select(DB::raw("count(category_id) as total"))->groupby("category_id")->orderby("category_id", "asc")->pluck('total');
        $label_category = Category::orderBy("categories.id", "asc")->join("products", "products.category_id", "=", "categories.id")->groupby("categories.name")->pluck('categories.name');
        // dd($data_products);
        return view('user.dashboard', compact('costumer', 'data_products', 'label_category'));
    }

    public function index_user()
    {
        return view('user.profile.costumer');
    }

    public function apiSale($year)
    {
        $salesData = [];
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        foreach ($months as $month) {
            $sale = Order::select(DB::raw("count(status) as total"))
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('status', 2)
                // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                ->pluck('total')
                ->first();

            $totalSale = $sale ? $sale : 0;

            $salesData[] = $totalSale;
        }

        return json_encode($salesData);

    }

    public function apiUser()
    {
        //
        $users = \App\Models\User::withCount('orders')->get();

        $users->transform(function ($user) {
            $user->totalTransaction = $user->orders_count;
            unset($user->orders_count);

            $user->created_at = date_Iso($user->created_at);
            return $user;
        });

        return json_encode($users);
    }

}