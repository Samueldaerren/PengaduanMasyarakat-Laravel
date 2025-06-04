<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaduan Masyarakat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar {
      background-color: #FF6F00;
    }
    .card-header {
      background-color: #FF6F00;
      color: white;
    }
    .card-body {
      padding: 15px;
    }
    .card {
      margin-bottom: 15px;
    }
    .card-title {
      font-weight: bold;
    }
    .card-text {
      font-size: 14px;
      color: #555;
    }
    .btn-toggle {
      margin-top: 10px;
    }
    .card-img-top {
      max-width: 50%;
      height: auto;
      max-height: 300px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="{{ route('report.article') }}">Pengaduan Masyarakat</a>
      <form action="{{ route('logout') }}" method="POST" class="ms-auto">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container mt-5">
    <h3>Pengaduan</h3>

    @foreach($reports as $report)
    <div class="card">
      <div class="card-header">
        Pengaduan {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }}
      </div>        
      <div class="card-body">
        <h5 class="card-title">Judul Pengaduan: {{ $report->type }}</h5>
        <p class="card-text"><strong>Lokasi:</strong> {{ $report->province }}, {{ $report->regency }}, {{ $report->subdistrict }}, {{ $report->village }}</p>
        <p class="card-text"><strong>Deskripsi:</strong> {{ $report->description }}</p>
        <p class="card-text"><strong>Status:</strong> 
          @if($report->statement)
            Terverifikasi
          @else
            Dalam Proses
          @endif
        </p>
        <button class="btn btn-primary btn-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample{{ $report->id }}" aria-expanded="false" aria-controls="collapseExample{{ $report->id }}">
          Lihat Detail
        </button>
        <div class="collapse" id="collapseExample{{ $report->id }}">
          <div class="card card-body mt-3">
            @if($report->image)
            <p>Gambar:
            <img src="{{ asset('storage/images/' . basename($report->image)) }}" class="card-img-top" alt="Gambar pengaduan">
            </p>
            @else
            <p>Gambar: Tidak ada gambar.</p>
            @endif

            <p>Status Terbaru: 
              @if($report->statement)
                Pengaduan sudah diverifikasi oleh pihak terkait.
              @else
                Pengaduan sedang diproses untuk verifikasi lebih lanjut.
              @endif
            </p>

            @if (!$report->hasResponse)
  <form action="{{ route('report.delete', $report->id) }}" method="POST" class="mt-4">
    @csrf 
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus Pengaduan</button>
  </form>
@endif

          </div>
        </div>
      </div>
    </div>
    @endforeach

    {{-- <!-- Pagination -->
    {{ $reports->links() }} --}}
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

