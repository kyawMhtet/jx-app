<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/order_form.css') }}">
</head>
<body>

<div class="container">
    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif --}}

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
            <span>
                {{ $currentDate }}
            </span>
        </div>

    </div>


    {{-- @csrf --}}
    <table>
        <tr>
            <th>#</th>
          <th>Record</th>
          <th>Quantity</th>
          <th>Price</th>
        </tr>
        <tr>
            <td>1</td>
          <td>{{ $item->sub_item_name }}</td>
          <td>1</td>
          <td>{{ $item->price }} Ks</td>
        </tr>
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
            <td>Tax</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <b>Total</b>
            </td>
            <td></td>
            <td colspan="2">
                <b>
                    {{ 1*$item->price }} Ks
                </b>
            </td>
        </tr>
    </table>

    {{-- <input type="hidden" name="item_name" value="{{ $item->item_name }}" id="hidden-item-name"> --}}
    <input type="hidden" name="item_count" value="1">
    <input type="hidden" name="item_price" value="{{ $item->price }}">
    <input type="hidden" name="total_price" value="{{ 1*$item->price }}">
    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
    <input type="hidden" name="channel_customer_id" value="{{ $customer->channel_customer_id }}">
    <input type="hidden" name="branch_id" value="{{ $item->branch_id }}">
    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
    <input type="hidden" name="item_id" value="{{ $item->id }}">


    <div>
        {{-- <label for="" class="label">Transfer Time</label>
        <div class="forms">

            <div class="date">
                <input type="date" value="2023-04-22">
            </div>

            <div class="time">
                <input type="time">
            </div>
        </div> --}}


        {{-- <div class="amount">
            <label for="">Amount </label>
            <div class="">
                <input type="text">
            </div>
        </div> --}}

        <div class="amount">
            <label for="" class="@error('name')
                    name-label-invalid
                @enderror"">Name </label>
            <div class="">
                <input type="text" name="name" class="@error('name')
                    name-invalid
                @enderror">
                {{-- @error('name')
                <small class="invalid-feedback">
                    {{ $message }}
                </small>
            @enderror --}}
            </div>
        </div>

        <div class="amount">
            <label for="" class="@error('phone')
                phone-label-invalid
            @enderror" >Phone</label>
            <div class="">
                <input type="text" name="phone" class="@error('phone')
                    phone-invalid
                @enderror">

            </div>
        </div>

        <div class="amount">
            <label for="" class="@error('address')
                address-label-invalid
            @enderror">Address</label>
            <div class="">
                <textarea name="address" id="" cols="" rows="3" class="@error('address')
                    address-invalid
                @enderror"></textarea>
            </div>
        </div>

        <div class="amount">
            <label for="">Note (optional) </label>
            <div class="">
                <textarea name="note" id="" cols="" rows="2"></textarea>
            </div>
        </div>


        <div class="amount">
            <div class="selectdiv">
                <label>
                    <select name="payment">
                        <option value="COD"> Cash On Delivery </option>
                        <option value="kpay">KPay</option>
                        <option value="Paid">Prepaid</option>
                    </select>
                </label>
              </div>
        </div>




        <div class="checkbox">
            <label><input type="checkbox" name="customer_info"/>
            <span>
                လက်ရှိဖုန်းနံပါတ်နှင့် လိပ်စာကိုနောက်ထပ် order များအတွက်သိမ်းထားမည်။
            </span>
            </label>
        </div>


    </div>



    <div class="buttons">
        <button class="btn1" id="continueShopping" type="button">
            Continue Shopping
        </button>

        <button class="btn2" id="checkOut" type="submit">
            Check Out
        </button>
    </div>

</form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderForm = document.getElementById('orderForm');
        const continueShoppingButton = document.getElementById('continueShopping');
        const checkOutButton = document.getElementById('checkOut');

        checkOutButton.addEventListener('click', function (e) {
            orderForm.action = "{{ route('user#checkout') }}";
        });

        continueShoppingButton.addEventListener('click', function() {
            window.location.href = 'fb://page/102089854919616';

            setTimeout(() => {
                window.location.href = 'https://www.facebook.com/twoofficialpage/'
            }, 1000);
        });
    });



    function removeErrorClass(event) {
        event.target.classList.remove('name-invalid', 'phone-invalid', 'address-invalid');
        const label = event.target.closest('.amount').querySelector('label');
        label.classList.remove('name-label-invalid', 'phone-label-invalid', 'address-label-invalid');
    }

    // Add event listeners to inputs
    const nameInput = document.querySelector('input[name="name"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const addressInput = document.querySelector('textarea[name="address"]');

    nameInput.addEventListener('input', removeErrorClass);
    phoneInput.addEventListener('input', removeErrorClass);
    addressInput.addEventListener('input', removeErrorClass);

</script>


</body>
</html>
