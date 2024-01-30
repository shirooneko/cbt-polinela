<?= $this->extend('dosen/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> Dashboard</h5>
<div class="row gy-4">
    <!-- Cards with few info -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5>Selamat Datang <b><?= session('nama') ?></b> di aplikasi Computer Based Test Politeknik Negeri Lampung</h5>
            </div>
        </div>
    </div>
    <!--/ Cards with few info -->

    <?= $this->endSection() ?>