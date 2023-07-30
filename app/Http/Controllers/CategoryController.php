<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    // 
    /**
     * Summary of api
     * @param \Illuminate\Http\Request $request
     * @return bool|string
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index_category()
    {
        $categorys = Category::all();
        return view('user.product.category', compact('categorys'));
    }


    public function store_category(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        $name = $request->input('name');

        // Lakukan kueri SQL untuk menyimpan data
        DB::table('categories')->insert([
            'name' => $name,
        ]);


        return Redirect::route('index_category')->with('success', 'Category create successfully');

    }

    public function update_category(Request $request, Category $category)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],

        ]);

        $category->update($request->all());

        return Redirect::route('index_category')->with('success', 'Category delete successfully');

    }

    public function delete_category(Category $category)
    {
        $category->delete();
        return Redirect::route('index_category')->with('success', 'Category delete successfully');
    }



}