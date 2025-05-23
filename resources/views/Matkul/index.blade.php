@extends('layouts.app')

@section('content')
    <h2 style="text-align: center; color: #d63384; font-weight: bold; margin-bottom: 25px;">Daftar Mata Kuliah</h2>

    <form action="{{ route('matkul.index') }}" method="GET" style="margin-bottom: 15px;">
        <input type="text" name="search" placeholder="Cari matkul..." value="{{ request('search') }}"
               style="padding: 8px; width: 250px; border-radius: 8px; border: 1px solid #ccc;">
        <button type="submit"
                style="padding: 8px 12px; background-color: #e83e8c; color: white; border: none; border-radius: 8px;">🔍 Cari</button>
    </form>

    <a href="{{ route('matkul.create') }}"
       style="display: inline-block; margin-bottom: 20px; padding: 10px 15px; background-color: #e83e8c; color: white; border-radius: 5px; text-decoration: none;">
        ➕ Tambah Mata Kuliah
    </a>

    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #f8c8dc; color: #000;">
            <tr>
                <th style="padding: 10px; border: 1px solid #f0a0c0;">Kode</th>
                <th style="padding: 10px; border: 1px solid #f0a0c0;">Nama</th>
                <th style="padding: 10px; border: 1px solid #f0a0c0;">SKS</th>
                <th style="padding: 10px; border: 1px solid #f0a0c0;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matkuls as $matkul)
            <tr style="text-align: center;">
                <td style="padding: 10px; border: 1px solid #f0a0c0;">{{ $matkul['kode_matkul'] }}</td>
                <td style="padding: 10px; border: 1px solid #f0a0c0;">{{ $matkul['nama_matkul'] }}</td>
                <td style="padding: 10px; border: 1px solid #f0a0c0;">{{ $matkul['sks'] }}</td>
                <td style="padding: 10px; border: 1px solid #f0a0c0;">
                    <a href="{{ route('matkul.edit', $matkul['kode_matkul']) }}"
                       style="padding: 6px 12px; background-color: #ff69b4; color: white; border: none; border-radius: 4px; text-decoration: none; margin-right: 5px;">Edit</a>
                    <form action="{{ route('matkul.destroy', $matkul['kode_matkul']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')"
                                style="padding: 6px 12px; background-color: #e83e8c; color: white; border: none; border-radius: 4px;">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
