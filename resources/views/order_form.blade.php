<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Form</title>
    <link rel="stylesheet" href="{{ asset('css/order_form.css') }}">
</head>
<body>

<div class="container">
    <form id="orderForm" action="{{ route('user#checkout') }}" method="POST">
        @csrf
        <div class="detail">
            <div>
                <h4>Order</h4>
                <small>#62175</small>
            </div>

            <div>
                <h5>Facebook Name : </h5>
                <span> {{ $customer->customer_name }} </span>
            </div>

            <div>
                <h5>Timestamp : </h5>
                <span>{{ $currentDate }}</span>
            </div>
        </div>

        <table>
            <tr>
                <th>#</th>
                <th>Record</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>

            @foreach ($order_details as $index => $order_detail)
                @php
                    $item = $items->firstWhere('id', $order_detail['item_id']);
                @endphp

                @if ($item)
                    <tr>
                        <td>{{ $index + 1 }}.</td>
                        <td>{{ $item->sub_item_name }}</td>
                        <td class="" style="text-align: center;">
                            {{ $order_detail['quantity'] }}
                            <input type="hidden" name="quantity[]" value="{{ $order_detail['quantity'] }}" min="1" class="quantity" data-price="{{ $item->price }}">
                        </td>
                        <td >{{ $item->price }} Ks</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td></td>
                <td>Discount</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Delivery Fee</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><b>Total</b></td>
                <td id="totalPrice"><b>0 Ks</b></td>
            </tr>
        </table>

        <input type="hidden" name="total_price" id="hiddenTotalPrice" value="0">
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <input type="hidden" name="channel_customer_id" value="{{ $customer->channel_customer_id }}">
        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
        <input type="hidden" name="oid" value="{{ $order->id }}">

        <div class="amount">
            <label for="" class="@error('name') name-label-invalid @enderror">Name</label>
            <div class="">
                <input type="text" name="name" value="{{ old('name', optional($previousOrder)->name ?? '') }}" class="@error('name') name-invalid @enderror">
            </div>
        </div>

        <div class="amount">
            <label for="" class="@error('phone') phone-label-invalid @enderror">Phone</label>
            <div class="">
                <input type="text" name="phone" value="{{ old('phone', optional($previousOrder)->phone ?? '') }}" class="@error('phone') phone-invalid @enderror">
            </div>
        </div>

        <div class="amount">
            <label for="" class="@error('address') address-label-invalid @enderror">Address</label>
            <div class="">
                <textarea name="address" cols="" rows="3" class="@error('address') address-invalid @enderror">{{ old('address', optional($previousOrder)->address ?? '') }}</textarea>
            </div>
        </div>

        <div class="amount">
            <label for="">Note (optional)</label>
            <div class="">
                <textarea name="note" cols="" rows="2">{{ old('note', optional($previousOrder)->note ?? '') }}</textarea>
            </div>
        </div>

        <div class="amount">
            <div class="selectdiv">
                <label>
                    <select name="payment">
                        <option value="COD" {{ (old('payment_method', optional($previousOrder)->payment_method ?? '') == 'COD') ? 'selected' : '' }}>Cash On Delivery</option>
                        <option value="kpay" {{ (old('payment_method', optional($previousOrder)->payment_method ?? '') == 'kpay') ? 'selected' : '' }}>KPay</option>
                        <option value="Paid" {{ (old('payment_method', optional($previousOrder)->payment_method ?? '') == 'Paid') ? 'selected' : '' }}>Prepaid</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="customer_info"/>
                <span>လက်ရှိဖုန်းနံပါတ်နှင့် လိပ်စာကိုနောက်ထပ် order များအတွက်သိမ်းထားမည်။</span>
            </label>
        </div>

        <div class="buttons">
            <button class="btn1" id="continueShopping" type="button">Continue Shopping</button>
            <button class="btn2" id="checkOut" type="submit">Check Out</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderForm = document.getElementById('orderForm');
        const continueShoppingButton = document.getElementById('continueShopping');
        const checkOutButton = document.getElementById('checkOut');
        const quantityInputs = document.querySelectorAll('.quantity');
        const totalPriceElement = document.getElementById('totalPrice');
        const hiddenTotalPriceInput = document.getElementById('hiddenTotalPrice');

        function updateTotalPrice() {
            let totalPrice = 0;
            quantityInputs.forEach(input => {
                const price = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value);
                totalPrice += price * quantity;
            });
            totalPriceElement.textContent = totalPrice + ' Ks';
            hiddenTotalPriceInput.value = totalPrice;
        }

        quantityInputs.forEach(input => {
            input.addEventListener('input', updateTotalPrice);
        });

        checkOutButton.addEventListener('click', function () {
            orderForm.action = "{{ route('user#checkout') }}";
        });

        continueShoppingButton.addEventListener('click', function() {
            window.location.href = 'fb://page/102089854919616';
            setTimeout(() => {
                window.location.href = 'https://www.facebook.com/twoofficialpage/';
            }, 1000);
        });

        // Initial total price calculation
        updateTotalPrice();
    });

    function removeErrorClass(event) {
        event.target.classList.remove('name-invalid', 'phone-invalid', 'address-invalid');
        const label = event.target.closest('.amount').querySelector('label');
        label.classList.remove('name-label-invalid', 'phone-label-invalid', 'address-label-invalid');
    }

    const nameInput = document.querySelector('input[name="name"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const addressInput = document.querySelector('textarea[name="address"]');

    nameInput.addEventListener('input', removeErrorClass);
    phoneInput.addEventListener('input', removeErrorClass);
    addressInput.addEventListener('input', removeErrorClass);
</script>

</body>
</html>
