<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $page_title; ?> | CBT-POLINELA</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- endinject -->

    <link href="/assets/datatable/datatables.min.css" rel="stylesheet">

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/logo.png" />


</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.html"><img src="assets/images/logo.svg" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="assets/images/faces/face15.jpg" alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                                <span>Gold Member</span>
                            </div>
                        </div>
                        <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-settings text-primary"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-onepassword  text-info"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-calendar-today text-success"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="admin/dashboard">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="admin/dosen">
                        <span class="menu-icon">
                            <i class="mdi mdi-account"></i>
                        </span>
                        <span class="menu-title">Dosen</span>
                    </a>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#kelas" aria-expanded="false" aria-controls="kelas">
                        <span class="menu-icon">
                            <i class="mdi mdi-home"></i>
                        </span>
                        <span class="menu-title">Kelas</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="kelas">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="/kelas">Kelas</a></li>
                            <li class="nav-item"> <a class="nav-link" href="/sesi">Sesi</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="/matkul">
                        <span class="menu-icon">
                            <i class="mdi mdi-library-books"></i>
                        </span>
                        <span class="menu-title">Mata Kuliah</span>
                    </a>
                </li>
                
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#exam" aria-expanded="false" aria-controls="exam">
                        <span class="menu-icon">
                            <i class="mdi mdi-file-check"></i>
                        </span>
                        <span class="menu-title">Exam</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="exam">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="/createExam">Buat Exam</a></li>
                            <li class="nav-item"> <a class="nav-link" href="/viewExam">Lihat Exam</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item menu-items">
                    <a class="nav-link" href="/user">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-key"></i>
                        </span>
                        <span class="menu-title">Akun Pengguna</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100 text-right">
                        <div class="col-12">
                            <span class="mb-0 d-inline">Aplikasi CBT Politeknik Negeri Lampung </span>
                            <span class="ml-2 badge badge-info" id="tanggal"></span>
                            <span class="ml-2 badge badge-info">
                                <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span>
                            </span>
                        </div>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Profile</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-settings text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Settings</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">Advanced settings</p>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <?= $this->renderSection('content') ?>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>

    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/datatable/jquery-3.5.1.min.js"></script>

    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->

    <!-- End plugin js for this page -->
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <!-- inject:js -->
    <!-- <script src="/assets/js/off-canvas.js"></script> -->
    <script src="/assets/js/file-upload.js"></script>
    <!-- <script src="/assets/js/hoverable-collapse.js"></script> -->
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <!-- <script src="/assets/js/todolist.js"></script> -->
    <script src="/assets/datatable/datatables.min.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- End custom js for this page -->

    <!-- script untuk memanggil library datatables-->
    <script type="text/javascript">
        $(document).ready(function() {
            // Konfigurasi untuk Tabel dan Tabel 2
            $('#table').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    searchPlaceholder: "Masukkan kata kunci",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    infoEmpty: "Tidak ada data yang tersedia",
                    infoFiltered: "(disaring dari total _MAX_ entri)",
                    zeroRecords: "Tidak ada data yang cocok",
                }
            });
        });
    </script>

    <script>
        function updateClock() {
            const jamElement = document.getElementById('jam');
            const menitElement = document.getElementById('menit');
            const detikElement = document.getElementById('detik');
            const tanggalElement = document.getElementById('tanggal');

            const now = new Date();
            const jam = String(now.getHours()).padStart(2, '0'); // Tambahkan '0' jika jam kurang dari 10
            const menit = String(now.getMinutes()).padStart(2, '0'); // Tambahkan '0' jika menit kurang dari 10
            const detik = String(now.getSeconds()).padStart(2, '0'); // Tambahkan '0' jika detik kurang dari 10
            const tanggal = now.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: '2-digit'
            });

            jamElement.textContent = jam;
            menitElement.textContent = menit;
            detikElement.textContent = detik;
            tanggalElement.textContent = tanggal;

            setTimeout(updateClock, 1000); // Perbarui setiap 1 detik
        }

        updateClock(); // Panggil fungsi pertama kali
    </script>


</body>

</html>