<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $Dosen = Dosen::count();
        $Mahasiswa = Mahasiswa::count();
        return view('dashboard', compact('Dosen', 'Mahasiswa'));
    }
}
