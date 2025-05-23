@extends('layouts.app')

@section('content')
    <style>
        h1 {
            color: #d63384;
            text-align: center;
            margin-bottom: 25px;
        }

        a.btn-tambah {
            display: inline-block;
            background-color: #ff69b4;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        a.btn-tambah:hover {
            background-color: #ff85c1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #f8c4d9;
        }

        th {
            background-color: #ffc0cb;
            color: #6c214e;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 10px;
        }

        td a {
            color: #e83e8c;
            text-decoration: none;
            margin-right: 10px;
        }

        td a:hover {
            text-decoration: underline;
        }

        form {
            display: inline;
        }

        button {
            background-color: #e83e8c;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #f06292;
        }
    </style>

    <h1>Daftar Mahasiswa</h1>

    <form action="{{ route('mahasiswa.index') }}" method="GET" style="margin-bottom: 15px;">
        <input type="text" name="search" placeholder="Cari mahasiswa..." value="{{ request('search') }}"
               style="padding: 8px; width: 250px; border-radius: 8px; border: 1px solid #ccc;">
        <button type="submit"
                style="padding: 8px 12px; background-color: #e83e8c; color: white; border: none; border-radius: 8px;">🔍 Cari</button>
    </form>

    <a href="{{ route('mahasiswa.create') }}" class="btn-tambah">➕ Tambah Mahasiswa</a>
    <table>
        <tr>
            <th>NPM</th><th>Nama</th><th>Email</th><th>Kelas</th><th>Aksi</th>
        </tr>
        @foreach ($mahasiswa as $mhs)
            <tr>
                <td>{{ $mhs['npm'] }}</td>
                <td>{{ $mhs['nama_mahasiswa'] }}</td>
                <td>{{ $mhs['email'] }}</td>
                <td>{{ $mhs['nama_kelas'] ?? '-' }}</td>
                <td>
                    <a href="{{ route('mahasiswa.edit', $mhs['npm']) }}">Edit</a>
                    <form action="{{ route('mahasiswa.destroy', $mhs['npm']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        
    </table>
@endsection
