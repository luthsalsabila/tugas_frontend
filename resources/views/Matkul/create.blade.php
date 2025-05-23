@extends('layouts.app')

@section('content')
 <style>
        body {
            background-color: #ffe6f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 600px;
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

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 12px;
            font-weight: bold;
            color: #6c214e;
        }

        input {
            padding: 10px;
            border: 1px solid #f8c4d9;
            border-radius: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            background-color: #e83e8c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #f06292;
        }
    </style>
        <div class="container">
        <h2 style="text-align: center; color: #d63384; font-weight: bold; margin-bottom: 25px;">Tambah Mata Kuliah</h2>
        <form action="{{ route('matkul.store') }}" method="POST">
            @csrf
            <input name="kode_matkul" placeholder="Kode Matkul" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;"><br>
            <input name="nama_matkul" placeholder="Nama Matkul" style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;"><br>
            <input name="sks" type="number" placeholder="SKS" style="width: 100%; padding: 12px; margin-bottom: 25px; border: 1px solid #ccc; border-radius: 6px;"><br>
            <button type="submit" style="width: 100%; padding: 12px; background-color: #e83e8c; color: white; border: none; border-radius: 6px;">Simpan</button>
        </form>
    </div>
</div>
</div>
@endsection
