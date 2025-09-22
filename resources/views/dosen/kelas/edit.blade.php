@extends('dosen.layout.admin')

@section('title')
    <title>Edit Kelas</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Edit Kelas</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('kelasdosen.update', $kelas->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Kelas</h4>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kelas">Nama Kelas</label>
                                    <input type="text" name="kelas" class="form-control" value="{{ $kelas->kelas }}" required>
                                    <p class="text-danger">{{ $errors->first('kelas') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                    <input type="text" name="jurusan" class="form-control" value="{{ $kelas->jurusan }}" required>
                                    <p class="text-danger">{{ $errors->first('jurusan') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="angkatan">Angkatan</label>
                                    <input type="text" name="angkatan" class="form-control" value="{{ $kelas->angkatan }}" required>
                                    <p class="text-danger">{{ $errors->first('angkatan') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <input type="text" name="semester" class="form-control" value="{{ $kelas->semester }}" required>
                                    <p class="text-danger">{{ $errors->first('semester') }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="matkul_id">Mata Kuliah</label>
                                    <select name="matkul_id" class="form-control">
                                        <option value="">Pilih</option>
                                        @foreach ($matkul as $row)
                                            <option value="{{ $row->id }}" {{ old('matkul_id', $kelas->matkul_id) == $row->id ? 'selected' : '' }}>
                                                {{ $row->nm_mk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-danger">{{ $errors->first('matkul_id') }}</p>
                                </div>
                                    <button class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 p-1">
                    <a href="{{ route('dosen.kelas') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
        </div>
    </div>
</main>
@endsection
