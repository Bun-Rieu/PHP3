<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        return view('user.products.list');
    }

    public function show()
    {

        return view('user.products.show');

    }
}
