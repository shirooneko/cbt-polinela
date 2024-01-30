<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Kelas</h5>
<!-- Multilingual -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                Detail Ujian
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody style="font-size: 13px;">
                            <tr>
                                <td><b>Nama Ujian</b></td>
                                <td width="30%"><?= $dataExam['nama_exam'] ?></td>
                                <td><b>Mata Kuliah</b></td>
                                <td><?= $dataExam['nama_matkul'] ?></td>
                            </tr>
                            <tr>
                                <td><b>Kelas</b></td>
                                <td><?= '<b>' . "Kelas" . ':</b> ' . $dataExam['nama_kelas'] . '<br>' . '<b>' . "Sesi" . ':</b> ' . $dataExam['nama_sesi'] ?></td>
                                <td><b>Waktu Pelaksanaan</b></td>
                                <td><?= '<b>' . "Tanggal" . ':</b> ' . formatTanggalIndonesia($dataExam['tgl_exam']) . '<br>' . '<b>' . "Jam" . ':</b> ' . $dataExam['start_time'] . "-" . $dataExam['end_time'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-header">
                Daftar Mahasiswa
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>NPM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Skor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $result) : ?>
                                <tr>
                                    <td><img src="/assets/images/mahasiswa/<?= $result['foto']?>" width="30"></td>
                                    <td><?= $result['npm']; ?></td>
                                    <td><?= $result['nama']; ?></td>
                                    <td><?= $result['total_score']; ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
function formatTanggalIndonesia($tanggal)
{
    if ($tanggal) {
        $tanggalLahir = new DateTime($tanggal);
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        return $formatter->format($tanggalLahir);
    } else {
        return null;
    }
}
?>


<?= $this->endSection() ?>