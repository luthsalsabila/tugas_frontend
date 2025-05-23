<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class MahasiswaController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:8080/']);
    }

    public function index()
    {
        $response = $this->client->get('mahasiswa');
        $mahasiswa = json_decode($response->getBody()->getContents(), true);

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $response = $this->client->post('mahasiswa', [
            'form_params' => $request->all()
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($npm)
    {
        $response = $this->client->get("mahasiswa/{$npm}");
        $mahasiswa = json_decode($response->getBody()->getContents(), true);

        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $npm)
    {
        $data = $request->only(['nama_mahasiswa', 'email', 'id_user', 'kode_kelas']);

        $response = $this->client->put("mahasiswa/{$npm}", [
            'json' => $data
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($npm)
    {
        $response = $this->client->delete("mahasiswa/{$npm}");

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus');
    }
}