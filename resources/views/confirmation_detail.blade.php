<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Detail</title>

    <script>

    </script>

    <link rel="stylesheet" href="{{ asset('css/confirm_detail.css') }}">
</head>
<body>
    {{-- <div class="wrapper option-1 option-1-1">
        <ol class="c-stepper">
          <li class="c-stepper__item">
            <h3 class="c-stepper__title">Step 1</h3>
          </li>
          <li class="c-stepper__item">
            <h3 class="c-stepper__title">Step 2</h3>
          </li>
          <li class="c-stepper__item">
            <h3 class="c-stepper__title">Step 3</h3>
          </li>
        </ol>
    </div> --}}
    <script>
        // if(location.search.includes("www.facebook.com") || location.search.includes("www.messenger.com")){

        //   console.log("Skipp messenger SDK");

        // }else{
          (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/messenger.Extensions.js";
          fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'Messenger'));
        // }

      </script>



<form id="confirmationForm">
    @csrf

    <input type="hidden" name="order_id" value="{{ $order->id }}">

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

        {{-- <button class="btn" type="submit" id="confirmOrderBtn">
            Confirm Order
        </button> --}}
                {{-- @foreach($order->order_detail as $detail)




                        @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach --}}


        {{-- <h2>Branch Information</h2>
        <p>Branch Name: {{ $branch->name }}</p>

        <h2>Shop Information</h2>
        <p>Shop Name: {{ $shop->name }}</p> --}}
    </div>




</form>


<button class="btn" onclick="closeBtn()" >
    Close
</button>


<script src="https://connect.facebook.net/en_US/messenger.Extensions.js"></script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            MessengerExtensions.getSupportedFeatures(function success(result) {
                var features = result.supported_features;
                console.log("Supported features: ", features);
            }, function error(err) {
                console.error("Error: ", err);
            });
        });

    function closeBtn() {

    console.log('close');

    MessengerExtensions.requestCloseBrowser(function success() {
        console.log("Webview closed");
    }, function error(err) {
        console.error("Error closing webview: ", err);
    });
}
    // window.extAsyncInit = function() {
    //     console.log("Messenger SDK has been loaded!!");
    //     console.log(location.search);
    //     var isSupported = MessengerExtensions.isInExtension();
    //     console.log("isSupported", isSupported);
    // };


    // MessengerExtensions.getContext("231577736243430",

    //         function success(result){
    //            console.log("Success")
    //             window.testing = result;
    //             // get the page scope id for the person
    //             psid = result.psid;
    //             if (psid === "") {
    //                 psid = "ERROR, blank from fb";
    //             }
    //             fetchInfo(psid);


    //         },
    //         function error(result){

    //             console.log("error")

    //             console.log(result);
    //             console.log(JSON.stringify(result))
    //             let psidString = location.search.split('sid=')[1]
    //             psidString = psidString.split("&")[0];

    //             var iidString = location.search.split('iid=')[1]
    //             iid = iidString.split("&")[0];


    //             var cidString = location.search.split('cid=')[1]
    //             cid = cidString.split("&")[0];
    //             console.log(window.name)
    //             fetchInfo(psidString);

    //         }
    //     );

    // document.getElementById('confirmOrderBtn').addEventListener('click', function(event) {
    //     event.preventDefault();
    //     submitFormAndCloseWebview();

    //     closeWebview();
    // });

    // function submitFormAndCloseWebview() {
    //     var formData = new FormData(document.getElementById('confirmationForm'));

    //     fetch("{{ route('confirm#order') }}", {
    //         method: 'POST',
    //         body: formData,
    //         headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         }
    //     })
    //     .then(response => {
    //         if (response.ok) {
    //             console.log("Form submitted successfully!");
    //             closeWebview();
    //         } else {
    //             console.error("Error submitting form:", response.statusText);
    //         }
    //     })
    //     .catch(error => {
    //         console.error("Error submitting form:", error);
    //     });
    // }

    // function closeWebview() {
    //     MessengerExtensions.requestCloseBrowser(function success() {
    //         console.log("Webview closed");
    //     }, function error(err) {
    //         console.error("Error closing webview:", err);
    //     });
    // }



</script>




</body>
</html>
