<!DOCTYPE html>
<html>

<head>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background-color: #f0f0f0;
            position: relative;
        }

        .qr-code {
            width: 600px;
            height: 600px;
            border: 1px solid #ccc;
            box-shadow: 0px 5px 11px 5px rgb(38 38 38 / 18%);
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            overflow: hidden;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

    </style>
</head>

<body>
    <?php
    $datas = url('/home') . '/' . $uuid;
    ?>
    <div class="qr-code">
        {!! DNS2D::getBarcodeHTML($datas, 'QRCODE', 19, 19, 'black', true) !!}
    </div>
</body>

</html>