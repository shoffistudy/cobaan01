<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/webutama/halamanlogin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <title>Halaman Login || PT.INKA Multi Solusi E-Procurement</title>
</head>
<body class="wrapper">

    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");
            i.className = i.className === "nav-menu" ? "nav-menu responsive" : "nav-menu";
        }
    </script>

    <div class="login-container">
        <div class="login-form">
            <div class="login-header">
                <i class='bx bxs-lock-open'></i>
                <h2>Login</h2>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                {{-- <!-- Pilih Role -->
                <div class="input-group">
                    <label for="role">Pilih Login Sebagai</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="admin_logistik">Admin Logistik</option>
                        <option value="divisi">Divisi</option>
                        <option value="vendor_rekanan">Vendor</option>
                    </select>
                </div> --}}

                <!-- Email Input -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required>
                </div>

                <!-- Password Input -->
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
                    <a href="{{ route('password.request') }}" class="forgot-password">Lupa kata sandi? <span>Klik Disini</span></a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <p>Apakah anda belum memiliki akun? <a href="{{ url('register') }}"><span>Klik Disini</span></a></p>
        </div>
        <div class="login-image">
            <img src="{{ asset('img/login.png') }}" alt="Illustration">
        </div>
    </div>

</body>
</html>
