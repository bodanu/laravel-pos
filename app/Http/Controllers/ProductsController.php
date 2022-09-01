<?php

namespace App\Http\Controllers;

use App\Models\Products;

class ProductsController extends Controller
{
    public function index(){
        return response()->json(
            [
                'products' => Products::all()
            ]
        );
    }
}
