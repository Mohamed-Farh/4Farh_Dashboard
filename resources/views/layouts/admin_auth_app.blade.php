<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.backend.head')

    @yield('style')

</head>

<body class="bg-gradient-primary" id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            @include('layouts.backend.sidebar')
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    @include('layouts.backend.topbar')
                    <!-- End of Topbar -->

                    @include('layouts.backend.flash')

                    @yield('content')
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                @include('layouts.backend.footer')
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        @include('layouts.backend.footer_script')


    @yield('script')

</body>

</html>
