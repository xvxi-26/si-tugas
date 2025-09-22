@extends('layouts.admin')

@section('title')
    <title>Detail Tugas</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Detail Tugas</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $tugas->judul }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $tugas->deskripsi }}</p>
                            <p><strong>Kelas:</strong> {{ $tugas->kelas->kelas }}</p>
                            <p><strong>Deadline:</strong> {{ $tugas->deadline->format('d M Y, H:i') }}</p>
                            <p><strong>Interval Pengingat:</strong> {{ $tugas->pengingat_interval }} Menit</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="mt-4">File Tugas</h4>
                    <ul class="list-group mb-4">
                        @foreach($tugas->files as $file)
                            <li class="list-group-item">
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">Lihat File</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4 class="mt-4">Jawaban Mahasiswa</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>File Jawaban</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tugas->tugasJawaban as $jawaban)
                                    <tr>
                                        <td>{{ $jawaban->mahasiswa->nama }}</td>
                                        <td>
                                            <a href="{{ Storage::url($jawaban->file_path) }}" target="_blank">Lihat Jawaban</a>
                                        </td>
                                        <td>
                                            {{ $jawaban->nilai ? $jawaban->nilai->nilai : 'Belum Dinilai' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('tugas.beriNilai', $jawaban->id) }}" method="POST">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="number" name="nilai" class="form-control" min="0" max="100" required>
                                                    <button type="submit" class="btn btn-primary">Beri Nilai</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 p-1">
                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
