<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public $order;
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
     * Collects data regarding the active order.
     * Creates new blank order if there is none
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function collect(){
        $this->order = Auth::user()->order ?? $this->createEmptyOrder();
        $this->terminal->calculatePrices();
        $this->order->total = $this->terminal->total;

        return response()->json([
                'order' => $this->order,
            ]);
    }

    /**
     * Calculates and returns total of active order.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function total(){
        return response()->json([
            'total' => $this->terminal->total,
        ]);
    }

    /**
     * Scans item and adds it to active order
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
    */

    public function scan(Request $request){
        return $this->terminal->scan($request->code);
    }

    /**
     * Clears items from active order
     *
    */
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
