<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show_profile()
    {
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('edit_profile', compact('user'));
    }


    public function update_profile(Request $request)
    {
        $user_id = Auth::id();
        $updateProfileCart = $request->cart;

        $request->validate([
            'name' => 'required',
            'email' => 'required|max:50|unique:users,email,' . $user_id,
            'telp' => 'required|max:13|unique:users,telp,' . $user_id,
            'alamat' => 'required',
            'password' => 'nullable|min:8|confirmed'
        ]);



        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telp = $request->telp;
        $user->alamat = $request->alamat;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($updateProfileCart == 'yes') {
            return Redirect::route('show_cart');

        } else {
            return Redirect::back();
        }

    }

}