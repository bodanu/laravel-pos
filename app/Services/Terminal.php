<?php
namespace App\Services;

use App\Models\Discounts;
use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Terminal{

    public function scan(string $code){
        $order = Auth::user()->order;
        $product = Products::where('code', '=', $code )->firstOrFail();

        $order->items()->updateOrcreate(
        [
            'product_id' => $product->id,
            'bogo' => NULL,
        ],
        [
            'price' => $product->price,
            'code' => $product->code,
            'order_id' => $order->id,
        ])->increment('quantity');
        // Log::info($order);

        $this->applyDiscountRules();

        $this->setPricing();

        $order->total = $this->total();

        return response()->json($order);
    }

    public function total() {
        // Log::info(Auth::user());
        $order = Auth::user()->order;
        $total = 0;
        if(!empty($order)){
            foreach ($order->items as $item) {
                $total += $item->line_price;
            }
        }
        $tax = 0.1 * $total;
        return ['subtotal' => $total, 'tax' => round($tax, 2), 'total' => round($total + $tax, 2)];
        // return round($total + $tax, 2);
    }

    public function clear() {
        Auth::user()->order->items()->delete();

        return response("Success", 200);
    }

    public function setPricing(){
        $order = Auth::user()->order;
        if(!empty($order)){
            foreach ($order->items as $item) {
                $item->line_price = round(($item->price * $item->quantity) -$item->line_discount, 2);
            }
        }
    }

    protected function applyDiscountRules(){
        $order = Auth::user()->order;
        if(!empty($order)){
            $discounts = Discounts::all();
            foreach ($discounts as $discount) {
                switch ($discount->type) {
                    case 'pack':
                        foreach ($order->items as $item) {
                            if($item->code == $discount->applies_to && ($item->quantity % $discount->pack_size == 0)){
                                $dsc_value = ($item->quantity * $item->price) - ($discount->pack_value * intdiv($item->quantity, $discount->pack_size));
                                $item->line_discount = $dsc_value;
                                $item->save();
                            }
                        }
                        break;
                    case 'bogo':
                        if(!$order->items->contains('bogo', 'bogo')){
                            foreach ($order->items as $item) {
                                $bogo_product = $item->where('code', '=', $discount->applies_to)->first();
                                $product = Products::where('code', '=', $discount->bogo_gets )->firstOrFail();
                                if($bogo_product && !empty($bogo_product)){
                                    if($item->code == $product->code){
                                        $item->bogo = "bogo";
                                        $item->line_discount = $product->price;
                                        $item->save();
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        }
    }



}
