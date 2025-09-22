@extends('layouts.admin')

@section('title')
    <title>Tambah Mahasiswa ke Kelas</title>
@endsection

@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Tambah Mahasiswa ke Kelas</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container-fluid">
        <div class="animated fadeIn">
            <form action="{{ route('kelas.inputsiswa', $id) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Mahasiswa ke Kelas</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="search">Cari Mahasiswa (Nama atau NIM)</label>
                                    <input type="text" id="search" class="form-control mb-3" placeholder="Cari...">
                                </div>

                                <div class="form-group" id="daftar-mahasiswa">
                                    @foreach($siswa as $mhs)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input mahasiswa-checkbox" type="checkbox" name="mahasiswa_id[]" value="{{ $mhs->id }}" id="mhs{{ $mhs->id }}">
                                            <label class="form-check-label" for="mhs{{ $mhs->id }}">
                                                {{ $mhs->nama }} ({{ $mhs->nim }})
                                            </label>
                                        </div>
                                    @endforeach
                                    <p class="text-danger">{{ $errors->first('mahasiswa_id') }}</p>
                                </div>

                                <div class="form-group mt-3">
                                    <button class="btn btn-primary btn-sm">Tambah Mahasiswa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12 p-1">
                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    document.getElementById("search").addEventListener("input", function () {
        let filter = this.value.toLowerCase();
        let mahasiswaList = document.querySelectorAll("#daftar-mahasiswa .form-check");

        mahasiswaList.forEach(function (item) {
            let label = item.querySelector("label").innerText.toLowerCase();
            if (label.includes(filter)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>
@endsection
