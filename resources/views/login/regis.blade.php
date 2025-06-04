<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaduan Masyarakat - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Style untuk background halaman */
    .hero-section {
      height: 100vh;
      background-color: #FF6F00;
      position: relative;
      overflow: hidden;
    }

    /* Hero image dengan efek clip */
    .hero-image {
      position: absolute;
      top: 0;
      right: 0;
      width: 50%;
      height: 100%;
      background-image: url('https://asset.kompas.com/crops/sl4JBUU2wh8KH5AjvgFEx_HMzSo=/0x0:5472x3648/750x500/data/photo/2021/05/17/60a26c8579470.jpg');
      background-size: cover;
      background-position: center;
      clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%);
    }

    /* Menambahkan efek teks hero */
    .hero-title {
      font-size: 3rem;
      font-weight: bold;
      color: white;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero-text {
      font-size: 1rem;
      color: white;
    }

    /* Form login */
    .login-form {
      width: 100%;
      max-width: 400px;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .login-form .form-control {
      border-radius: 5px;
      margin-bottom: 15px;
    }

    /* Tombol login */
    .login-form .btn-lumut {
      background-color: #4c7021;
      margin-top: 10px;
      color: white;
      font-size: 1rem;
      font-weight: bold;
      text-decoration: none;
      padding: 12px;
      width: 100%;
      border-radius: 5px;
      border: none;
      transition: transform 0.2s, box-shadow 0.2s ease-out;
    }

    .login-form .btn-lumut:hover {
      transform: translateY(-5px);
      box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    }

    /* Link Daftar Akun */
    .register-btn {
      display: block;
      margin-top: 15px;
      text-align: center;
      font-size: 1rem;
      text-decoration: none;
      color: #4c7021;
      font-weight: bold;
    }

    .register-btn:hover {
      color: #FF6F00;
    }

    /* Ikon tombol (fungsi untuk menambahkan elemen interaktif di sisi kanan) */
    .icon-btn {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
      margin: 15px 0;
      background-color: #4c7021;
      color: white;
      border: 2px solid #4c7021;
      transition: all 0.3s ease;
      border: none;
    }

    .icon-btn:hover {
      background-color: #FF6F00;
      border-color: #FF6F00;
      color: white;
      transform: translateY(-5px);
      box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    }

    .icon-btn:active {
      background-color: #FF6F00;
      border-color: #FF6F00;
      color: white;
      transform: translateY(2px);
      box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
    }

    /* Container untuk ikon navigasi */
    .icon-container {
      position: fixed;
      top: 50%;
      right: 60px;
      transform: translateY(-50%);
      z-index: 10;
    }

    /* Layout responsif */
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.5rem;
      }

      .hero-text {
        font-size: 0.9rem;
      }

      .login-form {
        padding: 20px;
      }

      .hero-image {
        display: none; /* Menyembunyikan gambar di layar kecil */
      }
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <div class="container-fluid p-0">
    <div class="row g-0 hero-section">
      <!-- Form Login -->
      <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-start p-5">
        <h1 class="display-4 hero-title">Login atau Daftar Akun</h1>
        <form class="login-form" method="POST">
            @csrf
    
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
    
            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="{{ old('password') }}" required>
    
            <!-- Tombol Login -->
            <button type="submit" formaction="{{ route('login.submit') }}" class="btn btn-lumut">Login</button>
            
            <!-- Tombol Daftar Akun -->
            <button type="submit" formaction="{{ route('register.submit') }}" class="btn btn-lumut">Daftar Akun</button>
        </form>
    </div>
    
    
      <!-- Ikon navigasi -->
      <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center text-center p-5">
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
