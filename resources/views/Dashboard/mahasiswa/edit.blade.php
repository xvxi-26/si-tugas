@extends('layouts.admin')

@section('title')
    <title>Edit Mahasiswa</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Edit Mahasiswa</li>
    </ol>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('mahasiswaadmin.update', $mahasiswa->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $mahasiswa->nama }}" required>
                                    <p class="text-danger">{{ $errors->first('nama') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" name="nim" class="form-control" value="{{ $mahasiswa->nim }}" required>
                                    <p class="text-danger">{{ $errors->first('nim') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="angkatan">Angkatan</label>
                                    <input type="text" name="angkatan" class="form-control" value="{{ $mahasiswa->angkatan }}" required>
                                    <p class="text-danger">{{ $errors->first('angkatan') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_telepon">Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" class="form-control" value="{{ $mahasiswa->nomor_telepon }}" required>
                                    <p class="text-danger">{{ $errors->first('nomor_telepon') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $mahasiswa->email }}" required>
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" name="password" class="form-control">
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
