<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Pembayaran Penyebrangan</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            background-image:
                linear-gradient(
                    rgba(0, 55, 100, 0.55),
                    rgba(0, 35, 70, 0.65)
                ),
                url("{{ asset('images/pelabuhan.jpeg') }}");

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* CARD LOGIN */
        .login-card {
            width: 430px;
            max-width: 90%;
            background: rgba(255, 255, 255, 0.97);

            border-radius: 20px;
            padding: 40px 42px;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);

            text-align: center;
        }

        /* LOGO */
        .logo {
            width: 75px;
            height: 75px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: #0b5ea8;

            display: flex;
            align-items: center;
            justify-content: center;

            color: white;
            font-size: 34px;
            font-weight: bold;

            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.18);
        }

        /* JUDUL */
        .login-title {
            color: #123b5d;
            font-size: 22px;
            font-weight: 700;

            margin-bottom: 7px;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 14px;

            margin-bottom: 30px;
        }

        /* ERROR */
        .error-message {
            background: #fee2e2;
            color: #b91c1c;

            border: 1px solid #fecaca;

            padding: 11px 13px;
            border-radius: 8px;

            font-size: 13px;

            margin-bottom: 20px;

            text-align: left;
        }

        /* INPUT GROUP */
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            color: #374151;

            font-size: 14px;
            font-weight: 600;

            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;

            height: 48px;

            padding: 0 15px;

            border: 1px solid #d1d5db;
            border-radius: 9px;

            background: #ffffff;

            color: #1f2937;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #0b5ea8;

            box-shadow: 0 0 0 3px rgba(11, 94, 168, 0.12);
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        /* TOMBOL */
        .login-button {
            width: 100%;
            height: 48px;

            border: none;
            border-radius: 9px;

            background: #0b5ea8;
            color: white;

            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            transition: 0.2s;

            margin-top: 5px;
        }

        .login-button:hover {
            background: #084b87;
        }

        .login-button:active {
            transform: scale(0.99);
        }

        /* RESPONSIVE */
        @media (max-width: 500px) {
            .login-card {
                padding: 32px 25px;
            }

            .login-title {
                font-size: 19px;
            }

            .login-subtitle {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- LOGO -->
        <div class="logo">
            ⚓
        </div>

        <!-- JUDUL -->
        <h2 class="login-title">
            SISTEM PEMBAYARAN PENYEBRANGAN
        </h2>

        <p class="login-subtitle">
            Sistem Pengelolaan Pembayaran Antar Dermaga
        </p>

        <!-- PESAN ERROR -->
        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <!-- USERNAME -->
            <div class="form-group">
                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required
                    autofocus
                >
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <!-- TOMBOL -->
            <button type="submit" class="login-button">
                MASUK
            </button>

        </form>

    </div>

</body>
</html>