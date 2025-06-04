<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Laporan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #FF6F00;
    }

    .navbar .navbar-brand, .navbar .nav-link {
      color: white;
    }

    .navbar .navbar-brand:hover, .navbar .nav-link:hover {
      color: #FFD54F;
    }

    .container {
      width: 80%;
      max-width: 1200px;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      margin-top: 20px;
    }

    .report-header {
      background-color: #FF6F00;
      padding: 15px;
      border-radius: 5px;
      text-align: center;
      color: white;
      margin-bottom: 20px;
    }

    .report-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .report-info p {
      margin: 0;
      font-size: 14px;
      color: #555;
    }

    .report-info .type {
      font-weight: bold;
      color: #FF6347;
    }

    .report-image {
      width: 100%;
      height: auto;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .details {
      background-color: #f1f1f1;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .comment-section {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 10px;
    }

    .comment-section h3 {
      margin-bottom: 10px;
      color: #333;
    }

    .input-comment {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .submit-comment {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .submit-comment:hover {
      background-color: #218838;
    }

    .info-box {
      background-color: #ffdf99;
      padding: 15px;
      border-radius: 5px;
      margin-top: 20px;
    }

    .info-box h3 {
      margin: 0;
    }

    .info-box p {
      margin: 5px 0;
      color: #333;
    }

    .comments-list {
      margin-top: 20px;
    }

    .comment-item {
      background-color: #f1f1f1;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }

    .comment-item strong {
      color: #000000;
    }

    .card-img-top {
      max-width: 100%;  
      height: auto;  
      border-radius: 10px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('report.article') }}">Pengaduan Masyarakat</a>
      <form action="{{ route('logout') }}" method="POST" class="ms-auto">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container">
    <!-- Report Header -->
    <div class="report-header">
      <h1>{{ $report->description }}</h1>
    </div>

    <!-- Report Information -->
    <div class="report-info">
      <p><strong>User:</strong> {{ $report->user->email }}</p>
      <p><strong>Waktu Laporan:</strong> {{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</p>
      <p class="type"><strong>Tipe Pengaduan:</strong> {{ $report->type }}</p>
    </div>

    <!-- Report Image -->
    <div class="details">
      <img src="{{ asset('storage/images/' . basename($report->image)) }}" class="card-img-top" alt="Gambar pengaduan">
      <p>{{ $report->details }}</p>
    </div>

    <!-- Display Comments -->
    <div class="comments-list">
      <h4>Komentar:</h4>
      @foreach ($report->comments as $comment)
        <div class="comment-item">
          <p>
            <small class="text-muted" style="float: right;">
              {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
            </small>
            <!-- Tanggal/Waktu komentar -->
            <strong class="comment-date">{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y') }}</strong><br>
            
            <!-- Nama pengguna -->
            <strong>{{ $comment->user->name ?? $comment->user->email }}</strong>
          </p>
    
          <!-- Isi komentar -->
          <p>{{ $comment->comment }}</p>
        </div>
      @endforeach
    </div>
    
     <!-- Comment Section -->
     <div class="comment-section">
      <h3>Tambahkan Komentar</h3>
      <form method="POST" action="{{ route('report.addComment', $report->id) }}">
        @csrf
        <textarea class="input-comment" name="comment" rows="4" placeholder="Tulis komentar..."></textarea>
        <button type="submit" class="submit-comment">Kirim Komentar</button>
      </form>
    </div>

    <!-- Info Box -->
    <div class="info-box">
      <h3>Informasi Pembuatan Pengaduan</h3>
      <p>1. Pengaduan di buat hanya untuk laporan yang benar-benar terjadi.</p>
      <p>2. Kesalahan dalam pengaduan bisa dikenakan sanksi.</p>
      <p>3. Laporkan kejadian yang sesuai dengan kriteria yang telah ditentukan.</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
