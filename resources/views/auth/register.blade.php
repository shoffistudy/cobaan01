<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi || PT.INKA Multi Solusi E-Procurement</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/webutama/registrasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>

<body>
    <div class="banner animated-banner">
        <h2>Silahkan Registrasi terlebih dahulu sebelum masuk ke dalam E-Procurement PT. INKA Multi Solusi</h2>
    </div>

    <x-guest-layout>
        <main class="main-content">
    
            {{-- Flash Message --}}
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
    
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
    
            <h2 class="text-4xl font-extrabold text-center mb-6 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-transparent bg-clip-text">
                Registrasi Vendor
            </h2>
    
            <form method="POST" action="{{ route('register') }}">
                @csrf
                    <!-- Nama Perusahaan -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Perusahaan')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="organization" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
    
                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
    
                    <!-- NPWP -->
                    <div class="mt-4">
                        <x-input-label for="npwp" :value="__('NPWP')" />
                        <x-text-input id="npwp" class="block mt-1 w-full" type="text" name="npwp" :value="old('npwp')" required />
                        <x-input-error :messages="$errors->get('npwp')" class="mt-2" />
                    </div>
    
                    <!-- Alamat -->
                    <div class="mt-4">
                        <x-input-label for="alamat" :value="__('Alamat')" />
                        <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" required />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>
    
                    <!-- PIC -->
                    <div class="mt-4">
                        <x-input-label for="pic" :value="__('Nama PIC')" />
                        <x-text-input id="pic" class="block mt-1 w-full" type="text" name="pic" :value="old('pic')" required />
                        <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                    </div>
    
                    <!-- Kontak PIC -->
                    <div class="mt-4">
                        <x-input-label for="kontak_pic" :value="__('Kontak PIC')" />
                        <x-text-input id="kontak_pic" class="block mt-1 w-full" type="text" name="kontak_pic" :value="old('kontak_pic')" required />
                        <x-input-error :messages="$errors->get('kontak_pic')" class="mt-2" />
                    </div>
    
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
    
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
    
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Sudah Punya Akun?') }}
                        </a>
    
                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                
            </form>
    
        </main>
    </x-guest-layout>
    

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h4>PT. INKA Multi Solusi Kantor Pusat</h4>
                <address>
                    Jalan Raya Surabaya - Madiun<br>
                    Km. 161 No. 1 Desa Bagi, Kec. Madiun, Jawa Timur 63151<br>
                    <span class="footer-contact"><i class="bx bx-phone"></i> +62 351 281205 / +62 351 281256</span><br>
                    <span class="footer-contact"><i class="bx bx-envelope"></i><a href="mailto:sekretariat@inkamultisolusi.co.id">sekretariat@inkamultisolusi.co.id</a></span>
                </address>
            </div>

            <div class="footer-column social-media-column">
                <h4>Sosial Media</h4>
                <ul class="social-media">
                    <li><a href="#"><i class="bx bxl-facebook"></i></a></li>
                    <li><a href="#"><i class="bx bxl-twitter"></i></a></li>
                    <li><a href="#"><i class="bx bxl-instagram"></i></a></li>
                    <li><a href="#"><i class="bx bxl-linkedin"></i></a></li>
                    <li><a href="#"><i class="bx bxl-youtube"></i></a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Kebijakan & Informasi</h4>
                <ul class="footer-links">
                    <li><a href="#">Kebijakan dan Privasi</a></li>
                    <li><a href="#">Syarat dan Ketentuan</a></li>
                    <li><a href="#">Kebijakan Pengguna Situs</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Navigasi Cepat</h4>
                <ul class="footer-links">
                    <li><a href="#">Tentang E-Proc IMS</a></li>
                    <li><a href="#">Visi Misi E-Proc IMS</a></li>
                </ul>
            </div>
        </div>
    </footer>

    {{-- JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>
