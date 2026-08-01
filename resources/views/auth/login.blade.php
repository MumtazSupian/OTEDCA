<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/dca.png') }}" type="image/jpeg">   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-main: #f4f5f7;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --accent-red: #dc2626;
            --border-color: #e2e8f0;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            background-color: var(--bg-card);
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 400px;
            padding: 32px;
            box-sizing: border-box;
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-header img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 14px;
            color: var(--text-main);
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--accent-red);
        }

        .error-message {
            color: var(--accent-red);
            font-size: 12px;
            margin-top: 4px;
        }

        .btn-primary {
            background-color: var(--accent-red);
            color: #ffffff;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background-color: #b91c1c;
        }

        .remember-group {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .remember-group input {
            margin-right: 8px;
            accent-color: var(--accent-red);
        }

        .remember-group label {
            font-size: 14px;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/suzuki-icon.jpeg') }}" alt="Suzuki Logo">
            <h1 class="login-title">OTE DCA</h1>
            <p class="login-subtitle">Operation Tranformation Excellent DCA</p>
        </div>

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-group">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="btn-primary">
                Log In
            </button>
        </form>
    </div>

</body>
</html>
