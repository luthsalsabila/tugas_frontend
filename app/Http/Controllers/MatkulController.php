<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatkulController extends Controller
{
    private $apiUrl = 'http://localhost:8080/matkul';

    public function index()
    {
        $response = Http::get($this->apiUrl);

        if ($response->successful()) {
            $matkuls = $response->json();
        } else {
            $matkuls = [];
        }

        return view('matkul.index', compact('matkuls'));
    }

    public function create()
    {
        return view('matkul.create');
    }

    public function store(Request $request)
    {
        $data = [
            'kode_matkul'   => $request->input('kode_matkul'),
            'nama_matkul'   => $request->input('nama_matkul'),
            'sks'           => $request->input('sks'),
        ];

        $response = Http::post($this->apiUrl, $data);

        if ($response->successful()) {
            return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Gagal menambahkan mata kuliah. ' . $response->body());
        }
    }

    public function edit($kode_matkul)
    {
        $response = Http::get("{$this->apiUrl}/{$kode_matkul}");

        if ($response->successful()) {
            $matkul = $response->json();
            return view('matkul.edit', compact('matkul'));
        } else {
            return redirect()->route('matkul.index')->with('error', 'Data tidak ditemukan.');
        }
    }

    public function update(Request $request, $kode_matkul)
    {
        $data = [
            'kode_matkul'   => $request->input('kode_matkul'),
            'nama_matkul'   => $request->input('nama_matkul'),
            'sks'           => $request->input('sks'),
        ];

        $response = Http::put("{$this->apiUrl}/{$kode_matkul}", $data); // Dikirim sebagai JSON

        if ($response->successful()) {
            return redirect()->route('matkul.index')->with('success', 'Data berhasil diperbarui.');
        } else {
            return back()->with('error', 'Gagal update. ' . $response->body());
        }
    }

    public function destroy($kode_matkul)
    {
        $response = Http::delete("{$this->apiUrl}/{$kode_matkul}");

        if ($response->successful()) {
            return redirect()->route('matkul.index')->with('success', 'Data berhasil dihapus.');
        } else {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
