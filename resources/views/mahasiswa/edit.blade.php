@extends('layouts.app')

@section('content')
    <h1>Edit Mahasiswa</h1>
    <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa['npm']) }}">
        @csrf
        @method('PUT')
        NPM: <input name="npm" value="{{ $mahasiswa['npm'] }}"><br>
        Nama: <input name="nama_mahasiswa" value="{{ $mahasiswa['nama_mahasiswa'] }}"><br>
        Email: <input name="email" value="{{ $mahasiswa['email'] }}"><br>
        ID User: <input name="id_user" value="{{ $mahasiswa['id_user'] }}"><br>
        Kode Kelas: <input name="nama_kelas" value="{{ $mahasiswa['nama_kelas'] }}"><br>
        <button type="submit">Update</button>
    </form>
@endsection
