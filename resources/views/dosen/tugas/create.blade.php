@extends('dosen.layout.admin')

@section('title')
    <title>Tambah Tugas</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Buat Tugas Baru</h2>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

            <form action="{{ route('tugasdosen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Tugas</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $kel)
                            <option value="{{ $kel->id }}" {{ old('kelas_id') == $kel->id ? 'selected' : '' }}>{{ $kel->kelas }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}" required>
                    @error('deadline')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Interval Pengingat</label>
                    <div class="d-flex">
                        <input type="number" id="jam" class="form-control me-2" placeholder="Jam" min="0">
                        <input type="number" id="menit" class="form-control" placeholder="Menit" min="0">
                        <input type="hidden" name="pengingat_interval" id="pengingat_interval">
                    </div>
                    @error('pengingat_interval')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload File (Opsional)</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('jam').addEventListener('input', updateInterval);
    document.getElementById('menit').addEventListener('input', updateInterval);

    function updateInterval() {
        let jam = parseInt(document.getElementById('jam').value) || 0;
        let menit = parseInt(document.getElementById('menit').value) || 0;
        document.getElementById('pengingat_interval').value = (jam * 60) + menit;
    }
</script>
@endsection
