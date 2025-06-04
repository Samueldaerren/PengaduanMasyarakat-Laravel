<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pengaduan Masyarakat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .navbar {
      background-color: #FF6F00;
      padding: 5px 10px;
    }

    .navbar .navbar-brand {
      color: white;
      padding: 5px 10px;
    }

    .container-fluid {
      margin-top: 20px;
    }

    .search-bar {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
    }

    .search-bar select {
      border-radius: 20px;
      border: 1px solid #ccc;
      padding: 10px;
      width: 70%;
    }

    .search-bar button {
      border-radius: 20px;
      background-color: #4c7021;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
    }

    .search-bar button:hover {
      background-color: #FF6F00;
    }

    .content {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .content .main-content {
      width: 75%;
    }

    .content .sidebar {
      width: 20%;
      background-color: #FF6F00;
      color: white;
      padding: 20px;
      border-radius: 10px;
    }

    .card {
      width: 100%;
      margin-bottom: 20px;
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
    }

    .card-img-top {
      width: 30%;
      height: 300px;
      object-fit: cover;
    }

    .card-body {
      width: 70%;
      padding: 15px;
    }

    .card-title {
      font-weight: bold;
    }

    .card-text {
      color: #555;
    }

    .sidebar h4 {
      font-weight: bold;
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style-type: none;
      padding: 0;
    }

    .sidebar ul li {
      margin-bottom: 10px;
    }

    .sidebar ul li a {
      color: white;
      text-decoration: none;
    }

    .sidebar ul li a:hover {
      text-decoration: underline;
    }

    .social-icons {
      display: flex;
      gap: 20px;
      font-size: 18px;
      color: #888;
    }

    .social-icons span {
      display: flex;
      align-items: center;
    }

    .social-icons i {
      margin-right: 5px;
    }

    @media (max-width: 768px) {
      .content {
        flex-direction: column;
      }

      .content .main-content {
        width: 100%;
      }

      .content .sidebar {
        width: 100%;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{ route('report.article') }}">Pengaduan Masyarakat</a>
    <form action="{{ route('logout') }}" method="POST" class="ms-auto">
      @csrf
      <button type="submit" class="btn btn-danger">Logout</button>
    </form>
  </nav>

  @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show mt-4 mx-3" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="container-fluid">
    <!-- Search Bar -->
    <form id="search-form" class="search-bar">
      <select id="provinsi-dropdown"  name="provinsi" class="form-select">
        <option value="">Pilih Provinsi</option>
      </select>
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>
  </div>
  

    <div class="content">
      <!-- Main Content Section -->
      <div class="main-content" id="report-list">
        <!-- Laporan akan ditampilkan di sini -->
        @foreach ($reports as $report)
        <div class="card" id="report-{{ $report->id }}">
          <img src="{{ asset('storage/images/' . basename($report->image)) }}" class="card-img-top" alt="Gambar pengaduan">
          <div class="card-body">
            <a href="{{ route('report.show', $report->id) }}" class="card-title"><h5>{{ $report->description }}</h5></a>
            <p class="card-text">User: {{ $report->user->email }}</p>
            <p class="card-text">{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</p>
            <div class="social-icons">
              <span><i class="bi bi-chat-text"></i> <span id="vote-count-{{ $report->id }}">{{ $report->votes }}</span> 💗</span>
              <span><i class="bi bi-eye"></i> <span id="view-count-{{ $report->id }}">{{ $report->viewers }}</span> 🌝</span>
            </div>
            <form action="{{ route('report.vote', $report->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-info mt-3">
                {{ in_array(auth()->id(), json_decode($report->voting, true)) ? 'Unvote' : 'Vote' }}
              </button>
            </form>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Sidebar -->
      <div class="sidebar">
        <h4>Informasi Pengaduan</h4>
        <ul>
          <li><a href="#">Pengaduan harus jelas dan benar</a></li>
          <li><a href="#">Pengaduan harus berisi masalah yang dapat dipertanggungjawabkan</a></li>
          <li><a href="#">Masukkan data dengan lengkap dan akurat</a></li>
          <li><a href="#">Ikuti tata cara pengaduan yang berlaku</a></li>
          <li><a href="{{ route('report.create') }}" class="btn btn-success">Buat Pengaduan</a></li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    async function loadProvinces() {
      try {
        const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        const provinces = await response.json();
  
        const dropdown = document.getElementById('provinsi-dropdown');
        provinces.forEach(province => {
          const option = document.createElement('option');
          option.value = province.name;
          option.textContent = province.name;
          dropdown.appendChild(option);
        });
      } catch (error) {
        console.error('Error fetching provinces:', error);
        alert('Gagal memuat provinsi.');
      }
    }
  
    async function searchByProvinsi() {
  const selectedProvinsi = document.getElementById('provinsi-dropdown').value;
  const searchParams = new URLSearchParams();

  if (selectedProvinsi) {
    searchParams.append('provinsi', selectedProvinsi);
  }

  const query = "provinsi=Jawa"; // Contoh query string, sesuaikan dengan input
const url = query ? `/reports?${query}` : '/reports'; // Jika query ada, tambahkan ke URL

// Lakukan fetch ke URL
fetch(url)
    .then(response => response.json())
    .then(data => {
        // Proses data yang diterima
        console.log(data);
    })
    .catch(error => {
        // Tangani error jika ada
        console.error('Error:', error);
    });
  
  try {
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
      }
    });

    const reports = await response.json();

    const reportList = document.getElementById('report-list');
    reportList.innerHTML = '';  // Clear existing reports
    
    if (reports.data.length === 0) {
      reportList.innerHTML = '<p>Tidak ada laporan yang ditemukan untuk provinsi ini.</p>';
    }

    reports.data.forEach(report => {
      const reportCard = document.createElement('div');
      reportCard.classList.add('card');
      reportCard.innerHTML = `
        <img src="${report.image || 'https://via.placeholder.com/150'}" class="card-img-top" alt="Gambar pengaduan">
        <div class="card-body">
          <h5 class="card-title">${report.description}</h5>
          <p class="card-text">User: ${report.user.email}</p>
          <p class="card-text">${report.created_at}</p>
          <button class="btn btn-info mt-3" onclick="toggleVote(${report.id})" data-voted="false">Vote</button>
        </div>
      `;
      reportList.appendChild(reportCard);
    });
  } catch (error) {
    console.error('Error fetching reports:', error);
    alert('Gagal memuat laporan.');
  }
}

  
    // Fungsi untuk menangani pencarian kata kunci jika diperlukan
    function searchReportsWithKeyword() {
      const keyword = document.getElementById('keyword-input').value.trim();
      const searchParams = new URLSearchParams();
  
      if (keyword) {
        searchParams.append('keyword', keyword);
      }
  
      const query = searchParams.toString();
      const url = query ? `/reports?${query}` : '/reports';
  
      fetchReports(url);
    }
  
    async function fetchReports(url) {
      try {
        const response = await fetch(url);
        const reports = await response.json();
  
        const reportList = document.getElementById('report-list');
        reportList.innerHTML = '';  // Clear existing reports
  
        reports.data.forEach(report => {
          const reportCard = document.createElement('div');
          reportCard.classList.add('card');
          reportCard.innerHTML = `
            <img src="${report.image || 'https://via.placeholder.com/150'}" class="card-img-top" alt="Gambar pengaduan">
            <div class="card-body">
              <h5 class="card-title">${report.description}</h5>
              <p class="card-text">User: ${report.user.email}</p>
              <p class="card-text">${report.created_at}</p>
              <button class="btn btn-info mt-3" onclick="toggleVote(${report.id})" data-voted="false">Vote</button>
            </div>
          `;
          reportList.appendChild(reportCard);
        });
      } catch (error) {
        console.error('Error fetching reports:', error);
        alert('Gagal memuat laporan.');
      }
    }
    loadProvinces();
  
  </script>
  

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
