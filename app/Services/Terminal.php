<?php
namespace App\Services;

use App\Models\Discounts;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Terminal{


    public $total;

    /**
     * Creates or updates a price rule.
     * Available discount types are 'pack' (y pcs. for $ x)
     * or 'bogo' (Buy one get one)
     *
     * @param string $type
     * @param string $code
     * @param int|null $quantity
     * @param float|null $price
     * @param string|null $bogo_item
     * @return \Illuminate\Http\JsonResponse
    */
    public function setPricing(string $type = "pack", string $code, int $quantity = null, float $price = null, string $bogo_item = null){

        $validateDiscount = Validator::make(
            [
                'type' => $type,
                'code' => $code,
                'pack_size' => $quantity,
                'pack_value' => $price,
                'bogo_gets' => $bogo_item,
            ],
            [
                'type' => "required",
                'code' => 'exists:products,code',
                'pack_size' => 'required_if:type,==,"pack"',
                'pack_value' => 'required_if:type,==,"pack"',
                'bogo_gets' => 'required_if:type,==,"bogo"'
            ]
        );

        if($validateDiscount->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateDiscount->errors()
            ], 400);
        }

        Discounts::updateOrCreate(
            [
                'type' => $type,
                'applies_to' => $code
            ],
            [
                'pack_size' => $quantity,
                'pack_value' => $price,
                'bogo_gets' => $bogo_item
            ]
        );
        return response("Success", 200);
    }

    /**
     * Scans Item and adds it to active order.
     *
     * @param string $code
     * @return \Illuminate\Http\JsonResponse
    */
    public function scan(string $code){
        try {

            $validateCode = Validator::make(['code' => $code], [
                'code' => 'exists:products,code'
            ]);

            if($validateCode->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateCode->errors()
                ], 400);
            }

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

            $this->applyDiscountRules();

            $this->calculatePrices();

            $order->total = $this->total();

            return response()->json($order);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Calculates total of active order.
     * Returns subtotal, tax and total
     *
     * @return array
    */
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
        $this->total = ['subtotal' => $total, 'tax' => round($tax, 2), 'total' => round($total + $tax, 2)];
        return ['subtotal' => $total, 'tax' => round($tax, 2), 'total' => round($total + $tax, 2)];
    }


    /**
     * Clears items in active order
     *
    */
    public function clear() {
        Auth::user()->order->items()->delete();

        return response("Success", 200);
    }


    /**
     * Calculates each order line item's price
     * price * quantity - discount
     *
    */
    public function calculatePrices(){
        $order = Auth::user()->order;
        if(!empty($order)){
            foreach ($order->items as $item) {
                $item->line_price = round(($item->price * $item->quantity) - $item->line_discount, 2);
            }
        }
        $this->total();
    }

    /**
     * Checks if any discount can be applied to items in order
     *
    */
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
                                if($bogo_product){
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
