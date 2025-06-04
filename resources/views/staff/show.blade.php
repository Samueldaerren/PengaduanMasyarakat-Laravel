<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8"/>
   <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
   <title>Report Page</title>
   <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
   <!-- SweetAlert2 CSS -->
   <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
   <style>
      /* Style untuk Timeline */
      .timeline {
         position: relative;
         padding: 20px 0;
         list-style: none;
         margin: 0;
      }

      .timeline::before {
         content: '';
         position: absolute;
         width: 4px;
         background-color: #007bff;
         left: 50%;
         top: 0;
         bottom: 0;
         margin-left: -2px;
      }

      .timeline-item {
         position: relative;
         margin-bottom: 30px;
         padding-left: 40px;
         display: flex;
         align-items: center;
         cursor: pointer;
      }

      .timeline-item .timeline-icon {
         position: absolute;
         left: 50%;
         transform: translateX(-50%);
         background-color: #007bff;
         color: white;
         border-radius: 50%;
         width: 30px;
         height: 30px;
         line-height: 30px;
         text-align: center;
         font-size: 16px;
         font-weight: bold;
         box-shadow: 0 0 0 3px #fff;
      }

      .timeline-item .timeline-content {
         position: relative;
         background: #f8f9fa;
         padding: 15px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0,0,0,.1);
         width: 80%;
      }

      .timeline-item .timeline-content p {
         margin: 0;
      }

      .timeline-item .timeline-date {
         font-size: 12px;
         color: #777;
         margin-top: 5px;
      }

      /* Style untuk progress input dan button */
      #progress-input {
         display: none;
      }
   </style>
</head>
<body>
   <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
         <a class="navbar-brand" href="{{ route('staff.dashboard') }}">
            <img alt="Logo" class="d-inline-block align-text-top" height="30" src="https://storage.googleapis.com/a1aa/image/ngParwGe9ej4fItHeJBJLcyGha0ySw0WHrLtbPfNrbKevpHfJA.jpg" width="30"/>
            Pengajuan
         </a>
         <button class="btn btn-outline-secondary" type="button">
            Logout
         </button>
      </div>
   </nav>
   <div class="container mt-4">
      <div class="row">
         <div class="col-md-8">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">{{ $report->user->email }}</h5>
                  <p class="card-text">
                     <small class="text-muted">
                        {{ \Carbon\Carbon::parse($report->created_at)->format('d F Y') }} | Status tanggapan:
                     </small>
                     <span class="badge bg-success">
                        {{ $report->responses->last()->response_status ?? 'ON PROCESS'  }}
                     </span>
                  </p>
                  <h6 class="card-subtitle mb-2 text-muted">
                     {{ $report->village }}, {{ $report->subdistrict }}, {{ $report->regency }}, {{ $report->province }}
                  </h6>
                  <p class="card-text">
                     {{ $report->description }}
                  </p>
                  @if($report->image)
                     <img alt="Report Image" class="img-fluid" height="200" src="{{ asset('storage/images/' . basename($report->image)) }}" width="300"/>
                  @else
                     <p>No image available</p>
                  @endif
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="card">
               <div class="card-body" id="progress-section">
                  <p id="progress-info">Informasi terkait progres pelaksanaan/penyelesaian aduan</p>

                  <!-- Timeline container -->
                  <ul id="timeline" class="timeline">
                     <!-- Existing progress items -->
                     @foreach($report->responses as $response)
                        <li class="timeline-item">
                           <div class="timeline-icon">{{ $loop->iteration }}</div>
                           <div class="timeline-content">
                              <p>{{ $response->response_status }}</p>
                              <p class="timeline-date">{{ \Carbon\Carbon::parse($response->created_at)->format('d F Y') }}</p>
                           </div>
                        </li>
                     @endforeach
                  </ul>

                  <!-- Input for adding progress (hidden initially) -->
                  <div id="progress-input" class="mb-3">
                     <textarea id="progress-text" class="form-control" rows="3" placeholder="Masukkan tanggapan..."></textarea>
                     <button id="cancel-button" class="btn btn-secondary w-100 mt-2">Batal</button>
                     <button id="submit-button" class="btn btn-primary w-100 mt-2">Buat</button>
                  </div>

                  <!-- Buttons to trigger input and show progress -->
                  <button id="add-progress-button" class="btn btn-primary w-100 mb-2">Tambah Progress</button>
                  <button class="btn btn-success w-100 mb-2">Nyatakan Selesai</button>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3i5q5Y5izVhtI9X4" crossorigin="anonymous"></script>

   <!-- SweetAlert2 JS -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

   <script>
      document.getElementById('add-progress-button').addEventListener('click', function() {
         // Hide the progress info and show input field
         document.getElementById('progress-info').style.display = 'none';
         document.getElementById('progress-input').style.display = 'block';
      });

      document.getElementById('cancel-button').addEventListener('click', function() {
         // Reset the input and hide the input field
         document.getElementById('progress-info').style.display = 'block';
         document.getElementById('progress-input').style.display = 'none';
      });

      document.getElementById('submit-button').addEventListener('click', function() {
         // Get the progress text and date
         var progressText = document.getElementById('progress-text').value;
         var currentDate = new Date().toLocaleDateString();

         // Create new timeline entry
         var timelineItem = document.createElement('li');
         timelineItem.classList.add('timeline-item');

         var timelineIcon = document.createElement('div');
         timelineIcon.classList.add('timeline-icon');
         timelineIcon.textContent = document.getElementsByClassName('timeline-item').length + 1;

         var timelineContent = document.createElement('div');
         timelineContent.classList.add('timeline-content');

         var progressParagraph = document.createElement('p');
         progressParagraph.textContent = progressText;

         var timelineDate = document.createElement('p');
         timelineDate.classList.add('timeline-date');
         timelineDate.textContent = currentDate;

         timelineContent.appendChild(progressParagraph);
         timelineContent.appendChild(timelineDate);

         timelineItem.appendChild(timelineIcon);
         timelineItem.appendChild(timelineContent);

         // Append new progress to timeline
         document.getElementById('timeline').appendChild(timelineItem);

         // Hide input and show the updated progress section
         document.getElementById('progress-info').style.display = 'none';
         document.getElementById('progress-input').style.display = 'none';
      });

      // Event listener for deleting progress when a timeline card is clicked
      document.getElementById('timeline').addEventListener('click', function(event) {
         var timelineItem = event.target.closest('.timeline-item');
         if (timelineItem) {
            // Menggunakan SweetAlert2 untuk konfirmasi
            Swal.fire({
               title: 'Apakah Anda yakin ingin menghapus progress ini?',
               text: 'Perubahan ini tidak dapat dibatalkan.',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonText: 'Hapus',
               cancelButtonText: 'Batal',
               reverseButtons: true
            }).then((result) => {
               if (result.isConfirmed) {
                  timelineItem.remove(); // Hapus item timeline jika pengguna mengonfirmasi
                  Swal.fire('Terhapus!', 'Progress telah dihapus.', 'success');
               } else if (result.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire('Dibatalkan', 'Proses penghapusan dibatalkan.', 'info');
               }
            });
         }
      });
   </script>
</body>
</html>
