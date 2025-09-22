@extends('mahasiswa.layouts.app')
<title>Detail Jawaban</title>
@section('content')
<div class="container">
    <h2 class="mb-4">Jawaban Anda</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $tugas->judul }}</h4>
            <p><strong>Deskripsi:</strong> {{ $tugas->deskripsi }}</p>
            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}</p>

            <h5 class="mt-4">Jawaban Anda:</h5>
            <p>Status:
                <span class="badge {{ $jawaban->status == 'Sudah Dinilai' ? 'bg-success' : 'bg-warning' }}">
                    {{ $jawaban->status }}
                </span>
            </p>

            <a href="{{ asset('storage/' . $jawaban->file_path) }}" class="btn btn-primary" target="_blank">Lihat Jawaban</a>
            @if ($jawaban->status != 'Sudah Dinilai')
                <a href="{{ route('mahasiswatugas.destroy', $tugas->id) }}" class="btn btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus jawaban ini?');">
                        Hapus Jawaban
                </a>
            @endif
            @if ($jawaban->status == 'Sudah Dinilai' && $jawaban->nilai)
                <h5 class="mt-4">Nilai:</h5>
                <p class="display-4 text-primary">{{ $jawaban->nilai->nilai }}</p>
            @endif

            <a href="{{ route('kelasmahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
