<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    // 
    /**
     * Summary of api
     * @param \Illuminate\Http\Request $request
     * @return bool|string
     */

    public function index_product()
    {

        $products = Product::all();
        $categorys = Category::all();
        return view('user/product/index', compact('products', 'categorys'));
    }

    public function add()
    {
        $categorys = Category::all();
        return view('user.product.add', compact('categorys'));
    }
    public function api()
    {
        $products = Product::all();
        $products->transform(function ($product) {
            $product->category_id = nameCategory($product->category_id);

            return $product;
        });
        return json_encode($products);

    }

    public function store_product(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'stock_type' => 'required'
        ]);

        // Menyimpan gambar
        $imagePath = $request->file('image')->store('product_images', 'public');

        // Membuat produk baru
        $price = str_replace('.', '', $request->input('price'));
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $price,
            'image' => $imagePath
        ]);


        // Menyimpan stok berdasarkan tipe
        if ($request->stock_type === 'no-option') {
            Stock::create([
                'product_id' => $product->id,
                'optional' => null,
                'stock' => $request->stock
            ]);
        } elseif ($request->stock_type === 'optiont') {
            $options = $request->input('options');

            if (!empty($options) && is_array($options)) {
                foreach ($options as $option) {

                    Stock::create([
                        'product_id' => $product->id,
                        'optional' => $option['optional'],
                        'stock' => $option['stock']
                    ]);
                }
            }
        }

        // Redirect atau response yang sesuai
        return redirect()->route('index_product')->with('success', 'Produk berhasil ditambahkan!');
    }





    public function show_product(Product $product)
    {
        $products = Product::with('stocks')->find($product->id);
        $stocks = Stock::where('product_id', $product->id)->get();
        return view('user/product/show', compact('product', 'products', 'stocks'));
    }

    public function edit_product(Product $product)
    {
        $categorys = Category::all();
        $stocks = Stock::where('product_id', $product->id)->get();
        return view('user.product.update', compact('product', 'categorys', 'stocks'));
    }

    public function update_product(Request $request, Product $product)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock_type' => 'required',
            'stock' => 'required_if:stock_type,no-option',
            'options' => 'required_if:stock_type,optiont|array|min:1',
            'options.*.optional' => 'required',
            'options.*.stock' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->description == null) {
            $description = $product->description;
        } else {
            $description = $request->description;
        }

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $description;
        $product->price = $request->price;
        $product->save();

        // Update data product


        // Update data stocks
        if ($request->stock_type == 'no-option') {
            // Update stock tanpa opsi
            $product->stocks()->delete(); // Hapus data stock yang ada sebelumnya
            $product->stocks()->create([
                'stock' => $request->stock
            ]);
        } elseif ($request->stock_type == 'optiont') {
            // Update stock dengan opsi
            $product->stocks()->delete(); // Hapus data stock yang ada sebelumnya

            $options = $request->options;
            foreach ($options as $option) {
                $product->stocks()->create([
                    'optional' => $option['optional'],
                    'stock' => $option['stock'],
                ]);
            }
        }

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $product->image = $imagePath;
            $product->save();
        }

        // Redirect atau berikan response sukses
        return Redirect::route('index_product')->with('success', 'Product updated successfully');
    }

    public function delete_product(Product $product)
    {
        $product->delete();
        return Redirect::route('index_product');
    }
}