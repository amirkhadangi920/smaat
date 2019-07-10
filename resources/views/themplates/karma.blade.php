<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">
        <link rel="stylesheet" href="/css/app.css">

        <!-- Styles -->
        <link rel="stylesheet" href="/themplates/karma/css/linearicons.css">
        <link rel="stylesheet" href="/themplates/karma/css/font-awesome.min.css">
        <link rel="stylesheet" href="/themplates/karma/css/themify-icons.css">
        <link rel="stylesheet" href="/themplates/karma/css/bootstrap.css">
        <link rel="stylesheet" href="/themplates/karma/css/owl.carousel.css">
        <link rel="stylesheet" href="/themplates/karma/css/nice-select.css">
        <link rel="stylesheet" href="/themplates/karma/css/nouislider.min.css">
        <link rel="stylesheet" href="/themplates/karma/css/ion.rangeSlider.css" />
        <link rel="stylesheet" href="/themplates/karma/css/ion.rangeSlider.skinFlat.css" />
        <link rel="stylesheet" href="/themplates/karma/css/magnific-popup.css">
        <link rel="stylesheet" href="/themplates/karma/css/main.css">
        <link rel="stylesheet" href="/themplates/karma/css/flipclock.css">
        <link rel="stylesheet" href="/themplates/karma/css/flaticon.css">

    </head>

    <body>
        
        <div id="app" class="flex-center position-ref full-height">

            <App></App>
        
        </div>

        <!-- Scripts -->
        <script src="/themplates/karma/js/app.js"></script>
        <!-- Karma -->
        <script src="/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
        </script>
        <script src="/themplates/karma/js/vendor/bootstrap.min.js"></script>
        <script src="/themplates/karma/js/jquery.ajaxchimp.min.js"></script>
        <script src="/themplates/karma/js/jquery.nice-select.min.js"></script>
        <script src="/themplates/karma/js/jquery.sticky.js"></script>
        <script src="/themplates/karma/js/nouislider.min.js"></script>
        <script src="/themplates/karma/js/jquery.magnific-popup.min.js"></script>
        <script src="/themplates/karma/js/owl.carousel.min.js"></script>
        <!--gmaps Js-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
        <script src="/themplates/karma/js/gmaps.min.js"></script>
        <script src="/themplates/karma/js/main.js"></script>
        <script src="/themplates/karma/js/flipclock.js"></script>
        <!-- Tilt -->
        <script src="https://unpkg.com/tilt.js@1.2.1/dest/tilt.jquery.min.js"></script>
    </body>

</html>
