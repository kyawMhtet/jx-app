<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Detail</title>

    <script src="https://connect.facebook.net/en_US/messenger.Extensions.js"></script>


    <link rel="stylesheet" href="{{ asset('css/confirm_detail.css') }}">
</head>
<body>


<form id="confirmationForm">
    @csrf

    <input type="hidden" name="oid" value="{{ $order->id }}">

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

        <hr>

        <div class="payment">
            <h4>Payment Info</h4>
            <div>
                <p>Status</p>

                <small>{{ $order->status }}.</small>
            </div>
        </div>


        <hr>
        <div class="payment">
          <div>
              <p>Updated at</p>

              <small>29 April 2024, 15:57</small>
          </div>
      </div>
      </div>

    <div class="lists">
        {{-- <h4>Order Item List</h4> --}}
        @foreach ($subItems as $subitem)
        <div class="item-list">
            <img src="{{ $subitem->image_url }}" alt="">

            <div class="">
                <p class="name">
                    {{ $subitem->sub_item_name }}
                </p>

                <div class="item-amount">
                        <p>
                            {{ $subitem->price }} Ks
                        </p>

                        <span>
                            Qty: 1
                        </span>


                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button class="btn" type="submit" onclick="closeBtn(e)" >
        Confirm Order
    </button>
</form>






<script>
    document.addEventListener('DOMContentLoaded', function () {
        MessengerExtensions.getSupportedFeatures(function success(result) {
            var features = result.supported_features;
            console.log("Supported features: ", features);
        }, function error(err) {
            console.error("Error: ", err);
        });
    });

    function closeBtn(e) {
        e.preventDefault();
        const form = document.getElementById('confirmationForm');

        form.addEventListener('submit', function() {
            MessengerExtensions.requestCloseBrowser(function success() {
                console.log("Webview closed");
            }, function error(err) {
                console.error("Error closing webview: ", err);
            });
        });

        form.submit();
    }

</script>




</body>
</html>
