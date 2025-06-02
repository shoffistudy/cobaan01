<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/webutama/beranda.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>Halaman Beranda || PT.INKA Multi Solusi E-Procurement</title>
</head>

<body>
    <nav class="header">
        <div class="logo">
            <img src="img/logoims.png" alt="Logo">
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="/" class="link">Beranda</a></li>
                <li><a href="/syarat" class="link">Aturan & Syarat</a></li>
                <li><a href="/tentang" class="link">Tentang Kami</a></li>
                {{-- <li><a href="/berandavendor" class="link">Vendor</a></li>
                <li><a href="/berandaadmin" class="link">Admin</a></li> --}}
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="location.href='login'">Masuk</button>
        </div>
        <div class="nav-menu-btn">
            <i class='bx bx-menu' onclick="myMenuFunction()"></i>
        </div>
    </nav>
     {{-- penambahan alert --}}
     @if(session('status'))
     <div class="alert alert-success">
         {{ session('status') }}
     </div>
     @endif
     
    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");
            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
    </script>

    <div class="content">
        <section class="hero-section">
            <h1>Selamat Datang di E-Procurement PT. INKA Multi Solusi</h1>
            <p>Di PT INKA Multi Solusi, kami bangga menjadi mitra pengadaan yang andal untuk memenuhi kebutuhan bisnis Anda.</p>
        </section>
        
        <section class="image-section">
            <img src="img/kereta.jpg" alt="Gambar">
        </section>

        <section class="about-section">
            <h2>Mengapa Memilih Kami?</h2>
            <p>Kami tidak hanya menawarkan akses kepada produk dan layanan berkualitas tinggi, tetapi juga menyediakan pengalaman transaksi yang aman, efisien, dan terpercaya.</p>
            <ul>
                <li>Keamanan Transaksi Terjamin: Setiap transaksi dijamin keamanannya, memberi Anda kedamaian pikiran dalam setiap pembelian.</li>
                <li>Kemitraan yang Membangun: Kami membangun kemitraan jangka panjang dengan vendor-vendor yang berkomitmen pada standar kualitas tertinggi.</li>
                <li>Inovasi dalam Pengadaan: Temukan solusi inovatif dan efisien yang mendukung pertumbuhan bisnis Anda.</li>
            </ul>
        </section>

        <section class="clients-section">
            <h2>Beberapa Pelanggan PT. INKA Multi Solusi</h2>
            <div class="clients-carousel">
                <!-- Gambar Pelanggan -->
                <img src="img/pengiriman.jpg" alt="Client 1">
                <img src="img/pertashop.jpg" alt="Client 2">
                <img src="img/miniatur.jpg" alt="Client 3">
                <img src="img/pengiriman.jpg" alt="Client 4">
                <img src="img/pertashop.jpg" alt="Client 5">
                <img src="img/pengiriman.jpg" alt="Client 6">
                <img src="img/pertashop.jpg" alt="Client 7">
                <img src="img/miniatur.jpg" alt="Client 8">
                <img src="img/pertashop.jpg" alt="Client 9">
                <img src="img/miniatur.jpg" alt="Client 10">
            </div>
        </section>

        <section class="cta-section">
            <h1>Mulai Pengalaman Pengadaan Anda Sekarang!</h1>
            <button class="btn cta-btn" onclick="location.href='login'">Mulai Sekarang</button>
        </section>
    </div>


{{-- Pengaturan FOOTER Mulai --}}
<footer class="footer">
    <div class="footer-content">
        <div class="footer-column">
            <h4>PT. INKA Multi Solusi Kantor Pusat</h4>
            <address>
                Jalan Raya Surabaya - Madiun<br>
                Km. 161 No. 1 Desa Bagi,<br>
                Kec. Madiun, Madiun, Jawa Timur 63151<br>
                <span class="footer-contact"><i class="bx bx-phone"></i> +62 351 281205 / +62 351 281256</span>
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
{{-- Pengaturan FOOTER Selesai --}}

</body>
</html>
