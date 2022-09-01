<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use App\Services\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public $order;
    public $terminal;

    /**
     * Cart/Order controller. Handles requests for the POS.
     *
     * @param \App\Services\Terminal
    */
    public function __construct(Terminal $terminal)
    {
        $this->terminal = $terminal;
    }

    public function collect(){
        $this->order = Auth::user()->order ?? $this->createEmptyOrder();
        $this->terminal->setPricing();
        $this->order->total = $this->terminal->total();

        return response()->json([
                'order' => $this->order,
            ]);
    }

    public function total(){
        return response()->json([
            'total' => $this->terminal->total(),
        ]);
    }

    public function scan(Request $request){
        return $this->terminal->scan($request->code);
    }

    public function clear(){

        $this->terminal->clear();

    }

    protected function createEmptyOrder(){
        Order::create([
            'user_id' => Auth::user()->id
        ]);

       return Auth::user()->order;
    }
}
