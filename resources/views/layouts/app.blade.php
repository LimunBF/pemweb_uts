<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Lab</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
<body style="padding: 20px;">

    <header>
        <h1>Navigasi Utama</h1>
        <hr>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <hr>
        <p>&copy; 2025 - Kelompok UTS</p>
    </footer>

</body>
</html>