<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/webutama/syarat.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>Halaman Aturan & Syarat || PT.INKA Multi Solusi E-Procurement</title>
</head>


<body class="wrapper">
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


    {{-- <div class="banner"></div> --}}
    <div class="content">
        <section class="main-section">
            <h2>Aturan & Syarat</h2>
            <h3>Penggunaan Website Sistem Manajemen Vendor PT. INKA Multi Solusi</h3>
            <p>Morem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim egestas, ac scelerisque ante pulvinar. Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel bibendum lorem. 
                </p>
        </section>
    </div>

    <div class="content a">
        <section class="main-section">
            <h2>Aturan & Syarat</h2>
            <h3>Penggunaan Website Sistem Manajemen Vendor PT. INKA Multi Solusi</h3>
            <p>Morem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. 
                Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. 
                Maecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
                Praesent auctor purus luctus enim egestas, ac scelerisque ante pulvinar.
                Donec ut rhoncus ex. Suspendisse ac rhoncus nisl, eu tempor urna. Curabitur vel bibendum lorem.
                Morbi convallis convallis diam sit amet lacinia. Aliquam in elementum tellus.
                Curabitur tempor quis eros tempus lacinia. Nam bibendum pellentesque quam a convallis. Sed ut vulputate nisi. 
                Integer in felis sed leo vestibulum venenatis. Suspendisse quis arcu sem. Aenean feugiat ex eu vestibulum vestibulum. 
                Morbi a eleifend magna. Nam metus lacus, porttitor eu mauris a, blandit ultrices nibh. M
                auris sit amet magna non ligula vestibulum eleifend. Nulla varius volutpat turpis sed lacinia. N
                am eget mi in purus lobortis eleifend. Sed nec ante dictum sem condimentum ullamcorper quis venenatis nisi. Proin vitae facilisis nisi, ac posuere leo.
                Nam pulvinar blandit velit, id condimentum diam faucibus at. 
                Aliquam lacus nisi, sollicitudin at nisi nec, fermentum congue felis. 
                Quisque mauris dolor, fringilla sed tincidunt ac, finibus non odio. Sed vitae mauris nec ante pretium finibus. 
                Donec nisl neque, pharetra ac elit eu, faucibus aliquam ligula. Nullam dictum, tellus tincidunt tempor laoreet, 
                nibh elit sollicitudin felis, eget feugiat sapien diam nec nisl. Aenean gravida turpis nisi, consequat dictum risus dapibus a.
                 Duis felis ante, varius in neque eu, tempor suscipit sem. Maecenas ullamcorper gravida sem sit amet cursus. E
                 tiam pulvinar purus vitae justo pharetra consequat. Mauris id mi ut arcu feugiat maximus. Mauris consequat tellus id tempus aliquet. 
                </p>
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
