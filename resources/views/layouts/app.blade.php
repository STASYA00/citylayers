<!DOCTYPE html>
<html lang="fr">

<head>
    @include('parts.head')
    @livewireStyles
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel='stylesheet' href="https://unpkg.com/swiper@6.8.4/swiper-bundle.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script src="lib/browser/neo4j-web.min.js"></script>

    <!-- unpkg CDN non-minified -->
    <script src="https://unpkg.com/neo4j-driver"></script>
    <!-- unpkg CDN minified for production use, version X.Y.Z -->
    <script src="https://unpkg.com/neo4j-driver@X.Y.Z/lib/browser/neo4j-web.min.js"></script>

    <!-- jsDelivr CDN non-minified -->
    <script src="https://cdn.jsdelivr.net/npm/neo4j-driver"></script>
    <!-- jsDelivr CDN minified for production use, version X.Y.Z -->
    <script src="https://cdn.jsdelivr.net/npm/neo4j-driver@X.Y.Z/lib/browser/neo4j-web.min.js"></script>
    
    <!-- <link rel="stylesheet" href="css/app.css" type="text/css"> -->
    @vite('resources/css/app.css')
</head>

<body class="body overflow-x-hidden bg-white pattern">

    <main>
        @yield('main')
    </main>

    @vite('resources/js/app.js')
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @livewireScripts
    @stack('scripts')
    <script>
        <?php require_once("js/classnames.js");?>    
        <?php require_once("js/ui/component/celement.js");?>
        <?php require_once("js/ui/component/textelement.js");?>
        <?php require_once("js/ui/component/linkelement.js");?>
        <?php require_once("js/ui/component/contentElement.js");?>
        <?php require_once("js/ui/component/imageElement.js");?>
        <?php require_once("js/ui/component/switch.js");?>
        <?php require_once("js/logic/illustration.js");?>
        <?php require_once("js/ui/panel/contentPanel.js");?>
        <?php require_once("js/ui/panelcomponent/social.js");?>
        <?php require_once("js/ui/panelcomponent/legal.js");?>
    </script>

    <style>
        ::-webkit-scrollbar {
            width: 0;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 0px rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background-color: transparent;
            outline: 1px solid transparent;
        }
    </style>
    {{-- <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',

            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        })

        Livewire.on('success', message => {
            Toast.fire({
                icon: 'success',
                title: message
            })
        })
    </script> --}}
        @include('parts.footer')
</body>

</html>
