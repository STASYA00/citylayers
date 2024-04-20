<!DOCTYPE html>
<html lang="fr">

<head>
    @include('parts.head')
    @livewireStyles
    <link rel='stylesheet' href="https://unpkg.com/swiper@6.8.4/swiper-bundle.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="body overflow-x-hidden bg-white pattern">

    <main>
        @yield('main')
    </main>

    @vite('resources/js/app.js')
    @vite('resources/js/map.js')
    @vite('resources/js/citymap.js')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    @livewireScripts
    @stack('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
</body>

</html>
