@extends('mahasiswa.layouts.app')

@section('title')
    <title>Daftar Tugas</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Daftar Tugas</li>
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
                            <h4 class="card-title">Daftar Tugas</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th>File Soal</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tugasList as $tugas)
                                        <tr>
                                            <td>{{ $tugas->judul }}</td>
                                            <td>{{ Str::limit($tugas->deskripsi, 50) }}</td>
                                            @if($tugas->files->isNotEmpty())
                                            @foreach($tugas->files as $file)
                                            <td>
                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">Lihat File</a>
                                            </td>
                                            @endforeach
                                            @else
                                            <td>Tidak ada file untuk tugas ini.</td>
                                            @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($tugas->tugasJawaban->where('mahasiswa_id', auth()->guard('mahasiswa')->user()->id)->count() > 0)
                                                    <span class="badge bg-success">Sudah Dikumpulkan</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Dikumpulkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($tugas->tugasJawaban->where('mahasiswa_id', auth()->guard('mahasiswa')->user()->id)->count() == 0)
                                                    <a href="{{ route('mahasiswa.tugas.create', $tugas->id) }}" class="btn btn-primary btn-sm">Kumpulkan</a>
                                                @else
                                                    <a href="{{ route('mahasiswa.tugas.show', $tugas->id) }}" class="btn btn-info btn-sm">Lihat Jawaban</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($tugasList->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada tugas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        {!! $tugasList->links() !!}

                        <!-- Tombol Kembali ke Halaman Kelas -->
                        <div class="mt-3 p-1 m-1">
                            <a href="{{ route('kelasmahasiswa.index') }}" class="btn btn-secondary">Kembali ke Halaman Kelas</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
