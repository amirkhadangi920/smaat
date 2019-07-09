<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <script>
        if ( !localStorage.getItem('JWT') )
            window.location.replace('/login')
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css"> --}}
        {{-- <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet"> --}}
        {{-- <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons"> --}}
        <link href="/css/font.css" rel="stylesheet" type="text/css">

        {{-- <link href="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.css" rel="stylesheet" type="text/css">
        <script src="https://static.neshan.org/sdk/leaflet/1.4.0/leaflet.js" type="text/javascript"></script> --}}
        
        <!-- Styles -->
        <style>
            body {
                background: #f5f6fa !important;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>

        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
