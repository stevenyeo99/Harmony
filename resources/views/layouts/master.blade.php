<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Harmony System</title>
        <!-- css resources -->
        @include('layouts.css')
        <!-- end css -->

        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>

    <body id="page-top">
        <div id="wrapper">
            <!-- sidebar resources -->
            @include('layouts.sidebar')
            <!-- end sidebar -->

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <!-- header resources -->
                    @include('layouts.header')
                    <!-- end header -->

                    <!-- content resources -->
                    <div class="container-fluid">
                        @include('layouts.validationmsg')
                        @yield('content')
                    </div>
                    <!-- end content -->
                </div>

                <!-- footer resources -->
                @include('layouts.footer')
                <!-- end footer -->
            </div>
        </div>

        <!-- Scroll to Top Button -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- end scroll to top -->

        @include('layouts.modal')

        <!-- js resources -->
        @include('layouts.js')
        <!-- end js -->
    </body>
</html>