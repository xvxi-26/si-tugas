<!DOCTYPE html>
<html>
<head>
    <title>Pengingat Tugas</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px; text-align: center;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin: auto;">
        <h2 style="color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px;">Pengingat Tugas</h2>

        <p style="font-size: 16px; color: #333;">Halo, <strong>{{ $namaMahasiswa }}</strong></p>
        <p style="font-size: 14px; color: #555;">
            Ini adalah pengingat bahwa tugas <strong>{{ $judulTugas }}</strong> akan segera jatuh tempo.
        </p>

        <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin: 15px 0;">
            <p style="margin: 5px 0;"><strong>🗓 Deadline:</strong> {{ $deadline }}</p>
            <p style="margin: 5px 0;"><strong>📝 Deskripsi:</strong> {{ $deskripsi }}</p>
        </div>

        <a style="color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px font-size: 20px;" href="http://127.0.0.1:8000/Mahasiswa/login">Dashboard</a>

        <p style="margin-top: 20px; font-size: 12px; color: #999;">Terima kasih.</p>
    </div>
</body>
</html>
