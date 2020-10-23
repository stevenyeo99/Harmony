<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Harmony System</title>
        
        @include('layouts.css')

        <link rel="shortcut icon" href="/img/ico.ico">
    </head>
    <body class="bg-gradient-light">
        @yield('content')

        @include('layouts.js')

        <script>
            $(document).ready(function() {
                bindRemoveDivMessage();
            });

            function bindRemoveDivMessage() {
                $('#alert-message').delay(10000).fadeOut(1000);
            }

            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </body>
</html>