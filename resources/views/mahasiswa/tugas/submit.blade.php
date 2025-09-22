@extends('mahasiswa.layouts.app')
<title>Kumpulkan Tugas</title>
@section('content')
<div class="container">
    <h2 class="mb-4">Kumpulkan Tugas</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $tugas->judul }}</h4>
            <p><strong>Deskripsi:</strong> {{ $tugas->deskripsi }}</p>
            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}</p>
            @php
            $deadlineTerlewat = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($tugas->deadline));
            @endphp
            <form action="{{ route('mahasiswa.tugas.store', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Upload Jawaban (PDF, DOC, DOCX)</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror"
                        name="file"
                        {{ $deadlineTerlewat ? 'disabled' : '' }}
                        required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center gap-2">
                    @unless($deadlineTerlewat)
                        <button type="submit" class="btn btn-success">Kumpulkan Jawaban</button>
                    @endunless

                    <a href="{{ route('kelasmahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>

            @if($deadlineTerlewat)
                <div class="alert alert-warning mt-3" role="alert">
                    Tenggat waktu pengumpulan telah berakhir. Anda tidak dapat mengumpulkan jawaban.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
