<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
              integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        @stack('styles')
        <title>@yield('title')</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-info mb-3">
            <div class="container">
                <a class="navbar-brand" href="{{ route('products.index') }}">Products</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container">
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $(function () {
                $('.alert-success').fadeOut(5000);
            });
        </script>
        @stack('scripts')
    </body>
</html>
