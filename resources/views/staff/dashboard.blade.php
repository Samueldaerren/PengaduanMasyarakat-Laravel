<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Staff - Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Menambahkan cursor pointer pada gambar */
        .profile-img {
            cursor: pointer;
        }

        /* Menghilangkan underline dan membuat teks hitam pada link */
        .sortable-link {
            color: black;          /* Teks menjadi hitam */
            text-decoration: none; /* Menghilangkan underline */
        }

        /* Membuat panah biru */
        .sortable-link i {
            color: blue; /* Panah berwarna biru */
        }

        /* Menambahkan margin pada tombol aksi */
        .btn-action {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="table-container">
            <div class="d-flex justify-content-between mb-3">
                <h5>Laporan Pengaduan</h5>
                <form action="" method="POST" name="importform"
      enctype="multipart/form-data">
        @csrf
                <button class="btn btn-success">
                    Export Data
                </button>
            </form>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Gambar &amp; Pengirim</th>
                        <th>Lokasi &amp; Tanggal</th>
                        <th>Deskripsi</th>
                        <th>
                            <a href="{{ route('staff.dashboard', ['sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" class="sortable-link">
                                Jumlah Vote
                                @if(request('sort_order') == 'asc')
                                    <i class="fas fa-arrow-up"></i>
                                @else
                                    <i class="fas fa-arrow-down"></i>
                                @endif
                            </a>
                        </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>
                                <img alt="Profile Image" class="profile-img" height="40" src="{{ asset('storage/images/' . basename($report->image)) }}" width="40" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . basename($report->image)) }}"/>
                                <span>{{ $report->user->email }}</span>
                            </td>
                            <td>
                                {{ $report->subdistrict }}, {{ $report->regency }}, {{ $report->province }}<br/>
                                {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }}
                            </td>
                            <td>{{ $report->description }}</td>
                            <td>{{ $report->votes }}</td>
                            <td>
                                <!-- Dropdown Button Aksi -->
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle btn-action" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#actionModal" data-bs-report-id="{{ $report->id }}">Tindak Lanjut</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk melihat gambar besar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Detail Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" class="img-fluid" alt="Detail Gambar"/>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tindak Lanjut -->
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">Tindak Lanjut Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staff.processAction') }}" method="POST" id="actionForm">
                        @csrf
                        <input type="hidden" id="report_id" name="report_id" value="">
                        <div class="mb-3">
                            <label for="action" class="form-label">Pilih Tindak Lanjut</label>
                            <select class="form-select" id="action" name="action" required>
                            <option value="tolak">Tolak</option>
                                <option value="proses">Proses Penyelesaian/Perbaikan</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Buat</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Menangani event klik pada gambar untuk menampilkan gambar besar di modal
        var imageLinks = document.querySelectorAll('.profile-img');
        imageLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                var imageUrl = this.getAttribute('data-bs-image'); // Mendapatkan URL gambar
                document.getElementById('modalImage').src = imageUrl; // Menampilkan gambar di modal
            });
        });

        // Menangani event klik pada dropdown untuk membuka modal Tindak Lanjut
        var actionLinks = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#actionModal"]');
        actionLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                var reportId = this.getAttribute('data-bs-report-id');
                document.getElementById('report_id').value = reportId;
            });
        });
    </script>
</body>
</html>
