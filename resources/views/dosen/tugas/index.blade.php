@extends('dosen.layout.admin')

@section('title')
    <title>List Tugas</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Konten utama -->
        <main class="col-md-10 ml-sm-auto px-4">
            <h3 class="my-3">Daftar Tugas</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas->tugas as $index => $tugas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tugas->judul }}</td>
                            <td>{{ $tugas->deskripsi }}</td>
                            <td>{{ $tugas->deadline }}</td>
                            <td>
                                <a href="{{ route('dosen.tugasshow', $tugas->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <form action="{{ route('dosen.tugasdestroy', $tugas->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 p-1">
                    <a href="{{ route('dosen.kelas') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
        </main>
    </div>
</div>
@endsection
