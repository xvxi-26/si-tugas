@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <h2>Profil Mahasiswa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('mahasiswa.updateChatId') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="chat_id" class="form-label">Chat ID Telegram</label>
            <input type="text" class="form-control" id="chat_id" name="chat_id" value="{{ old('chat_id', auth()->guard('mahasiswa')->user()->chat_id) }}" required>
            <small class="form-text text-muted">Dapatkan chat ID Anda dengan mengirim pesan "/start" ke <a href="" target="_blank" style="text-decoration: none">bot</a> lalu cek di <a href="https://api.telegram.org/bot<token>/getUpdates" target="_blank">link ini</a>.</small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
