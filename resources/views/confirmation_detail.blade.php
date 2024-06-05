<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation Detail</title>

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

      <div class="info">
        <h3>Confirmation Detail</h3>

        <hr>

        <div>
            <h4>Seller Info</h4>
            <div class="seller_info">
                <img src="https://scontent.fbkk8-2.fna.fbcdn.net/v/t39.30808-6/302693478_390123153276794_3073543938523926457_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=5f2048&_nc_ohc=CHV9CMIAF6QQ7kNvgGskeD_&_nc_ht=scontent.fbkk8-2.fna&oh=00_AYAHJ6cRu8h379X9MIbn9CU_RcjqhN7dr3UvgATdoZULSg&oe=665F37AE" alt="">

                <h4>{{ $branch->branch_name }}</h4>
            </div>
        </div>

        <hr>

        <div class="payment">
            <h4>Payment Info</h4>
            <div>
                <p>Status</p>

                <small>You've confirmed that you'll pay by {{ $detail->payment_method }}.</small>
            </div>
        </div>
      </div>

      <hr>
      <div class="payment">
        <div>
            <p>Updated at</p>

            <small>29 April 2024, 15:57</small>
        </div>
    </div>

    <hr>
    <div class="payment">
        <h4>Order Item List</h4>

    </div>



  </div>


</body>
</html>