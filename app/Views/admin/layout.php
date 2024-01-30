<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $page_title ?> | CBT Polinela</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />
    <link href="/assets/datatable/datatables.min.css" rel="stylesheet">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/admin" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="/assets/images/logo.png" alt="" width="35">
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">CBT Polinela</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z" fill="currentColor" fill-opacity="0.6" />
                            <path d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z" fill="currentColor" fill-opacity="0.38" />
                        </svg>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-item <?php if (uri_string() == 'admin') echo 'active'; ?>">
                        <a href="/admin" class="menu-link text-success">
                            <i class="menu-icon tf-icons  mdi mdi-view-dashboard-outline"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/jurusan' || uri_string() == 'admin/prodi' || uri_string() == 'admin/thnajaran') echo 'active open'; ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-cog"></i>
                            <div>Manage Akademik</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?php if (uri_string() == 'admin/jurusan') echo 'active'; ?>">
                                <a href="/admin/jurusan" class="menu-link">
                                    <div>Jurusan</div>
                                </a>
                            </li>
                            <li class="menu-item <?php if (uri_string() == 'admin/prodi') echo 'active'; ?>">
                                <a href="/admin/prodi" class="menu-link">
                                    <div>Program Studi</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/dosen') echo 'active'; ?>">
                        <a href="/admin/dosen" class="menu-link text-info">
                            <i class="menu-icon tf-icons  mdi mdi-account-outline"></i>
                            <div>Dosen</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/kelas' || uri_string() == 'admin/sesi') echo 'active open'; ?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                            <div>Manage Kelas</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item <?php if (uri_string() == 'admin/kelas') echo 'active'; ?>">
                                <a href="/admin/kelas" class="menu-link">
                                    <div>Kelas</div>
                                </a>
                            </li>
                            <li class="menu-item <?php if (uri_string() == 'admin/sesi') echo 'active'; ?>">
                                <a href="/admin/sesi" class="menu-link">
                                    <div>Sesi</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/matkul') echo 'active'; ?>">
                        <a href="/admin/matkul" class="menu-link text-warning">
                            <i class="menu-icon tf-icons  mdi mdi-text-box-outline"></i>
                            <div>Mata Kuliah</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/mahasiswa') echo 'active'; ?>">
                        <a href="/admin/mahasiswa" class="menu-link text-danger">
                            <i class="menu-icon tf-icons  mdi mdi-account-group-outline"></i>
                            <div>Mahasiswa</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/exam' || uri_string() == 'admin/question/10') echo 'active'; ?>">
                        <a href="/admin/exam" class="menu-link text-danger">
                            <i class="menu-icon tf-icons mdi mdi-book-outline"></i>
                            <div>Exam</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/user') echo 'active'; ?>">
                        <a href="/admin/user" class="menu-link text-primary">
                            <i class="menu-icon mdi mdi-shield-account-outline"></i>
                            <div>Administrator</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/userAkademik') echo 'active'; ?>">
                        <a href="/admin/userAkademik" class="menu-link text-info">
                            <i class="menu-icon mdi mdi-school-outline"></i>
                            <div>Akun Akademik</div>
                        </a>
                    </li>

                    <li class="menu-item <?php if (uri_string() == 'admin/database') echo 'active'; ?>">
                        <a href="/admin/database" class="menu-link text-warning">
                            <i class="menu-icon mdi mdi-database-arrow-down-outline"></i>
                            <div>Download Database</div>
                        </a>
                    </li>


                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="mdi mdi-menu mdi-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- Style Switcher -->
                            <li class="nav-item me-1 me-xl-0">
                                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon style-switcher-toggle hide-arrow" href="javascript:void(0);">
                                    <i class="mdi mdi-24px"></i>
                                </a>
                            </li>
                            <!--/ Style Switcher -->

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="/assets/images/user/<?= session('foto') ?>" class="w-px-40 h-auto rounded-circle" width="30px" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar">
                                                        <img src="/assets/images/user/<?= session('foto') ?>" alt class="w-px-40 h-auto rounded-circle" width="70px" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?= session('nama') ?></span>
                                                    <small class="text-muted"><?= session('role') ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/admin/myProfile/<?= session('id_user') ?>">
                                            <i class="mdi mdi-account-outline me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/login/logout">
                                            <i class="mdi mdi-logout me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper d-none">
                        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
                        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?= $this->renderSection('content') ?>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , <a href="https://polinela.ac.id/" target="_blank" class="footer-link fw-medium text-primary">POLITEKNIK NAGERI LAMPUNG</a>
                                </div>
                                <div>
                                    Page rendered in <?= number_format((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), 2); ?> seconds.
                                </div>
                                <div>
                                    CBT POLINELA Version 1.0.0
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- build:js assets/vendor/js/core.js -->
    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/libs/popper/popper.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/datatable/datatables.min.js"></script>
    <script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/charts-apex.js"></script>

    <!-- Page JS -->
    <!-- <script src="/assets/js/tables-datatables-basic.js"></script> -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table1, #table2, #table3').DataTable({
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
        const searchInput = $('input[name="keyword"]');
        const kelasSelect = $('#kelas');

        const table = $('#tables').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/admin/searchMahasiswa",
                "type": "POST",
                "data": function(d) {
                    d.keyword = searchInput.val().trim();
                    d.kelas = kelasSelect.val();
                },
                "dataSrc": function(json) {
                    console.log("Debug Message:", json.debug); // Menampilkan pesan debug di console
                    return json.data;
                }
            },
            "columns": [{
                    "data": null,
                    "title": "No",
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": "foto",
                    "title": "Foto",
                    "render": function(data) {
                        return `<img src="/assets/images/mahasiswa/${data}" alt="Foto Mahasiswa" width="70px" />`;
                    },
                    "searchable": false,
                    "orderable": false
                },
                {
                    "data": null,
                    "title": "NPM & Nama",
                    "render": function(data, type, row) {
                        return '<b>NPM : </b>' + row.npm + '<br>' + '<b>Nama : </b>' + row.nama;
                    }
                },
                {
                    "data": "sex",
                    "title": "Sex"
                },
                {
                    "data": "tgl_lahir",
                    "title": "Tempat, Tanggal Lahir",
                    "render": function(data, type, row) {
                        return `${row.tempat_lahir}, ${formatTanggalIndonesia(data)}`;
                    }
                },
                {
                    "data": null,
                    "title": "Keterangan",
                    "render": function(data, type, row) {
                        return `<span style="font-size: 13px;"><b>Kelas : </b> ${row.nama_kelas} | <b>Angkatan : </b> ${row.angkatan} <br> 
                <b>Prodi : </b>${row.nama_prodi}</span>`;
                    }
                },
                {
                    "data": "email",
                    "title": "Email"
                },
                {
                    "data": null,
                    "title": "Action",
                    "render": function(data, type, row) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-update" data-mahasiswa-id="${row.id_mahasiswa}">
                                <i class="mdi mdi-grease-pencil text-sm me-2"></i>
                            </button>
                            <a class="btn btn-danger" onclick="confirmDeleteMahasiswa('${row.id_mahasiswa}')">
                                <i class="mdi mdi-delete text-sm me-2"></i>
                            </a>
                        </div>
                    `;
                    },
                    "searchable": false,
                    "orderable": false
                }
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
            }
        });

        // Event listener untuk perubahan input filter
        searchInput.add(kelasSelect).on('input change', function() {
            table.ajax.reload(null, false); // Reload data tanpa reset pagination
        });;

        $(document).ready(function() {
            $('#tables').on('click', '.btn-update', function() {
                var idMahasiswa = $(this).data('mahasiswa-id');
                console.log("Tombol update ditekan untuk Mahasiswa ID: " + idMahasiswa); // Debugging

                $.ajax({
                    url: '/admin/getMahasiswaData/' + idMahasiswa,
                    type: 'GET',
                    success: function(data) {
                        $('#modalUpdate .modal-content').html(data);
                        $('#modalUpdate').modal('show');
                    },
                    error: function(error) {
                        console.error("Error loading data: ", error);
                    }
                });
            });
        });
    </script>

    <script>
        function formatTanggalIndonesia(tanggal) {
            if (!tanggal || isNaN(Date.parse(tanggal))) {
                return 'Tanggal tidak valid';
            }
            const tanggalLahir = new Date(tanggal);
            const formatTanggalIndonesia = new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }).format(tanggalLahir);

            return formatTanggalIndonesia;
        }
    </script>

    <script>
        function confirmDeleteMahasiswa(id_mahasiswa) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Setelah dihapus, data Anda akan benar-benar hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus data!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/admin/mahasiswaDelete/" + id_mahasiswa;
                } else {
                    Swal.fire('Data tidak jadi dihapus!', '', 'info');
                }
            });
        }
    </script>

    <script>
        var input = document.getElementById('upload-file');
        var preview = document.getElementById('preview');

        input.addEventListener('change', function() {
            var file = input.files[0];

            if (file) {
                var objectURL = URL.createObjectURL(file);
                preview.src = objectURL;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    </script>

    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                title: "Informasi",
                text: "<?= session()->getFlashdata('success') ?>",
                icon: "success",
                showCancelButton: false,
                confirmButtonText: "OK",
            });
        </script>
    <?php elseif (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                title: "Error",
                text: "<?= session()->getFlashdata('error') ?>",
                icon: "error",
                showCancelButton: false,
                confirmButtonText: "OK",
            });
        </script>
    <?php endif; ?>

    <script type="text/javascript">
        const updateUrl = '/UpdateStatusExam/updateStatus';

        function updateExamStatus() {
            fetch(updateUrl)
                .then(response => {
                    if (!response.ok) {
                        console.error('Error updating exam status:', response.statusText);
                    } else {
                        console.log('Exam status updated successfully');
                    }
                })
                .catch(error => {
                    console.error('Network error:', error);
                });
        }
        setInterval(updateExamStatus, 1000);
    </script>
    

</body>

</html>