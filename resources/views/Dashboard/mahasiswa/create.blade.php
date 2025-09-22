@extends('layouts.admin')

@section('title')
    <title>Tambah Mahasiswa</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Tambah Mahasiswa</li>
    </ol>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('mahasiswaadmin.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <!-- Nama -->
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                                    <p class="text-danger">{{ $errors->first('nama') }}</p>
                                </div>

                                <!-- NIM -->
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required>
                                    <p class="text-danger">{{ $errors->first('nim') }}</p>
                                </div>

                                <!-- Angkatan -->
                                <div class="form-group">
                                    <label for="angkatan">Angkatan</label>
                                    <input type="text" name="angkatan" class="form-control" value="{{ old('angkatan') }}" required>
                                    <p class="text-danger">{{ $errors->first('angkatan') }}</p>
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="form-group">
                                    <label for="nomor_telepon">Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon') }}" required>
                                    <p class="text-danger">{{ $errors->first('nomor_telepon') }}</p>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm m-3">Simpan</button>
                                </div>
                            </div> <!-- card-body selesai di sini -->
                        </div> <!-- card selesai di sini -->
                    </div> <!-- col-md-8 selesai di sini -->
                </div> <!-- row selesai di sini -->
            </form>
        </div>
    </div>
</main>
@endsection

