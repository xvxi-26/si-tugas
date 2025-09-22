<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-Tugas | Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 15px;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }
        .icon-btn {
            font-size: 2rem;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .center-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh; /* Supaya selalu di tengah */
        }
        .role-card {
         max-width: 90%; /* Agar tidak terlalu melebar */
        width: 400px; /* Ukuran tetap untuk tampilan rapi */
        padding: 20px;
        text-align: center;
        }
        .icon-btn:hover {
            transform: scale(1.1);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .role-container {
            flex: 1;
            min-width: 100px;
            text-align: center;
        }
        @media (max-width: 576px) {
            .card {
                width: 90% !important;
            }
            .role-group {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card text-dark w-100">
                <p class="mb-0">Selamat Datang Di</p>
                <h1 class="mb-3">Sistem Informasi Tugas</h1>

                <div class="d-flex justify-content-center role-group gap-4 flex-wrap mt-3">
                    <div class="role-container d-flex flex-column align-items-center">
                        <a href="{{ route('mahasiswa.login') }}" class="icon-btn bg-primary d-flex flex-column align-items-center">
                            <i class="bi bi-mortarboard"></i>
                        </a>
                        <span class="mt-2 text-center">Mahasiswa</span>
                    </div>
                    <div class="role-container d-flex flex-column align-items-center">
                        <a href="{{ route('dosen.login') }}" class="icon-btn bg-success d-flex flex-column align-items-center">
                            <i class="bi bi-person-badge"></i>
                        </a>
                        <span class="mt-2 text-center">Dosen</span>
                    </div>
                    <div class="role-container d-flex flex-column align-items-center">
                        <a href="{{ route('admin.login') }}" class="icon-btn bg-danger d-flex flex-column align-items-center">
                            <i class="bi bi-shield-lock"></i>
                        </a>
                        <span class="mt-2 text-center">Admin</span>
                    </div>
                </div>

                <footer class="mt-3">
                    <p class="text-muted small">&copy; 2025 <a href="" class="text-muted" style="text-decoration: none; cursor: text">XVX</a> - Sistem Informasi Tugas. All Right Reserved</p>
                </footer>
            </div>
        </div>
    </div>
</div>

</body>
</html>
