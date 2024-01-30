<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> Unduh Database</h5>

<div class="card">
    <div class="card-header">
        <span class="badge badge-rounded bg-primary">Informasi :</span>
        <li>Halaman ini merupakan untuk mengunduh database dari cloud</li>
        <li>Sebelum mengunduh harap untuk mengkonfirmasi terlebih dahulu ke dosen apakah semua sudah menginputkan data ujian</li>
        <li>Jika sudah mengunduh database harap import ke database lokal server <a href="http://192.168.43.156:8080" target="_blank">Buka database lokal</a></li>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-warning" href="/admin/exportDatabase">Download Database Cloud</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-success" href="/assets/file/cbt-polinela-tb_exam.sql" download="cbt-polinela-tb_exam.sql">Download Database</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>