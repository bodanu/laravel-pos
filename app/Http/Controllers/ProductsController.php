<?php

namespace App\Http\Controllers;

use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function index(){
        return response()->json(
            [
                'products' => Products::all()
            ]
        );
    }
}
