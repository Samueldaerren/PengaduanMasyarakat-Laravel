<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Dashboard</title>
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .navbar-brand img {
      width: 30px;
      height: 30px;
    }
    .chart-container {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img alt="Logo" height="30" src="https://storage.googleapis.com/a1aa/image/s60gi5D7A6IhFFRK7c85umMURjjxaXzkSV0uNX2BHL8L0FfJA.jpg" width="30"/>
        Kelola Akun
      </a>
      <div class="d-flex">
        <a class="btn btn-outline-primary me-2" href="{{ route('account.manage') }}">Kelola Akun</a>
        <form action="{{ route('logout') }}" method="POST" class="ms-auto">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </nav>     

  <div class="container chart-container">
    <h5 class="text-center">
      Jumlah Pengaduan dan Tanggapan terhadap Pengaduan
    </h5>
    <h6 class="text-center">
      JAWA BARAT
    </h6>
    <div class="d-flex justify-content-center">
      <!-- Canvas untuk Grafik -->
      <canvas id="chart"></canvas>
    </div>
  </div>

  <script>
    // Data untuk grafik batang
    const ctx = document.getElementById('chart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'bar', // Jenis grafik batang
      data: {
        labels: ['Jumlah Pengaduan', 'Jumlah Tanggapan'], // Label untuk sumbu X
        datasets: [{
          label: 'Jumlah',
          data: [{{ $pengaduan }}, {{ $tanggapan }}], // Data dari controller
          backgroundColor: ['#007bff', '#28a745'], // Warna untuk masing-masing batang
          borderColor: ['#0056b3', '#218838'],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true // Mulai dari 0 di sumbu Y
          }
        }
      }
    });
  </script>
</body>
</html>
