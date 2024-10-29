<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Detail</title>

    <script src="https://connect.facebook.net/en_US/messenger.Extensions.js"></script>

    <link rel="stylesheet" href="{{ asset('css/confirm_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order_form.css') }}">
</head>
<body>

<div class="container">
@if ($errors->any())
    <div class="custom-alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
@endif
<form id="confirmationForm" action="{{ route('confirm#order') }}" method="POST">
    @csrf

    <input type="hidden" name="od" value="{{ $order->id }}">
    <div class="info">
        <h3>Confirmation Detail</h3>
        <hr>

        <div>
            <h4>Seller Info</h4>
            <div class="seller_info">
                <img src="https://scontent.fbkk8-2.fna.fbcdn.net/v/t39.30808-6/302693478_390123153276794_3073543938523926457_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=5f2048&_nc_ohc=CHV9CMIAF6QQ7kNvgGskeD_&_nc_ht=scontent.fbkk8-2.fna&oh=00_AYAHJ6cRu8h379X9MIbn9CU_RcjqhN7dr3UvgATdoZULSg&oe=665F37AE" alt="">

                <h4>{{ $shop->name }}</h4>
            </div>
        </div>

        <!-- <hr> -->

        <!-- <div class="payment">
            <h4>Payment Info</h4>
            <div>
                <p>Status</p>
                <small>{{ $order->status }}</small>
            </div>
        </div>

        <hr>
        <div class="payment">
            <div>
                <p>Updated at</p>
                <small>{{ $order->updated_at->format('d F Y, H:i') }}</small>
            </div>
        </div> -->
    </div>

    <div class="lists">
        @foreach ($order_details as $order_detail)
            @php
                $item = $subItems->firstWhere('id', $order_detail['item_id']);
            @endphp

            @if ($item)
            <div class="item-list">
                <img src="{{ $item->image_url }}" alt="">

                <div class="">
                    <p class="name">{{ $item->sub_item_name }}</p>

                    <div class="item-amount">
                        <p>{{ number_format($item->price, 0) }} Ks</p>
                        <span>Qty: {{ $order_detail['quantity'] }}</span>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <div class="lists">
        <table class="item-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price (Ks)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_details as $order_detail)
                    @php
                        $item = $subItems->firstWhere('id', $order_detail['item_id']);
                    @endphp
                    @if ($item)
                        <tr>
                            <td>{{ $item->sub_item_name }}</td>
                            <td>
                                <!-- Hidden input for quantity with class `quantity` and price attribute -->
                                <input type="hidden" class="quantity" value="{{ $order_detail['quantity'] }}" data-price="{{ $item->price }}">
                                {{ $order_detail['quantity'] }}
                            </td>
                            <td>{{ number_format($item->price, 0) }} Ks</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="2">Discount</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td colspan="2">Delivery Fee</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Total Price</strong></td>
                    <td><strong id="totalPrice">0 Ks</strong></td> <!-- Total Price will be updated here -->
                </tr>
            </tbody>
        </table>
    </div>

    <div class="container">
        <form id="orderForm" action="{{ route('user#checkout') }}" method="POST">
            @csrf

            <input type="hidden" name="total_price" id="hiddenTotalPrice" value="0">
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            <input type="hidden" name="channel_customer_id" value="{{ $customer->channel_customer_id }}">
            <input type="hidden" name="oid" value="{{ $order->id }}">

            <div class="amount">
                <label for="name" class="@error('name') name-label-invalid @enderror">Name</label>
                <div class="">
                    <input type="text" name="name" id="name" value="{{ $name }}"
                    class="@error('name') name-invalid @enderror">
                    <span>
                </div>
            </div>

            <div class="amount">
                <label for="phone" class="@error('phone') phone-label-invalid @enderror">Phone</label>
                <div class="">
                    <input type="text" name="phone" id="phone" value="{{ $phone }}"
                    class="@error('phone') phone-invalid @enderror">
                    <span>
                </div>
            </div>

            <div class="amount">
                <label for="address" class="@error('address') address-label-invalid @enderror">Address</label>
                <div class="">
                    <textarea name="address" id="address" cols="" rows="3">{{ $address }}</textarea>
                    <span>
                </div>
            </div>

            <div class="amount">
                <label for="note">Note (optional)</label>
                <div class="">
                    <textarea name="note" id="note" cols="" rows="3">{{ old('note', '') }}</textarea>
                </div>
            </div>

            
            <div class="amount">
            <label for="">Choose Payments</label>
            <div class="selectdiv">
                <select name="payment_method" id="paymentMethod">
                    @foreach($paymentMethods as $payment)
                    <option value="{{ $payment->bank_name }}" {{ old('payment_method') == $payment->bank_name ? 'selected' : '' }}>{{ $payment->bank_name }}</option>
                    @endforeach

                    <option value="COD" {{ old('payment_method', 'COD') == 'COD' ? 'selected' : '' }}>Cash On Delivery</option>
                    <option value="kpay" {{ old('payment_method') == 'kpay' ? 'selected' : '' }}>KPay</option>
                    <option value="Paid" {{ old('payment_method') == 'Paid' ? 'selected' : '' }}>Prepaid</option>
                </select>
            </div>
        </div>

    <button class="btn" type="submit" style="margin-top: 40px; width: 95%; margin-inline: auto;">Confirm Order</button>

        </form>
    </div>

</form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.quantity');
        const totalPriceElement = document.getElementById('totalPrice');
        const hiddenTotalPriceInput = document.getElementById('hiddenTotalPrice');

        // Function to format numbers with commas
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Function to update the total price based on quantity and price
        function updateTotalPrice() {
            let totalPrice = 0;
            quantityInputs.forEach(input => {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                totalPrice += price * quantity;
            });
            totalPriceElement.textContent = numberWithCommas(totalPrice) + ' Ks';
            hiddenTotalPriceInput.value = totalPrice;
        }

        // Initialize total price calculation
        updateTotalPrice();
    });
</script>

</body>
</html>

<style>
    .custom-alert {
        position: relative;
        padding: 15px;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        margin: 20px 0;
    }
    
    .custom-alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .custom-alert li {
        list-style: none;
    }
    
    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #721c24;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }
</style>