<h2> Deskripsi Proyek </h2>
Proyek ini adalah aplikasi frontend yang dikembangkan untuk memenuhi tugas Praktikum Pemrograman Berbasis Framefork. Frontend ini dirancang untuk berintegrasi dengan backend melalui API. Teknologi yang digunakan meliputi:

- HTML: Untuk struktur halaman.
- CSS: Untuk styling dan tata letak.
- JavaScript: Untuk logika dan interaksi dinamis.

<h2>Langkah-Langkah Pengaturan dan Pembuatan Proyek</h2>
Berikut adalah langkah-langkah rinci untuk meng-clone backend, membuat frontend, dan menjalankan proyek. Namun dalam file frontend ini hanya menampilkan 1 tabel yaitu tabel mahasiswa. Beikut langkah-langkahnya :

1. Meng-clone Repositori Backend

Untuk memulai, Anda perlu meng-clone repositori backend (diasumsikan backend sudah tersedia di GitHub atau sumber lain). Ikuti langkah berikut:
    1. Buka terminal atau command prompt.
    2. Clone repositori backend :
       ```
           git clone https://github.com/NalindraDT/Simon-kehadiran
       ```
    3. Masuk ke direktori backend :
       ```php
           cd Simon-kehadiran
       ```
2. Buat database
   ```sql
    CREATE TABLE `mahasiswa` (
      `npm` INT NOT NULL,
      `nama_mahasiswa` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE             utf8mb4_0900_ai_ci NOT NULL,
      `email` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
      `id_user` INT NOT NULL,
      `kode_kelas` VARCHAR(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
      PRIMARY KEY (`npm`),
      FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (`kode_kelas`) REFERENCES `kelas`(`kode_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
    );
   ```

3. Install Dependency Laravel
   ```php
   composer install
   ```
4. Dilanjut
   ```php
   php spark serve
   ```

Lalu cek apakah localhostnya bisa diakases

4. Yg .env be diganti development jadi CI_ENVIRONMENT = development
   kalau belum ada file .env, copy punya env lain terus ubah jadi .env
5. aktifin sambungan database jadi 
    ```php
    database.default.hostname = localhost
    database.default.database = (NAMA DB)
    database.default.username = root
    database.default.password = 
    database.default.DBDriver = MySQLi
    database.default.DBPrefix =
    database.default.port = 3306
    ```
   
6. Pengetesan pada aplikasi postman, gunakan endpoint - endpoint. berikut endpoin yang bisa digunakan
- Get = liat semua
- Post = nambah data
- Put = update
- Del = delete
   A. Mahasiswa 
    - GET mahasiswa : http://localhost:8080/mahasiswa
    - POST mahasiswa : http://localhost:8080/mahasiswa
    - PUT mahasiswa : http://localhost:8080/mahasiswa/{npm}
    - DELETE mahasiswa : http://localhost:8080/mahasiswa/{npm}
   B.  Matkul
    - GET matkul : http://localhost:8080/matkul
    - POST matkul : http://localhost:8080/matkul
    - PUT matkul : http://localhost:8080/matkul/{kode_matkul}
    - DELETE matkul : http://localhost:8080/matkul/{kode_matkul}
   
7. Bikin file FE pake Laravel
    laragon klik kanan > Quick app > Laravel > isikan nama yang sesuai > tunggu hingga selesai

8. Menjalankan Laravel
   ```php
    php artisan serve
   ```
9. Membuat controller
    ```php
    php artisan make:controller MahasiswaController
    php artisan make:controller MatkulController
    php artisan make:controller DashboardController
    ```
   a. MahasiswaController.php
   ```php
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
   ```

   b. MatkulController.php
   ```php
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

   ```

    c. DashhboardController
   ```php
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

   ```

10. Membuat view untuk tampilan
    Resourches > view
    a. Dashboard > index.blade.php
    ```php
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
    ```
    b. layouts > app.blade.php
    ```php
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
    ```
    c. mahasiswa > create.blade.php
    ```php
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
                <h1>Tambah Mahasiswa</h1>
                <form method="POST" action="{{ route('mahasiswa.store') }}">
                    @csrf
        
                    <label>NPM</label>
                    <input name="npm" required>
        
                    <label>Nama</label>
                    <input name="nama_mahasiswa" required>
        
                    <label>Email</label>
                    <input name="email" type="email" required>
        
                    <label>ID User</label>
                    <input name="id_user" required>
        
                    <label>Kode Kelas</label>
                    <input name="kode_kelas" required>
        
                    <button type="submit">Simpan</button>
                </form>
            </div>
        @endsection

    ```

    d. mahasiswa > edit.blade.php
    ```php
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
                <h2 style="text-align: center; color: #d63384; font-weight: bold; margin-bottom: 20px;">Edit Mahasiswa</h2>
                <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa['npm']) }}">
                    @csrf
                    @method('PUT')
                    
                    <label for="npm">NPM</label>
                    <input type="text" name="npm" id="npm" value="{{ $mahasiswa['npm'] }}" class="form-control" style="margin-bottom: 10px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
        
                    <label for="nama_mahasiswa">Nama</label>
                    <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" value="{{ $mahasiswa['nama_mahasiswa'] }}" class="form-control" style="margin-bottom: 10px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
        
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ $mahasiswa['email'] }}" class="form-control" style="margin-bottom: 10px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
        
                    <label for="id_user">ID User</label>
                    <input type="text" name="id_user" id="id_user" value="{{ $mahasiswa['id_user'] }}" class="form-control" style="margin-bottom: 10px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
        
                    <label for="nama_kelas">Kode Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" value="{{ $mahasiswa['nama_kelas'] }}" class="form-control" style="margin-bottom: 20px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 100%;">
        
                    <button type="submit" style="width: 100%; padding: 10px; background-color: #e83e8c; color: white; border: none; border-radius: 5px;">Update</button>
                </form>
            </div>
            </div>
        </div>
        @endsection

    ```
    e. mahasiswa > index.blade.php
    ```php
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

    ```

    f. matkul > create.blade.php
    ```php
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

    ```
    g. matkul > edit.blade.php
    ```php
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
            <h2>Edit Mata Kuliah</h2>
            <form action="{{ route('matkul.update', $matkul['kode_matkul']) }}" method="POST">
                @csrf
                @method('PUT')
                <input name="kode_matkul" value="{{ $matkul['kode_matkul'] }}" readonly><br>
                <input name="nama_matkul" value="{{ $matkul['nama_matkul'] }}"><br>
                <input name="sks" value="{{ $matkul['sks'] }}"><br>
                <button type="submit">Update</button>
            </form>
            </div>
        @endsection
    ``` 

    h. Matkul > index.blade.php
    ```php
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

    ```

10. Mengatur web routes
    routes > web.php
    ```php
                <?php
        
        
        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\MahasiswaController;
        use App\Http\Controllers\MatkulController;
        
        Route::get('/dashboard', function () {
            $Dosen = 1000;
            $jumlahMahasiswa = 10000;
            $jumlahMatkul = 50; // Tambahkan ini (atau ambil dari database)
        
            return view('Dashboard.index', compact('Dosen', 'jumlahMahasiswa', 'jumlahMatkul'));
        });
        
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        
        Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/mahasiswa/{npm}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/{npm}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::delete('/mahasiswa/{npm}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
        
        Route::resource('matkul', MatkulController::class);
        Route::get('/matkul', [MatkulController::class, 'index'])->name('matkul.index');
        Route::get('/matkul/create', [MatkulController::class, 'create'])->name('matkul.create');
        Route::post('/matkul', [MatkulController::class, 'store'])->name('matkul.store');
        Route::get('/matkul/{kode_matkul}/edit', [MatkulController::class, 'edit'])->name('matkul.edit');
        Route::put('/matkul/{kode_matkul}', [MatkulController::class, 'update'])->name('matkul.update');
        Route::delete('/matkul/{kode_matkul}', [MatkulController::class, 'destroy'])->name('matkul.destroy');
    ```
    
