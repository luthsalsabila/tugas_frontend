<!DOCTYPE html>
<html>
<head>
    <title>Mahasiswa</title>
</head>
<body>
    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @yield('content')
</body>
</html>
