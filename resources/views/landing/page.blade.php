<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaduan Masyarakat</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Menambahkan style untuk ikon agar berbentuk bulat */
    .icon-btn {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
      margin: 15px 0; /* Menambahkan jarak antar ikon */
      background-color: #4c7021; /* Hijau lumut lebih gelap */
      color: white; /* Warna ikon putih */
      border: 2px solid #4c7021; /* Border dengan warna yang sama dengan background */
      transition: all 0.3s ease; /* Transisi efek hover */
      border: none; /* Menghilangkan border default dari tombol */
    }

    /* Efek hover untuk ikon menjadi oren */
    .icon-btn:hover {
      background-color: #FF6F00; /* Ganti warna background saat hover menjadi oren */
      border-color: #FF6F00; /* Border juga berubah menjadi oren */
      color: white; /* Warna ikon tetap putih */
      transform: translateY(-5px); /* Efek 3D ke atas */
      box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan 3D */
    }

    /* Menjaga ikon tetap oren saat ditekan */
    .icon-btn:active {
      background-color: #FF6F00; /* Tetap warna oren saat ditekan */
      border-color: #FF6F00; /* Border juga berubah menjadi oren */
      color: white; /* Warna ikon tetap putih */
      transform: translateY(2px); /* Efek ikon tertekan ke bawah */
      box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2); /* Bayangan lebih kecil saat ditekan */
    }

    /* Menempatkan ikon di kanan tengah dan memberikan jarak ke kanan */
    .icon-container {
      position: fixed;
      top: 50%;
      right: 60px; /* Mengubah jarak dari sisi kanan */
      transform: translateY(-50%);
      z-index: 10;
    }

    /* Mengubah ukuran teks untuk judul dan menyesuaikan posisi teks ke kiri */
    .hero-title {
      font-size: 3rem; /* Membesarkan ukuran teks untuk judul */
      text-align: left; /* Menempatkan judul di sebelah kiri */
    }

    .hero-text {
      font-size: 1rem; /* Ukuran teks lebih kecil */
      text-align: left; /* Mengubah teks menjadi rata kiri */
    }

    /* Hero Section Background */
    .hero-section {
      height: 100vh;
      background-color: #FF6F00;
      position: relative;
    }

    .hero-image {
      position: absolute;
      top: 0;
      right: 0;
      width: 50%; /* Membatasi gambar pada separuh kanan */
      height: 100%;
      background-image: url('https://asset.kompas.com/crops/sl4JBUU2wh8KH5AjvgFEx_HMzSo=/0x0:5472x3648/750x500/data/photo/2021/05/17/60a26c8579470.jpg');
      background-size: cover;
      background-position: center;
      clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%); /* Membuat ujung jajargenjang di kiri */
    }

    /* Tombol dengan warna hijau lumut dan teks putih */
    .btn-lumut {
      background-color: #4c7021; /* Hijau lumut lebih gelap */
      color: white; /* Teks putih */
      font-size: 1.25rem;
      font-weight: bold;
      text-decoration: underline; /* Menambahkan underline pada tombol */
      padding: 15px 30px; /* Menambah padding untuk efek 3D */
      border-radius: 5px;
      border: none; /* Menghilangkan border tombol */
      transition: transform 0.2s, box-shadow 0.2s ease-out; /* Menambahkan transisi untuk animasi 3D */
    }

    /* Efek 3D saat tombol di-hover */
    .btn-lumut:hover {
      background-color: #4c7021; /* Tetap hijau lumut */
      color: white; /* Teks tetap putih */
      text-decoration: underline; /* Menjaga garis bawah */
      transform: translateY(-5px); /* Efek 3D ke atas */
      box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan 3D */
    }

    /* Efek 3D saat tombol ditekan */
    .btn-lumut:active {
      background-color: #4c7021; /* Tetap hijau lumut */
      color: white; /* Teks tetap putih */
      transform: translateY(2px); /* Efek tombol tertekan ke bawah */
      box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2); /* Bayangan lebih kecil saat ditekan */
    }

  </style>
</head>
<body>

  <!-- Hero Section -->
  <div class="container-fluid p-0">
    <div class="row g-0 hero-section">
      <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-start text-white p-5">
        <h1 class="display-4 fw-bold hero-title">Pengaduan Masyarakat</h1>
        <p class="lead hero-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eligendi perspiciatis aut pariatur doloremque laboriosam quis in praesentium at.</p>
        <a href="{{ route('login') }}" class="btn btn-lumut btn-lg">Bergabung!</a>
      </div>
      <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center text-center text-white p-5">
        <!-- Ikon akan ditampilkan di kanan tengah -->
        <div class="icon-container">
          <button class="icon-btn"><i class="bi bi-person"></i></button>
          <button class="icon-btn"><i class="bi bi-exclamation-circle"></i></button>
          <button class="icon-btn"><i class="bi bi-pencil"></i></button>
        </div>
      </div>
    </div>

    <!-- Hero Image with clipped shape -->
    <div class="hero-image"></div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>