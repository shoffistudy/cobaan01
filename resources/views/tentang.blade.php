<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/webutama/tentang.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>Halaman Tentang Kami || PT.INKA Multi Solusi E-Procurement</title>
</head>


<body class>
    <nav class="header">
        {{-- Pengaturan Navbar Mulai --}}
        <div class="logo">
            <img src="img/logoims.png" alt="Logo"></a>
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="/" class="link ">Beranda</a></li>
                <li><a href="/syarat" class="link">Aturan & Syarat</a></li>
                <li><a href="/tentang" class="link ">Tentang Kami</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="location.href='login'">Masuk</button>
        </div>
        <div class="nav-menu-btn">
            <i class='bx bx-menu' onclick="myMenuFunction()"></i>
        </div>
    </nav>
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
    </nav>
    {{-- Pengaturan NAVBAR Selesai --}}


    <div class="content">
        <section class="about-section">
            <div class="text">
                <h2 class="custom-header">E-Procurement<br>PT. Inka Multi Solusi</h2>
                <p>Sistem e-procurement PT INKA Multi Solusi dirancang dengan<br>
                    tujuan utama untuk meningkatkan efisiensi dan transparansi dalam<br>
                proses pengadaan di perusahaan. <br>
                    <br> 
                    Dengan menggunakan teknologi digital terkini,<br>
                    sistem ini memfasilitasi berbagai tahapan dalam proses pengadaan, <br>
                    mulai dari pengajuan permintaan, evaluasi vendor, hingga penyelesaian kontrak.</p>
            </div>
            <div class="image-box">
                    <div class="logo">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/vbbxiDDYiyk?autoplay=1&loop=1&playlist=vbbxiDDYiyk&mute=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section class="header-section">
        <h2 class="section-header">Tentang E-Procurement IMS</h2>
    </section>
    <section class="info-section">
        <div class="info-header-box">
            <p>
                Selamat datang di PT INKA Multi Solusi, platform e-procurement yang dirancang khusus untuk memudahkan perusahaan dalam melakukan permintaan pengadaan bahan baku dan segala kebutuhan internal dengan vendor-vendor terverifikasi sebagai mitra rekanan kami. Sebagai bagian dari PT Industri Kereta Api (Persero), kami menghadirkan solusi komprehensif yang tidak hanya menawarkan akses mudah dan cepat ke produk-produk berkualitas, tetapi juga memastikan keamanan dan keterpercayaan dalam setiap transaksi.
            </p>
            <p>
                Sistem e-procurement PT INKA Multi Solusi tidak hanya bertujuan untuk meningkatkan efisiensi operasional, tetapi juga untuk mendukung pertumbuhan bisnis yang berkelanjutan melalui pengelolaan pengadaan yang lebih efektif dan terencana. Dengan demikian, perusahaan dapat fokus pada penyediaan produk dan layanan yang berkualitas tinggi untuk memenuhi kebutuhan internal dan eksternal dengan lebih baik.
            </p>
        </div>
    </section>

    <section class="header-section">
        <h2 class="section-header">Visi Misi E-Procurement IMS</h2>
    </section>
    <section class="info-section">
        <div class="info-header-box">
            <p>
                <strong>Visi</strong>
            </p>
            <p>
                Penyedia Jasa “Total Solution Provider” di Bidang Konstruksi dan Perdagangan
            </p>
            <p>
                <strong>Misi</strong>
            </p>
            <p>
                Mendorong Proses yang Fleksibel dan Efisien untuk Meningkatkan Pertumbuhan Pendapatan dan Laba Perusahaan
            </p>
        </div>
    </section>

    <section class="header-section">
        <h2 class="section-header">FAQ (Frequently Asked Questions)</h2>
    </section>
    <section class="faq-section">
        <div class="info-header-box">
            <div class="faq-box">
                <details>
                    <summary>Apa saja langkah-langkah untuk memulai proses pengadaan di PT INKA Multi Solusi?</summary>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultricies justo non ipsum feugiat, id tincidunt urna varius. 
                    </p>
                </details>
                <details>
                    <summary>Bagaimana cara memantau status pengadaan atau kontrak yang sedang berlangsung?</summary>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultricies justo non ipsum feugiat, id tincidunt urna varius. 
                    </p>
                </details>
                <details>
                    <summary>Bagaimana jika saya ingin menjadi vendor di PT INKA Multi Solusi?</summary>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultricies justo non ipsum feugiat, id tincidunt urna varius. 
                    </p>
                </details>
            </div>
        </div>
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