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
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;

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

        $customer = Customer::where('channel_customer_id', $request->sid)->first();
        // return $customer;
        $campaign = Campaign::where('id', $request->cid)->first();
        // $item = SubItem::where('id', $request->iid)->get();
        $order = Order::where('id', $request->oid)->with('order_detail')->first();
        $order_details = $order->order_detail;
        // return $order_details;
        $item_ids = $order_details->pluck('item_id');
        // return $item_ids;
        // $items = SubItem::whereIn('id', $item_ids)->get();
        $items = SubItem::whereIn('id', $order_details->pluck('item_id'))->get()->keyBy('id');
        // return $items;
        $totalPrice = $items->sum('price');

        $previousOrder = Order::where('customer_id', $customer->id)
            ->orderBy('id', 'desc')
            ->first();
        // return $previousOrder;

        $currentDate = Carbon::now()->format('d/m/Y');

        return view('order_form', compact('items', 'customer', 'order', 'order_details', 'campaign', 'totalPrice', 'currentDate', 'order', 'previousOrder'));
    }


    // order by user
    public function userOrderCreate(Request $request)
    {
        // dd($request->all());

        // return $request->item_id;
        try {

            $validation = $this->validation($request);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $order = Order::findOrFail($request->oid);
            // return $order;

            if ($request->customer_info) {
                $customer = Customer::where('id', $request->customer_id)->first();
                $customer->update([
                    'delivery_name' => $request->name,
                    'delivery_contact' => $request->phone,
                    'delivery_address' => $request->address
                ]);
            } else {
                $order->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address
                ]);
            }


            Log::info('Order created successfully');
            return redirect()->route('confirm#detail', [
                'sid' => $request->channel_customer_id,
                'od' => $order->id
            ]);
        } catch (\Throwable $th) {
            // dd($th);
            Log::error("error creating order");
        }
    }



    // confirmation detail
    public function confirmationDetail(Request $request)
    {

        // dd($request->all());
        try {
            $customer = Customer::where('channel_customer_id', $request->sid)->first();

            $order = Order::where('id', $request->od)->with('order_detail')->first();
            // return $order;
            $order_details = $order->order_detail;
            // $order_details = OrderDetail::where('order_id', $request->od)->get();
            // return $order_details;
            $branch = Branch::findOrFail($order->branch_id);

            $shop = Shop::findOrFail($branch->shop_id);

            $subItems = SubItem::whereIn('id', $order_details->pluck('item_id'))->get()->keyBy('id');
            // return ($subItems);

            return view('confirmation_detail', compact('customer', 'order', 'branch', 'shop', 'subItems', 'order_details'));
            // return view('/');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('errorConfirmDetail');
        }
    }



    // confirm order
    public function confirmOrder(Request $request)
    {
        // return $request->all();
        // return $data;
        try {
            $data = Order::findOrFail($request->od);
            // return $data;
            // dd($data);
            $data->update([
                'status' => 'Checkout'
            ]);

            // return 'success';
            return redirect()->route('order#confirmed');
            // return redirect()->back();
            // return response()->json(['message' => 'Order confirmed successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th);
            Log::error('error update confirm order status');
        }
    }


    // order confirmed page
    public function orderConfirmed()
    {
        return view('order_confirmed');
    }


    // validation
    private function validation($request)
    {
        return Validator::make($request->all(), [
            // 'branch_id'    => 'required',
            // 'campaign_id'  => 'required',
            // 'customer_id'  => 'required',
            // 'payment_method' => 'required',
            // 'discount' => 0,
            // 'tax' => 0,
            "name"           => 'required',
            "phone"          => 'required',
            "address"        => 'required',
        ]);
    }
}
