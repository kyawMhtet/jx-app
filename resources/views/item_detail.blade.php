<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Item Detail</title>

    <!-- <link rel="stylesheet" href=> -->
    <link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
</head>

<body>



    <div class="order-msg">
        <div class="cover_img">
            {{-- page --}}
            <img src="https://scontent.fbkk12-2.fna.fbcdn.net/v/t39.30808-6/305968996_459689412855970_3798582763285597954_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=5f2048&_nc_ohc=Qj8PjST33IUQ7kNvgHiOl-z&_nc_ht=scontent.fbkk12-2.fna&oh=00_AYDUfKF_xB7XHxCzSF6aSOQcL5rcrdlUgqUGPnXto9TsLQ&oe=665F7779" class="" alt="">

            <h3>{{ $item->item_name }}</h3>
        </div>
        
        {{-- order title --}}
        <div class="order-title">
            <h4>Order </h4>
            <small>#62175</small>
        </div>

        <div class="detail">
            <p>Price</p>
            <small>5000 Ks</small>
        </div>

        <hr>

        <small class="">
            {{ $item->description }}
        </small>

    </div>

    {{-- order image --}}
    @if ($item->image_url)
    <div class="photos">
        <div>
            <img src="{{ $item->image_url }}" alt="">
        </div>
    </div>
    @endif
</body>

</html>