<?php

namespace App\Http\Controllers;

use App\Models\Discounts;
use App\Services\Terminal;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    public $terminal;

    /**
     * Cart/Order controller. Handles requests for the POS.
     *
     * @param \App\Services\Terminal $terminal
    */
    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function index(){
        return response()->json([
            'discounts' => Discounts::all()
        ]);
    }

    /**
     * Creates new Discount rule
    */
    public function setDiscount(Request $request){
        $this->terminal->setPricing($request->type, $request->code, $request->quantity, $request->price, $request->bogo_item);
    }

}
