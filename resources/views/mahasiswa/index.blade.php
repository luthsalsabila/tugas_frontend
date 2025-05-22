@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #ffe6f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #fff0f5;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(255, 105, 180, 0.2);
        }

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

    <div class="container">
        <h1>Daftar Mahasiswa</h1>
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
    </div>
@endsection
