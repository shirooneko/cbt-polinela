<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light">Dashboard /</span> Dashboard</h5>
<div class="row gy-4">
    <!-- Cards with few info -->
    <div class="col-lg-4 col-sm-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <a href="/admin/mahasiswa">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="mdi mdi-account mdi-24px"> </i>
                            </div>
                        </a>
                    </div>
                    <div class="card-info">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0"><?= number_format($jumlMahasiswa, 0, ',', '.') ?> Mahasiswa</h4>
                        </div>
                        <small class="text-muted">Mahasiswa</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <a href="/admin/dosen">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="mdi mdi-account-tie mdi-24px"> </i>
                            </div>
                        </a>
                    </div>
                    <div class="card-info">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0"><?= number_format($jumlDosen, 0, ',', '.') ?> Dosen</h4>
                        </div>
                        <small class="text-muted">Dosen</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <a href="/admin/dosen">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="mdi mdi-account-tie mdi-24px"> </i>
                            </div>
                        </a>
                    </div>
                    <div class="card-info">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0"><?= number_format($jumlAkademik, 0, ',', '.') ?> Akademik</h4>
                        </div>
                        <small class="text-muted">Akademik</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <a href="/admin/dosen">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="mdi mdi-account-tie mdi-24px"> </i>
                            </div>
                        </a>
                    </div>
                    <div class="card-info">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0"><?= number_format($jumlAdmin, 0, ',', '.') ?> Administrator</h4>
                        </div>
                        <small class="text-muted">Administrator</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-7">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-label-info rounded">
                            <i class="mdi mdi-file-cog mdi-24px"> </i>
                        </div>
                    </div>
                    <div class="card-info">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0"><?= $totalExam ?> Ujian</h4>
                        </div>
                        <small class="text-muted">
                            <?= $pendingExams['pending'] ?> Tertunda |
                            <?= $publishedExams['publish'] ?> Aktif |
                            <?= $expiredExams['expired'] ?> Selesai
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-sm-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="avatar me-3">
                        <div class="avatar-initial bg-label-warning rounded">
                            <i class="mdi mdi-poll mdi-24px"> </i>
                        </div>
                    </div>
                    <div class="card-info">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-0">Pengguna Aktif</h4>
                        </div>
                        <small class="text-muted">
                            <?= $adminOnline ?> Admin |
                            <?= $dosenOnline ?> Dosen |
                            <?= $mahasiswaOnline ?> Mahasiswa |
                            <?= $akademikOnline ?> akademik
                        </small>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Cards with few info -->

    <!-- Radial bar Chart -->
    <div class="col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Data Mahasiswa Berdasarkan Jenis Kelamin</h5>
            </div>
            <div class="card-body">
                <div id="radialBarChartSex"></div>
            </div>
        </div>
    </div>

    <!-- /Radial bar Chart -->

    <!-- Radial bar Chart -->
    <div class="col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Data Mahasiswa Berdasarkan Program Studi</h5>
            </div>
            <div class="card-body">
                <div id="donutChart"></div>
            </div>
        </div>
    </div>
    <!-- /Radial bar Chart -->

    <?= $this->endSection() ?>