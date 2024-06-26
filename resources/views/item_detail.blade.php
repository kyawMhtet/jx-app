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
            <img src="" class="" alt="">
            <h3 id="page_name">
                {{ $shop->name }}
            </h3>
        </div>

        {{-- order title --}}
        <div class="order-title">
            <h4>Order </h4>
            <small>#62175</small>
        </div>

        <div class="detail">
            <p>Price</p>
            <small>
                {{ $item->price }} Ks
            </small>
        </div>

        <hr>

        <small class="description">
            {{ $item_desc->description }}
        </small>

    </div>


    {{-- @if ($item && property_exists($item, 'image_url') && isset($item->image_url)) --}}
    <div class="photos">
        <div>
            <img src="{{ $item->image_url }}" alt="">
        </div>
    </div>
{{-- @endif --}}






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        // $(document).ready(() => {

        //     async function fetchInfo() {
        //         try {
        //             const res = await $.get('http://127.0.0.1:8001/api/items/2');
        //             let item_name = res.item.item_name;
        //             let desc = res.item.description;
        //             let image_url = res.item.image_url.split('storage/item_images/')[1];


        //             $('#page_name').html(item_name);
        //             $('.description').html(desc);
        //             $('#item_img').attr('src', image_url);

        //         } catch (e) {
        //             console.log(e);
        //         }
        //     }

        //     fetchInfo();
        // })

        // document.addEventListener('DOMContentLoaded', async () => {
        //     try {
        //         const response = await fetch('https://api.megajx.com/api/orders/2', {
        //             method: "GET",
        //             headers: {
        //                 "Content-type" : "application/json; charset=UTF-8"
        //             }
        //         });
        //         const data = await response.json();
        //         const item_name = data.item.item_name;
        //         const desc = data.item.description;
        //         const image_url = data.item.image_url.split('storage/item_images/')[1];

        //         document.getElementById('page_name').textContent = item_name;
        //         document.querySelector('.description').textContent = desc;
        //         document.getElementById('item_img').setAttribute('src', image_url);
        //     } catch (el) {
        //         console.error(e.message);
        //     }
        // });


    </script>
</body>

</html>
