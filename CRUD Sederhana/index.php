<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Absen Mahasiswa Paralel F</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        .form-validation-error {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }
    </style>
</head>

<body>
  <!-- awal container -->
    <div class="container">
        <h3 class="text-center">Form Absen Mahasiswa</h3>
        <h3 class="text-center">Paralel F</h3>

        <!-- awal row -->
        <div class="row">
          <!-- awal col -->
          <div class="col-md-8 mx-auto">
            <!-- awal card -->
            <div class="card">
                <div class="card-header bg-info text-light">
                    Form Input Data Mahasiswa
                </div>
                <div class="card-body">
                    <!-- Awal Form -->
                    <form method="POST" id="absenForm">
                        <div class="mb-3">
                            <label class="form-label">NPM</label>
                            <input type="text" name="npmmhs" class="form-control" placeholder="Masukkan NPM mahasiswa">
                            <div class="form-validation-error" id="npm-error"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="namamhs" class="form-control" placeholder="Masukkan nama lengkap mahasiswa">
                            <div class="form-validation-error" id="nama-error"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alasan</label>
                            <textarea type="text" name="alasanmhs" class="form-control" placeholder="Masukkan alasan yang logis!" rows="3"></textarea>
                            <div class="form-validation-error" id="alasan-error"></div>
                        </div>

                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label">Tanggal Absen</label>
                            <input type="date" name="tanggal" class="form-control" placeholder="Masukkan tanggal" min="" id="tanggalInput">
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Waktu Saat Ini</label>
                            <div id="currentTime" class="form-control bg-light">00:00:00</div>
                          </div>
                        </div>

                        <script>
                          // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
                          const today = new Date().toISOString().split('T')[0];
                          
                          // Mengatur atribut min ke tanggal hari ini
                          document.getElementById('tanggalInput').setAttribute('min', today);

                          // Fungsi untuk menampilkan waktu real-time
                          function updateClock() {
                            const now = new Date();
                            const hours = String(now.getHours()).padStart(2, '0');
                            const minutes = String(now.getMinutes()).padStart(2, '0');
                            const seconds = String(now.getSeconds()).padStart(2, '0');
                            
                            document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
                            
                            // Update setiap 1 detik
                            setTimeout(updateClock, 1000);
                          }
                          
                          // Jalankan fungsi waktu saat halaman dimuat
                          updateClock();
                        </script>

                        <div class="text-center">
                          <hr>
                          <button class="btn btn-primary"name="btnsimpan" type="submit">Simpan</button>
                          <button class="btn btn-danger"name="btnclear" type="reset">Kosongkan</button>
                        </div>
                    </form>
                    <!-- Akhir Form -->
                </div>
                <div class="card-footer bg-info">
                    
                </div>
            </div>
            <!-- akhir card -->
          </div>
          <!-- akhir col -->
        </div>
        <!-- akhir row -->
        
        <!-- awal card -->
        <div class="card mt-3 mb-5">
          <div class="card-header bg-info text-light">
              Data Absen Mahasiswa
          </div>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="text-center">
                      <th>No</th>
                      <th>NPM</th>
                      <th>Nama Mahasiswa</th>
                      <th>Tanggal Absen</th>
                      <th>Waktu Absen</th>
                      <th>Alasan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="tabelAbsen">
                    <!-- Data absen akan ditampilkan di sini -->
                  </tbody>
                </table>
              </div>
          </div>
          <div class="card-footer bg-info">
                    
          </div>
        </div>
        <!-- akhir card -->

    </div>
    <!-- akhir container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>