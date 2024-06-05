<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Customer;

class OrderController extends Controller
{
    //

    private function generateOrderNumber()
    {
        $length = 5;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public function detail($id)
    {
        // return $id;
        $item = Item::find($id);
        return view('item_detail', compact('item'));
    }

    // 
    public function orderForm($id)
    {
        $item = Item::find($id);

        $customer = Customer::where('id', 22)->first();
        return view('order_form', compact('item', 'customer'));
    }


    // order by user
    public function userOrderCreate(Request $request)
    {
        // dd($request->all());
        // dd($request->customer_info);

        try {
            $status = 'new_order';
            if ($request->payment == 'Paid') $status = 'placed_order';
            else if ($request->payment == 'COD') $status = 'placed_order';
            else $status = 'confirmed_order';

            // dd($status);
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'branch_id'    => 2,
                'campaign_id'  => 0,
                'customer_id'  => 2,
                'item_count'  => $request->item_count,
                'payment_method' => $request->payment,
                'discount' => 0,
                'tax' => 0,
                'sub_total'    => 0,
                'total'        => $request->total_price,
                "name"           => $request->name,
                "phone"          => $request->phone,
                "address"        => $request->address,
                "note"           => null,
                "delivery_date" => null,
                "delivery_name" => null,
                "delivery_address" => null,
                "delivery_phone" => null,
                "status"         => $status,
                "order_date"     => date('Y-m-d')
            ]);

            $order_id = $order->id;

            // update customer info 
            if ($request->customer_info) {
                $customer = Customer::where('id', $request->customer_id)->first();
                // return $customer->id;
                $customer->update([
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'branch_id' => $order->branch_id,
                ]);
            }

            Log::info('Order created successfully');

            return redirect()->route('confirm#detail', $order_id);
        } catch (\Throwable $th) {
            Log::error("error creating order");
        }
    }



    // confirmation detail
    public function confirmationDetail($id)
    {
        // return $id;
        $detail = Order::where('id', $id)->first();
        // return $detail;
        $branch = Branch::where('id', $detail->branch_id)->first();

        return view('confirmation_detail', compact('detail', 'branch'));
    }
}
