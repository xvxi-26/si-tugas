<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta name="description" content="Admin Bumdesma Ecommerce">
	<meta name="author" content="Ecommerce Bumdesma">
  <meta name="keyword" content="Ecommerce Bumdesma.">

  	<!-- PERHATIKAN BAGIAN INI, APAPUN YANG DIAPIT OLEH ('TITLE') PADA VIEW YANG MENGGUNAKAN MASTER INI, MAKA AKAN ME-REPLACE CODE DIBAWAH -->
  	<!-- TITLE MENJADI KATA KUNCI, JADI JIKA MENGGUNAKAN KEY TITLE PADA , MAKA GUNAKAN KEY TITLE PADA -->
    @yield('title')

  <!-- UNTUK ME-LOAD ASSET DARI PUBLIC, KITA GUNAKAN HELPER ASSET() -->
	<link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/simple-line-icons.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">

    @include('dosen.layout.header')

    <div class="app-body" id="dw">
        <div class="sidebar">


            @include('dosen.layout.sidebar')
        </div>

        @yield('content')

    </div>

    <footer class="apps-footer">
        <div>
            <span>System By <a href="" style="color: black; cursor: text; text-decoration: none;">XVX</a>.</span>
        </div>
        <div class="ml-auto">
            <span>&copy;Powered by</span>
            <a href="https://coreui.io">CoreUI. </a>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/coreui.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-tooltips.min.js') }}"></script>
    @yield('js')
</body>
</html>
