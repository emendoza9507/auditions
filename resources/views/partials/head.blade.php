<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="https://jhartsfoundation.org/wp-content/uploads/2024/05/cropped-New-JHAF-Logo-black-32x32.png" sizes="32x32">
<link rel="icon" href="https://jhartsfoundation.org/wp-content/uploads/2024/05/cropped-New-JHAF-Logo-black-192x192.png" sizes="192x192">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<script src="https://www.paypal.com/sdk/js?client-id={{config('app.paypal_client_id')}}"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
