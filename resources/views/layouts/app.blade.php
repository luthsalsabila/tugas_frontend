<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #ffe6f0;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #ffb6c1;
            color: white;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            font-weight: bold;
            padding: 10px;
            border-radius: 8px;
        }
        .sidebar a:hover {
            background-color: #f78fb3;
        }
        .main-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #fff0f5;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>MAHASISWA & MATKUL</h2>
            <a href="/dashboard">📊 Dashboard</a>
            <a href="{{ route('mahasiswa.index') }}">📁 Mahasiswa</a>
            <a href="{{ route('matkul.index') }}">📁 Mata Kuliah</a>
        </div>

        <div class="main-content">
            @yield('content')
        </div>
    </div>
</body>
</html>
