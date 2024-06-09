<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Branch;
use App\Models\SubItem;
use App\Models\Campaign;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateOrderRequest;

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

    public function detail(Request $request)
    {
        try {
            $customer = Customer::where('id', $request->sid)->first();

            $item = SubItem::where('id', $request->siid)->first();



            $branch = Branch::findOrFail($item->branch_id);
            $shop = Shop::findOrFail($branch->shop_id);

            $item_desc = Item::findOrFail($item->item_id);


            return view('item_detail', compact('item', 'customer', 'shop', 'item_desc'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("error item detail");
        }
    }

    //
    public function orderForm(Request $request)
    {

        $customer = Customer::where('id', $request->sid)->first();
        // return $customer;
        $campaign = Campaign::where('id', $request->cid)->first();
        // dd($campaign);
        $item = SubItem::where('id', $request->iid)->first();

        $currentDate = Carbon::now()->format('d/m/Y');

        return view('order_form', compact('item', 'customer', 'campaign', 'currentDate'));
    }


    // order by user
    public function userOrderCreate(Request $request)
    {
        // dd($request->all());

        try {
            $status = 'new_order';
            if ($request->payment == 'Paid') $status = 'placed_order';
            else if ($request->payment == 'COD') $status = 'placed_order';
            else $status = 'confirmed_order';

            // dd($status);
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'branch_id'    => $request->branch_id,
                'campaign_id'  => $request->campaign_id,
                'customer_id'  => $request->customer_id,
                'item_count'  => $request->item_count,
                'payment_method' => $request->payment,
                'discount' => 0,
                'tax' => 0,
                'sub_total'    => $request->total_price,
                'total'        => $request->total_price,
                "name"           => $request->name,
                "phone"          => $request->phone,
                "address"        => $request->address,
                "note"           => $request->note,
                "status"         => $status,
                "order_date"     => date('Y-m-d')
            ]);

            $order_id = $order->id;

            // update customer info
            if ($request->customer_info) {
                $customer = Customer::where('id', $request->customer_id)->first();
                $customer->update([
                    'delivery_name' => $request->name,
                    'delivery_contact' => $request->phone,
                    'delivery_address' => $request->address
                ]);
            }

            Log::info('Order created successfully');

            return redirect()->route('confirm#detail', [
                'sid' => $request->customer_id,
                'oid' => $order_id
            ]);
        } catch (\Throwable $th) {
            Log::error("error creating order");
        }
    }



    // confirmation detail
    public function confirmationDetail(Request $request)
    {
        try {
            $customer = Customer::where('id', $request->sid)->first();

            $order = Order::findOrFail($request->oid);

            $branch = Branch::findOrFail($order->branch_id);

            $shop = Shop::findOrFail($branch->shop_id);

            return view('confirmation_detail', compact('customer', 'order', 'branch', 'shop'));
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('errorConfirmDetail');
        }
    }
}
