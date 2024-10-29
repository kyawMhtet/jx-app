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
use App\Models\BankInfo;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //


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

    // order form
    public function orderForm(Request $request)
    {
  
        try {
            $customer = Customer::where('channel_customer_id', $request->sid)->first();
            $campaign = Campaign::where('id', $request->cid)->first();
            $order = Order::where('id', $request->oid)->with('order_detail')->first();
            $order_details = $order->order_detail;
            $items = SubItem::whereIn('id', $order_details->pluck('item_id'))->get()->keyBy('id');
            $totalPrice = $items->sum('price');

            $branch = Branch::where('id', $order->branch_id)->with('bankInfo')->first();
            $paymentMethods = $branch->bankInfo;
            $shop = Shop::findOrFail($branch->shop_id);

            // $latestOrder = Order::where('customer_id', $customer->id)
            //     ->orderBy('id', 'desc')
            //     ->first();

            // $previousCustomerData = [
            //     'name' => '',
            //     'phone' => '',
            //     'address' => '',
            //     'note' => '',
            //     'payment_method' => ''
            // ];

            // if ($latestOrder) {
            //     $previousOrder = Order::where('customer_id', $customer->id)
            //         ->where('id', '<', $latestOrder->id)
            //         ->orderBy('id', 'desc')
            //         ->first();

            //     if ($previousOrder) {
            //         $previousCustomerData = [
            //             'name' => $previousOrder->name,
            //             'phone' => $previousOrder->phone,
            //             'address' => $previousOrder->address,
            //             'note' => $previousOrder->note,
            //             'payment_method' => $previousOrder->payment_method
            //         ];
            //     }
            // }

            $currentDate = Carbon::now()->format('d/m/Y');

            return view('order_form', compact('items', 'customer', 'order', 'order_details', 'campaign', 'paymentMethods', 'totalPrice', 'currentDate'));
        } catch (\Throwable $th) {
            Log::error("Error in orderForm method: " . $th->getMessage());
            
            return redirect()->back()->with('error', 'Failed to load order form');
        }
    }



    // order by user
    public function userOrderCreate(Request $request)
    {
        // dd($request->all());
        try {
            // $validation = $this->validati/on($request);
            // if ($validation->fails()) {
            //     return redirect()->back()->withErrors($validation)->withInput();
            // }
            $customer_name = $request->name;
            $customer_phone = $request->phone;
            $customer_address = $request->address;
            // $order = Order::findOrFail($request->oid);
            $order = Order::with('order_detail')->where('id', $request->oid)->first();
            // return $order;
            $order_detail = OrderDetail::where('order_id', $order->id)->first();
          
            if ($request->customer_info) {
                $customer = Customer::where('id', $request->customer_id)->first();
                if ($customer) {
                    $customer->update([
                        'delivery_name' => $request->name,
                        'delivery_contact' => $request->phone,
                        'delivery_address' => $request->address
                    ]);
                } else {
                    Log::error('Customer not found: ' . $request->customer_id);
                }
            }

            $order->update([
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            $order_detail->avi_quantity = $order_detail->quantity;
            $order_detail->save();

            Log::info('Order updated successfully');

            return redirect()->route('confirm#detail', [
                'sid' => $request->channel_customer_id,
                'od' => $order->id,
                'customer_name' => $customer_name,
                'customer_phone' => $customer_phone,
                'customer_address' => $customer_address,
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating order: ' . $th->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the order. Please try again.');
        }
    }




    // confirmation detail
    public function confirmationDetail(Request $request)
    {

        // dd($request->all());
        try {


            $customer = Customer::where('channel_customer_id', $request->sid)->first();
            
            $name = $request->customer_name;
            $phone = $request->customer_phone;
            $address = $request->customer_address;

            $order = Order::where('id', $request->od)->with('order_detail')->first();
            $branch = Branch::where('id', $order->branch_id)->with('bankInfo')->first();
            $paymentMethods = $branch->bankInfo;
            // return $order;
            $order_details = $order->order_detail;
            // return $order_details;

            $branch = Branch::findOrFail($order->branch_id);

            $shop = Shop::findOrFail($branch->shop_id);

            $subItems = SubItem::whereIn('id', $order_details->pluck('item_id'))->get()->keyBy('id');
            // return ($subItems);

            return view('confirmation_detail', compact('customer', 'name', 'phone', 'address', 'order', 'branch', 'shop', 'subItems', 'order_details', 'paymentMethods'));
            // return view('/');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('errorConfirmDetail');
        }
    }



    // confirm order
    public function confirmOrder(Request $request)
    {
        // dd($request->all());
        // return $data;
        // $order = Order::with('order_detail')->where('id', $request->oid)->first();

        $validation = $this->validation($request);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            $data = Order::findOrFail($request->od);
            $data->update([
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => 'Checkout'
            ]);

            // return 'success';
            return redirect()->route('order#confirmed');
        } catch (\Throwable $th) {
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

            'payment_method' => 'required',
            "name"           => 'required',
            "phone"          => 'required',
            "address"        => 'required',

        ]);
    }
}
