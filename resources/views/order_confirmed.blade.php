<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        if(location.search.includes("www.facebook.com") || location.search.includes("www.messenger.com")){

          console.log("Skipp messenger SDK");

        }else{
          (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/messenger.Extensions.js";
          fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'Messenger'));
        }
      </script>


    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        div {
            text-align: center;
        }

        i {
            background-color: green;
            padding: 8px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            color: white;
            font-size: 24px;
        }

        h3 {
            margin-top: 10px;
        }

        .btn {
            padding: 5px 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>

</head>
<body>
    <div>
        <i class="fa-solid fa-check"></i>
        <h3>Order confirmed!</h3>
        <p>Thank you for your purchase.</p>

        <button class="btn" onclick="closeBtn()">Close</button>
    </div>

    <script>
        // setTimeout(() => {
        //     window.open('', '_self').close();
        //     window.location.href = 'about:blank';
        // }, 3000);
        document.addEventListener('DOMContentLoaded', function () {
        MessengerExtensions.getSupportedFeatures(function success(result) {
            var features = result.supported_features;
            console.log("Supported features: ", features);
        }, function error(err) {
            console.error("Error: ", err);
        });
    });

    function closeBtn() {
            MessengerExtensions.requestCloseBrowser(function success() {
                // alert('webview closed');
                console.log("Webview closed");
            }, function error(err) {
                // alert(err);
                console.error("Error closing webview: ", err);
            });
    }

    </script>
</body>
</html>
