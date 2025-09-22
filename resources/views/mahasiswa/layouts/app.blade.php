<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SI - TUGAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar shadow-sm navbar-expand-lg bg-light">
        <div class="container-fluid">
          {{-- <a class="navbar-brand ms-2" style="width: 280px;" href="#">Dashboard</a> --}}
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>

          </div>
        </div>
      </nav>
    <div class="d-flex sidebar flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 100vh; position: fixed; top:0;">
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <h5 class="mb-4 text-center">Dashboard</h5>
          </li>
          <li class="nav-item">
            <a href="/Mahasiswa/home" class="{{Request::is('Mahasiswa/home') ? 'active text-white' : ''}} nav-link link-dark " aria-current="page">
                <i class="bi bi-archive-fill" style="font-size: 1.2rem;"></i>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a href="{{Route('kelasmahasiswa.index')}}" class="{{Request::is('Mahasiswa/kelasmahasiswa') ? 'active text-white' : ''}} nav-link link-dark">
                <i class="bi bi-building-fill-add" style="font-size: 1.2rem;"></i>
              Kelas
            </a>
          </li>
          <a class="p-1" href="/logout-mahasiswa">
            <button type="button" class="btn btn-dark">Logout</button>
          </a>
        </ul>
      </div>
      <div class="content">
        <div class="container">
            @yield('content')
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js" integrity="sha512-LUKzDoJKOLqnxGWWIBM4lzRBlxcva2ZTztO8bTcWPmDSpkErWx0bSP4pdsjNH8kiHAUPaT06UXcb+vOEZH+HpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  @stack('script')
  <script>
    document.querySelector('.navbar-toggler').addEventListener('click',function(){
      document.querySelector('.sidebar').classList.toggle('open-navbar')
    })
  </script>
</body>
</html>
