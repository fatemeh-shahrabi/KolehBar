<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ورود | کوله‌بار</title>
    <link rel="icon" href="{{ asset('images/kolehbar-favicon.png') }}" type="image/png">
    <link href="{{ asset('fonts/Vazirmatn-Regular.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>
    <link href="{{ asset('fonts/DanaFaNum-DemiBold.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @font-face {
            font-family: 'Vazirmatn';
            font-weight: 400;
            font-style: normal;
            src: url('/fonts/Vazirmatn-Regular.woff2') format('woff2');
        }
        @font-face {
            font-family: 'dana';
            font-weight: 400;
            font-style: normal;
            src: url('/fonts/DanaFaNum-DemiBold.woff2') format('woff2');
        }

        body {
            font-family: 'dana', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center rtl">

    {{ $slot }}

</body>
</html>
