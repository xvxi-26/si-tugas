<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pendaftaran Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 40px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #666;
        }
        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hai, {{ $mahasiswa->name }}!</h2>
        <p>Terima kasih telah Mendaftar di Sistem Informasi Tugas.</p>
        <p>Jangan lupa untuk melakukan verifikasi pendaftaran dengan mengklik tombol di bawah ini:</p>
        <a href="{{ route('mahasiswa.verify', [$mahasiswa->activate_token]) }}" class="btn">Verifikasi Sekarang</a>
    </div>
</body>
</html>
