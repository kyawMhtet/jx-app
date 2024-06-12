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

        // return $request->item_id;
        try {

            $validation = $this->validation($request);
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }


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
                'sub_total'    => $request->item_price,
                'total'        => $request->total_price,
                "name"           => $request->name,
                "phone"          => $request->phone,
                "address"        => $request->address,
                "note"           => $request->note,
                "status"         => $status,
                "order_date"     => date('Y-m-d')
            ]);

            $order_id = $order->id;


            // dd($order);
            // dd($order_id);
            // return $order_id;
            // update customer info
            if ($request->customer_info) {
                $customer = Customer::where('id', $request->customer_id)->first();
                $customer->update([
                    'delivery_name' => $request->name,
                    'delivery_contact' => $request->phone,
                    'delivery_address' => $request->address
                ]);
            }

            // dd($order->item_id);
            OrderDetail::create([
                'order_id' => $order_id,
                'item_id' => $request->item_id,
                'price' => $request->item_price,
                'quantity' => $request->item_count,
                'amount' => $request->total_price
            ]);



            $subitem = SubItem::findOrFail($request->item_id);
            $updateStock = $subitem->stock - $request->item_count;
            $subitem->stock = $updateStock;
            $subitem->save();

            Log::info('Order created successfully');

            return redirect()->route('confirm#detail', [
                'sid' => $request->channel_customer_id,
                'od' => $order_id
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
            // return $order->id;
            $branch = Branch::findOrFail($order->branch_id);

            $shop = Shop::findOrFail($branch->shop_id);

            $subItems = SubItem::whereIn('id', $order->order_detail->pluck('item_id'))->get()->keyBy('id');
            // return $subItems;


            return view('confirmation_detail', compact('customer', 'order', 'branch', 'shop', 'subItems'));
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
            $data = Order::findOrFail($request->order_id);
            // return $data;
            $data->update([
                'status' => 'Checkout'
            ]);

            return 'success';
            // return redirect()->route('order#confirmed');
            // return response()->json(['message' => 'Order confirmed successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
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
