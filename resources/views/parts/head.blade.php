<meta charset="UTF-8">
<link rel="manifest" href="/manifest.json">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="#000000">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="application-name" content="CityLayers">
<link rel="icon" sizes="96x96" href="/images/favicon.ico">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="CityLayers">
<link rel="apple-touch-icon" href="/images/favicon.ico">

<link href="/images/icons/splash-640x1136.png"
    media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-750x1334.png"
    media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1242x2208.png"
    media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1125x2436.png"
    media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-828x1792.png"
    media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1242x2688.png"
    media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1536x2048.png"
    media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1668x2224.png"
    media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1668x2388.png"
    media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="/images/icons/splash-2048x2732.png"
    media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<!-- Primary Meta Tags -->
<meta name="title" content="CityLayers">
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="shortcut icon" href="/images/icons/icon-96x96.png" type="image/x-icon" />
<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="">
<meta property="og:title" content="CityLayers">
<meta property="og:description" content="">
<meta property="og:image" content="/images/icons/icon-96x96.png">
<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="#">
<meta property="twitter:title" content="CityLayers">
<meta property="twitter:description" content="">
<meta property="twitter:image" content="/images/icons/icon-96x96.png">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script src="https://kit.fontawesome.com/59ecaaffaa.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<link rel="stylesheet"
    href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"
    integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s=" crossorigin=""></script>
<title>CityLayers</title>
@vite('resources/css/app.css')
@vite('resources/js/map.js')
@vite('resources/js/citymap.js')
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<script>
    myToken = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
</script>
@laravelPWA
<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function(registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>
