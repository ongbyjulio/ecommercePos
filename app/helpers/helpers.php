<?php
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

function price($angka)
{

    $price = "Rp. " . number_format($angka, 2, ',', '.');
    return $price;

}
// nameFormat(name) {
//     return this.name(name);
// },
// name(value) {
//     if (value.length > 17) {
//         return value.substring(0, 17) + "..";
//     }
//     return value;
// },
function names($value)
{
    if (strlen($value) > 17) {
        return substr($value, 0, 17) . "..";
    }
    return $value;
}

function nameCategory($id)
{

    return DB::table('categories')
        ->where('id', $id)
        ->pluck('name')
        ->first();

}

function totalOrder($id)
{

    return DB::table('orders')
        ->where('status', 2)
        ->count();

}


function getAllTotalProduct()
{
    return Product::count();

}
function getAllStockNull()
{
    return Stock::where('stock', '<', 1)->count();

}
function getAllStockNotNull()
{
    return Stock::where('stock', '>', 1)->count();

}
function getAllTotalUser()
{
    return User::count();

}

function getOptional($id)
{

    return DB::table('stocks')
        ->where('id', $id)
        ->pluck('optional')
        ->first();



}

function getNameUser($id)
{

    $name = DB::table('users')
        ->where('id', $id)
        ->pluck('name')
        ->first();

    return ucwords($name);

}




function getTotalCartByUserId($userId)
{
    return DB::table('carts')
        ->where('user_id', $userId)
        ->count('user_id');
}

function date_formats($value)
{
    return date('H:i:s - d M Y', strtotime($value));
}

function date_Iso($value)
{

    $utcDateTime = new DateTime($value, new DateTimeZone('UTC'));
    $utcDateTime->setTimezone(new DateTimeZone('Asia/Jakarta'));
    return $utcDateTime->format('Y-m-d H:i:s');
}



if (!function_exists('getCartItemCount')) {
    function getCartItemCount()
    {
        $user = auth()->user();
        if ($user && $user->cart) {
            return $user->cart->count();
        }
        return 0;
    }
}

?>