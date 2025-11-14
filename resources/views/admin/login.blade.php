<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f1f5fb; /* biru muda soft */
        }
        .login-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }
        .login-title {
            color: #0d6efd; /* biru bootstrap */
            font-weight: 700;
        }
        .btn-login {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
        }
        .btn-login:hover {
            background-color: #0b5ed7;
        }
        .back-link {
            color: #0d6efd;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="login-card" style="width: 380px;">

        <h3 class="text-center login-title mb-4">Admin Login</h3>

        <form action="{{ route('admin.login.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username Admin</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Admin</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button class="btn btn-login w-100 mt-2">Login</button>
        </form>

        <p class="text-center mt-3">
            <a href="{{ route('home') }}" class="back-link">← Kembali ke Halaman Utama</a>
        </p>

    </div>

</div>

</body>
</html>
