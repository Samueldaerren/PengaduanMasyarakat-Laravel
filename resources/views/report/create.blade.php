<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Pengaduan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FF6F00;">
    <a class="navbar-brand text-white" href="{{ route('report.article') }}">Pengaduan Masyarakat</a>
  </nav>

  <div class="container mt-5">
    <h3>Buat Pengaduan</h3>
    <form action="{{ route('report.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="type" class="form-label">Jenis Pengaduan</label>
            <select name="type" id="type" class="form-select" required>
                <option value="KEJAHATAN" {{ old('type') == 'KEJAHATAN' ? 'selected' : '' }}>KEJAHATAN</option>
                <option value="PEMBANGUNAN" {{ old('type') == 'PEMBANGUNAN' ? 'selected' : '' }}>PEMBANGUNAN</option>
                <option value="SOSIAL" {{ old('type') == 'SOSIAL' ? 'selected' : '' }}>SOSIAL</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="province" class="form-label">Provinsi</label>
            <select name="province" id="province" class="form-select" required>
                <!-- Options will be filled by JavaScript -->
            </select>
        </div>

        <div class="mb-3">
            <label for="regency" class="form-label">Kota/Kabupaten</label>
            <select name="regency" id="regency" class="form-select" required disabled>
                <!-- Options will be filled dynamically -->
            </select>
        </div>
    
        <div class="mb-3">
            <label for="subdistrict" class="form-label">Kecamatan</label>
            <select name="subdistrict" id="subdistrict" class="form-select" required disabled>
                <!-- Options will be filled dynamically -->
            </select>
        </div>
    
        <div class="mb-3">
            <label for="village" class="form-label">Kelurahan</label>
            <select name="village" id="village" class="form-select" required disabled>
                <!-- Options will be filled dynamically -->
            </select>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Pengaduan</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Gambar (optional)</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
    
        <div class="mb-3 form-check">
            <input type="checkbox" name="statement" id="statement" class="form-check-input" value="1" {{ old('statement') ? 'checked' : '' }}>
            <label for="statement" class="form-check-label">Apakah Anda menyatakan ini?</label>
        </div>
    
        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    </form>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function populateSelect(url, selectId, defaultText, onSelectLoad) {
      fetch(url)
        .then(response => response.json())
        .then(data => {
          const select = document.getElementById(selectId);
          select.innerHTML = `<option value="" disabled selected>${defaultText}</option>`;
          data.forEach(item => {
            select.innerHTML += `<option value="${item.name}" data-id="${item.id}">${item.name}</option>`;
          });
          if (onSelectLoad) onSelectLoad(select);
        })
        .catch(error => console.error(`Error fetching ${selectId}:`, error));
    }

    document.getElementById('province').addEventListener('change', function() {
      const provinceId = this.options[this.selectedIndex].getAttribute('data-id');
      populateSelect(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`, 'regency', 'Pilih Kota/Kabupaten', (select) => select.disabled = false);
    });

    document.getElementById('regency').addEventListener('change', function() {
      const regencyId = this.options[this.selectedIndex].getAttribute('data-id');
      populateSelect(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`, 'subdistrict', 'Pilih Kecamatan', (select) => select.disabled = false);
    });

    document.getElementById('subdistrict').addEventListener('change', function() {
      const subdistrictId = this.options[this.selectedIndex].getAttribute('data-id');
      populateSelect(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${subdistrictId}.json`, 'village', 'Pilih Kelurahan', (select) => select.disabled = false);
    });

    populateSelect('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', 'province', 'Pilih Provinsi');
  </script>
</body>
</html>
