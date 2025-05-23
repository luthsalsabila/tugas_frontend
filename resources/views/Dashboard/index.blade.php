@extends('layouts.app')

@section('content')
<style>
    .card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .card .text {
        max-width: 500px;
    }

    .card h1 {
        color: #d63384;
        font-weight: bold;
        font-size: 28px;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 16px;
        color: #444;
    }

    .card .highlight {
        color: #28a745;
        font-weight: bold;
        font-size: 16px;
    }

    .image-container img {
        max-width: 300px;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .card {
            flex-direction: column;
            text-align: center;
        }

        .image-container {
            margin-top: 20px;
        }
    }
</style>

<div class="card">
    <div class="text">
        <p class="highlight">SELAMAT DATANG!</p>
        <h1>Dashboard Pengelolaan data Mahasiswa & Mata Kuliah</h1>
        <p>Pantau, kelola, dan analisa data mahasiswa & matkul dengan tampilan modern yang mudah dipahami.</p>
        <p>Sistem ini dibuat sebagai latihan evaluasi PBF!</p>
    </div>
</div>
@endsection
