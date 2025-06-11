<?php
session_start();
// Pengecekan session - hanya satu kali dan konsisten
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

include "koneksi.php";
$db = new database();

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = $db->koneksi->query($query);
$user = $result->fetch_assoc();

// Hitung jumlah siswa
$query_siswa = "SELECT COUNT(*) as total FROM siswa";
$result_siswa = $db->koneksi->query($query_siswa);
$total_siswa = $result_siswa->fetch_assoc()['total'];

// Hitung jumlah jurusan
$query_jurusan = "SELECT COUNT(*) as total FROM jurusan";
$result_jurusan = $db->koneksi->query($query_jurusan);
$total_jurusan = $result_jurusan->fetch_assoc()['total'];

// Hitung jumlah agama
$query_agama = "SELECT COUNT(*) as total FROM agama";
$result_agama = $db->koneksi->query($query_agama);
$total_agama = $result_agama->fetch_assoc()['total'];

// Hitung jumlah users
$query_users = "SELECT COUNT(*) as total FROM users";
$result_users = $db->koneksi->query($query_users);
$total_users = $result_users->fetch_assoc()['total'];

// Ambil data agama untuk pie chart
$query_agama_data = "SELECT nama_agama, COUNT(*) as jumlah FROM siswa JOIN agama ON siswa.agama = agama.id_agama GROUP BY nama_agama";
$result_agama_data = $db->koneksi->query($query_agama_data);
$agama_data = [];
while ($row = $result_agama_data->fetch_assoc()) {
    $agama_data[] = $row;
}
// Ambil data jenis kelamin untuk pie chart
$query_siswa = "SELECT jeniskelamin, COUNT(*) as jumlah FROM siswa GROUP BY jeniskelamin";
$result_siswa = $db->koneksi->query($query_siswa);
$gender_data = [];
$gender_labels = [];
$gender_colors = [];
while ($row = $result_siswa->fetch_assoc()) {
    $gender_data[] = $row['jumlah'];
    $gender_labels[] = $row['jeniskelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';
    $gender_colors[] = $row['jeniskelamin'] == 'L' ? '#36A2EB' : '#FF6384'; // Warna untuk laki-laki dan perempuan
}
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    <link rel="stylesheet" href="../dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
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
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="../dist/assets/img/user2-160x160.jpg"
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
                    <a href="../logout.php" class="btn btn-outline-danger w-100 ms-1">
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
      <?php include "sidebar.php"; ?>
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Dashboard Siswa</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
              <!--begin::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                      <h3><?php echo $total_jurusan; ?></h3>
                      <p>Jurusan</p>
                  </div>
                  <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                      <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                      <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                  </svg>
                  <a href="datajurusan.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                      More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
              <!--end::Col-->
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                  <div class="inner">
                      <h3><?php echo $total_agama; ?></h3>
                      <p>Agama</p>
                  </div>
                  <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                  </svg>
                  <a href="dataagama.php" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                      More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 3-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
        <div class="row w-100 ms-0 mt-4">
          <!-- Pie Chart untuk Agama -->
          <div class="col-md-6 mb-4">
              <div class="card shadow-sm h-100">
                  <div class="card-header bg-primary text-white">
                      <h5 class="card-title mb-0">Statistik Agama Siswa</h5>
                  </div>
                  <div class="card-body d-flex flex-column">
                      <div class="chart-container" style="position: relative; height: 250px; width: 100%">
                          <canvas id="agamaPieChart"></canvas>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <script>
          // Fungsi untuk membuat pie chart yang lebih rapi
          function createPieChart(elementId, labels, data, colors) {
              const ctx = document.getElementById(elementId).getContext('2d');
              return new Chart(ctx, {
                  type: 'pie',
                  data: {
                      labels: labels,
                      datasets: [{
                          data: data,
                          backgroundColor: colors,
                          borderWidth: 1,
                          borderColor: '#fff'
                      }]
                  },
                  options: {
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                          legend: {
                              position: 'right',
                              labels: {
                                  boxWidth: 12,
                                  padding: 12,
                                  font: {
                                      size: 12
                                  },
                                  usePointStyle: true
                              }
                          },
                          tooltip: {
                              enabled: true,
                              callbacks: {
                                  label: function(context) {
                                      const label = context.label || '';
                                      const value = context.raw || 0;
                                      const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                      const percentage = Math.round((value / total) * 100);
                                      return `${label}: ${value} (${percentage}%)`;
                                  }
                              }
                          }
                      },
                      cutout: '60%', // Membuat donut chart
                      animation: {
                          animateScale: true,
                          animateRotate: true
                      }
                  }
              });
          }

          // Membuat chart agama
          createPieChart(
              'agamaPieChart',
              <?= json_encode(array_column($agama_data, 'nama_agama')); ?>,
              <?= json_encode(array_column($agama_data, 'jumlah')); ?>,
              ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796']
          );

          // Membuat chart jenis kelamin
          createPieChart(
              'genderPieChart',
              <?= json_encode($gender_labels); ?>,
              <?= json_encode($gender_data); ?>,
              <?= json_encode($gender_colors); ?>
          );
      </script>
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
    <script src="../dist/js/adminlte.js"></script>
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
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>

    <script>
    // Fungsi untuk membuat pie chart yang lebih modern dan menarik
      function createEnhancedPieChart(elementId, labels, data, colors, title) {
          const ctx = document.getElementById(elementId).getContext('2d');
          
          // Gradient colors untuk efek yang lebih menarik
          const gradientColors = colors.map(color => {
              const gradient = ctx.createLinearGradient(0, 0, 0, 400);
              gradient.addColorStop(0, color);
              gradient.addColorStop(1, color + '80'); // Add transparency
              return gradient;
          });

          return new Chart(ctx, {
              type: 'doughnut', // Menggunakan doughnut untuk tampilan yang lebih modern
              data: {
                  labels: labels,
                  datasets: [{
                      data: data,
                      backgroundColor: colors,
                      borderWidth: 3,
                      borderColor: '#ffffff',
                      hoverBorderWidth: 5,
                      hoverBorderColor: '#ffffff',
                      hoverOffset: 15, // Efek hover yang lebih dramatic
                      cutout: '65%' // Membuat hole di tengah lebih besar
                  }]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  layout: {
                      padding: {
                          top: 20,
                          bottom: 20,
                          left: 20,
                          right: 20
                      }
                  },
                  plugins: {
                      legend: {
                          position: 'bottom',
                          labels: {
                              boxWidth: 15,
                              boxHeight: 15,
                              padding: 20,
                              font: {
                                  size: 13,
                                  weight: '500',
                                  family: 'Source Sans Pro'
                              },
                              usePointStyle: true,
                              pointStyle: 'circle',
                              color: '#495057'
                          }
                      },
                      tooltip: {
                          enabled: true,
                          backgroundColor: 'rgba(0, 0, 0, 0.8)',
                          titleColor: '#ffffff',
                          bodyColor: '#ffffff',
                          borderColor: '#ffffff',
                          borderWidth: 1,
                          cornerRadius: 8,
                          titleFont: {
                              size: 14,
                              weight: 'bold'
                          },
                          bodyFont: {
                              size: 13
                          },
                          padding: 12,
                          callbacks: {
                              label: function(context) {
                                  const label = context.label || '';
                                  const value = context.raw || 0;
                                  const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                  const percentage = Math.round((value / total) * 100);
                                  return `${label}: ${value} siswa (${percentage}%)`;
                              }
                          }
                      }
                  },
                  animation: {
                      animateScale: true,
                      animateRotate: true,
                      duration: 1500,
                      easing: 'easeInOutQuart'
                  },
                  elements: {
                      arc: {
                          borderWidth: 0
                      }
                  },
                  interaction: {
                      intersect: false,
                      mode: 'index'
                  }
              },
              plugins: [{
                  // Plugin custom untuk menampilkan text di tengah
                  id: 'centerText',
                  afterDraw: function(chart) {
                      const ctx = chart.ctx;
                      const centerX = chart.chartArea.left + (chart.chartArea.right - chart.chartArea.left) / 2;
                      const centerY = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;
                      
                      ctx.save();
                      
                      // Total count
                      const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                      ctx.font = 'bold 24px Source Sans Pro';
                      ctx.fillStyle = '#495057';
                      ctx.textAlign = 'center';
                      ctx.textBaseline = 'middle';
                      ctx.fillText(total, centerX, centerY - 5);
                      
                      // Label
                      ctx.font = '12px Source Sans Pro';
                      ctx.fillStyle = '#6c757d';
                      ctx.fillText('Total Siswa', centerX, centerY + 20);
                      
                      ctx.restore();
                  }
              }]
          });
      }

      // Color palettes yang lebih menarik
      const agamaColors = [
          '#4e73df', // Blue
          '#1cc88a', // Green
          '#36b9cc', // Cyan
          '#f6c23e', // Yellow
          '#e74a3b', // Red
          '#858796', // Gray
          '#5a5c69', // Dark Gray
          '#36459c'  // Dark Blue
      ];

      const genderColors = ['#36A2EB', '#FF6384']; // Blue for Male, Pink for Female

      // Inisialisasi charts setelah DOM loaded
      document.addEventListener('DOMContentLoaded', function() {
          // Chart Agama
          createEnhancedPieChart(
              'agamaPieChart',
              <?= json_encode(array_column($agama_data, 'nama_agama')); ?>,
              <?= json_encode(array_column($agama_data, 'jumlah')); ?>,
              agamaColors,
              'Statistik Agama'
          );

          // Chart Jenis Kelamin
          createEnhancedPieChart(
              'genderPieChart',
              <?= json_encode($gender_labels); ?>,
              <?= json_encode($gender_data); ?>,
              genderColors,
              'Statistik Jenis Kelamin'
          );
      });
  </script>
  
  </body>
  <!--end::Body-->
</html>