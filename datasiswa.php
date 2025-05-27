<?php
session_start();
include "koneksi.php";
$db = new database();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $db->koneksi->query($query);
$user = $result->fetch_assoc();

// Proses form edit jika ada POST request
if ($_POST && isset($_POST['nisn'])) {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $jurusan = $_POST['jurusan'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama'];
    $nohp = $_POST['nohp'];
    
    // Update data siswa
    $db->update_data_siswa($nisn, $nama, $jeniskelamin, $kelas, $alamat, $nohp, $jurusan, $agama);
    
    // Redirect untuk menghindari double submit
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Simple Tables</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Simple Tables" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="index.php" class="nav-link">Home</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="dist/assets/img/user2-160x160.jpg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline"><?= htmlspecialchars($user['username']) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            
                <li><hr class="dropdown-divider"></li>

                <!-- Menu Footer -->
                <li class="col px-3 pt-2 pb-2">
                  <div class="d-flex justify-content-between">
                    <a href="profile.php" class="btn btn-outline-secondary w-100 me-1">
                      <i class="bi bi-person-circle me-1"></i> Profile
                    </a>
                    <a href="logout.php" class="btn btn-outline-danger w-100 ms-1">
                      <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                  </div>
                </li>
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <?php include "Sidebar.php"; ?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <div class="card-header">
              <h3 class="card-title">Data Siswa</h3>
              <a href="tambahsiswa.php" class="btn btn-primary float-end">
                Tambah Data
              </a>
            </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Data Siswa</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Table Siswa</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Jurusan</th>
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>Agama</th>
                            <th>NO HP</th>
                            <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        foreach ($db->tampil_data_siswa() as $x) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($x['nisn']); ?></td>
                                <td><?= htmlspecialchars($x['nama']); ?></td>
                                <td><?= ($x['jeniskelamin'] == 'P') ? 'Perempuan' : 'Laki-laki'; ?></td>
                                <td><?= htmlspecialchars($x['namajurusan'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($x['kelas']); ?></td>
                                <td><?= htmlspecialchars($x['alamat']); ?></td>
                                <td><?= htmlspecialchars($x['nama_agama'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($x['nohp']); ?></td>
                                <td>
                                    <!-- Tombol Edit (trigger modal) -->
                                    <button class="btn btn-warning btn-sm mb-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit<?= $x['nisn']; ?>">
                                      Edit
                                    </button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit<?= $x['nisn']; ?>" 
                                        data-bs-backdrop="static" 
                                        data-bs-keyboard="false" 
                                        tabindex="-1" 
                                        aria-labelledby="labelEdit<?= $x['nisn']; ?>" 
                                        aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <form action="" method="POST">
                                            <div class="modal-header bg-warning">
                                              <h5 class="modal-title" id="labelEdit<?= $x['nisn']; ?>">Edit Data Siswa</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              <input type="hidden" name="nisn" value="<?= $x['nisn']; ?>">
                                              <div class="mb-3">
                                                <label for="nama<?= $x['nisn']; ?>" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama<?= $x['nisn']; ?>" name="nama" value="<?= htmlspecialchars($x['nama']); ?>" required>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label">Jenis Kelamin</label>
                                                <select name="jeniskelamin" class="form-select">
                                                  <option value="L" <?= $x['jeniskelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                                  <option value="P" <?= $x['jeniskelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                                </select>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label">Jurusan</label>
                                                <select name="jurusan" class="form-select" required>
                                                  <?php foreach ($db->tampil_data_jurusan() as $jur) : ?>
                                                    <option value="<?= $jur['kodejurusan']; ?>" <?= $jur['kodejurusan'] == $x['kodejurusan'] ? 'selected' : ''; ?>>
                                                      <?= htmlspecialchars($jur['namajurusan']); ?>
                                                    </option>
                                                  <?php endforeach; ?>
                                                </select>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label">Kelas</label>
                                                <input type="text" class="form-control" name="kelas" value="<?= htmlspecialchars($x['kelas']); ?>" required>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label">Alamat</label>
                                                <input type="text" class="form-control" name="alamat" value="<?= htmlspecialchars($x['alamat']); ?>">
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label">Agama</label>
                                                <select name="agama" class="form-select" required>
                                                  <?php foreach ($db->tampil_data_agama() as $agm) : ?>
                                                    <option value="<?= $agm['id_agama']; ?>" <?= $agm['id_agama'] == $x['agama'] ? 'selected' : ''; ?>>
                                                      <?= htmlspecialchars($agm['nama_agama']); ?>
                                                    </option>
                                                  <?php endforeach; ?>
                                                </select>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label">No HP</label>
                                                <input type="text" class="form-control" name="nohp" value="<?= htmlspecialchars($x['nohp']); ?>">
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                              <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <!-- Tombol Hapus (trigger modal) -->
                                    <button class="btn btn-danger btn-sm mb-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalHapus<?= $x['nisn']; ?>">
                                      Hapus
                                    </button>
                                    
                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="modalHapus<?= $x['nisn']; ?>" 
                                        data-bs-backdrop="static" 
                                        data-bs-keyboard="false" 
                                        tabindex="-1" 
                                        aria-labelledby="labelHapus<?= $x['nisn']; ?>" 
                                        aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="labelHapus<?= $x['nisn']; ?>">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            <p>Yakin ingin menghapus data siswa ini?</p>
                                            <ul class="list-unstyled">
                                              <li><strong>NISN:</strong> <?= htmlspecialchars($x['nisn']); ?></li>
                                              <li><strong>Nama:</strong> <?= htmlspecialchars($x['nama']); ?></li>
                                              <li><strong>Jenis Kelamin:</strong> <?= ($x['jeniskelamin'] == 'P') ? 'Perempuan' : 'Laki-laki'; ?></li>
                                              <li><strong>Jurusan:</strong> <?= htmlspecialchars($x['namajurusan'] ?? '-'); ?></li>
                                              <li><strong>Kelas:</strong> <?= htmlspecialchars($x['kelas']); ?></li>
                                              <li><strong>Alamat:</strong> <?= htmlspecialchars($x['alamat']); ?></li>
                                              <li><strong>Agama:</strong> <?= htmlspecialchars($x['nama_agama'] ?? '-'); ?></li>
                                              <li><strong>No HP:</strong> <?= htmlspecialchars($x['nohp']); ?></li>
                                            </ul>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="hapus_data.php?idsiswa=<?= $x['idsiswa']; ?>" class="btn btn-danger">Hapus</a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        } ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>  
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2024&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>