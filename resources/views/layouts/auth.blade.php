<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .auth-card {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem;
        }
        .auth-card img { display:block; margin:0 auto 1rem auto; height:80px; }
        .auth-card h4 { text-align:center; margin-bottom:1.5rem; font-weight:600; }
        .form-control { border-radius:10px; border:1px solid #ced4da; padding:10px 12px; }
        .form-control:focus { border-color:#0d6efd; box-shadow:0 0 0 3px rgba(13,110,253,0.15); }
        .btn-primary { border-radius:10px; font-weight:600; padding:10px; }
        .btn-primary:hover { background-color:#0b5ed7; }
        .text-link { text-align:center; margin-top:1rem; }
        .text-link a { color:#0d6efd; font-weight:600; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
