<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('favicon_360.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('splash-screen.css') }}">

    <script src="https://cdn.tiny.cloud/1/glvdbar1akcht9rtd7mkcjkhpeny4rvvu8a2b3dyfew1n47h/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <!-- Styles -->

    @vite('resources/js/main.ts')
</head>

<body class="antialiased">
    <script>
        let themeMode = "system";

        if (localStorage.getItem("kt_theme_mode_value")) {
            themeMode = localStorage.getItem("kt_theme_mode_value");
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>
    <!--end::Theme mode setup on page load-->

    <div id="app"></div>

    <!--begin::Loading markup-->
    <div id="splash-screen" class="splash-screen">
        <img src="{{ asset('media/logos/default-dark.svg') }}" class="dark-logo" alt="Metronic dark logo" />
        <img src="{{ asset('media/logos/default.svg') }}" class="light-logo" alt="Metronic light logo" />
        <span>Loading ...</span>
    </div>
    <!--end::Loading markup-->
    <script src="{{ asset('service-worker.js') }}"></script>
    {{-- <script  src="{{asset('firebase-messaging-sw.js')}}"></script> --}}

    {{-- <script type="module" src="../js/main.ts"></script> --}}
</body>

</html>
