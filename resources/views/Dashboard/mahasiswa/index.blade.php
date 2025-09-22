@extends('layouts.admin')

@section('title')
    <title>List Mahasiswa</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">List Mahasiswa</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                List Mahasiswa
                                <a href="{{ route('mahasiswaadmin.create') }}" class="btn btn-primary btn-sm float-right">Tambah</a>
                            </h4>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('mahasiswaadmin.index') }}" method="get">
                            <div class="input-group mb-3 col-md-3 float-right">
                                <input type="text" name="q" class="form-control" placeholder="Cari..." value="{{ request()->q }}">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Email</th>
                                        <th>Angkatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($mahasiswa as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $row->nama }}</strong></td>
                                        <td><strong>{{ $row->nim }}</strong></td>
                                        <td><strong>{{ $row->email }}</strong></td>
                                        <td><strong>{{ $row->angkatan }}</strong></td>
                                        <td>
                                            <form action="{{ route('mahasiswaadmin.destroy', $row->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('mahasiswaadmin.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $mahasiswa->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
