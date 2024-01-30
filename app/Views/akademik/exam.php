<?= $this->extend('akademik/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Exam</h5>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title fw-bold">Data Exam</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($dataExam)) : ?>
            <div class="alert alert-danger" role="alert">
                Tidak ada data ujian yang tersedia saat ini.
            </div>
        <?php else : ?>
            <div class="card-deck" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                <?php foreach ($dataExam as $exam) : ?>
                    <?php if ($exam['status'] === 'expired') : ?>
                        <div class="card" style="width: 18rem; flex: 0 0 auto; border: 1px solid #0E8388; margin-bottom: 1rem;">
                            <img src="/assets/images/thumbnail.webp" class="card-img-top" alt="Thumbnail">
                            <div class="card-body">
                                <h5 class="card-title"><?= $exam['nama_exam'] ?></h5>
                                <p class="card-text">
                                    Mata Kuliah: <?= $exam['nama_matkul'] ?><br>
                                    Kelas: <?= $exam['nama_kelas'] ?><br>
                                    Sesi: <?= $exam['nama_sesi'] ?><br>
                                    Waktu: <?= $exam['start_time'] ?> - <?= $exam['end_time'] ?><br>
                                    Tanggal: <?= $exam['tgl_exam'] ?><br>
                                </p>
                                <div class="btn-group">
                                    <a class="btn btn-success" href="/akademik/examViewResult/<?= $exam['id_exam'] ?>">
                                        <i class="mdi mdi-upload-multiple me-1"></i> Lihat Hasil
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="message"></div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Input Data Exam</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/dosen/examAdd" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="nama_exam" id="exampleFormControlInput1" placeholder="Masukan nama kelas" autocomplete="off">
                                    <label>Nama Exam</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_kelas" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option selected>Pilih Kelas</option>
                                        <?php foreach ($dataKelas as $k) : ?>
                                            <option value="<?= $k["id_kelas"] ?>"><?= $k["nama"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="exampleFormControlSelect1">Kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_matkul" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option selected>Pilih Mata Kuliah</option>
                                        <?php foreach ($dataMatkul as $m) : ?>
                                            <option value="<?= $m["id_matkul"] ?>"><?= $m["nama"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="exampleFormControlSelect1">Mata Kuliah</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_sesi" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option selected>Pilih Sesi</option>
                                        <?php foreach ($dataSesi as $s) : ?>
                                            <option value="<?= $s["id_sesi"] ?>"><?= $s["nama_sesi"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="exampleFormControlSelect1">Sesi</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="time" value="" class="form-control" name="start_time" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                    <label>Waktu Mulai</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="time" value="" class="form-control" name="end_time" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                    <label>Waktu Berakhir</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="date" value="" class="form-control" name="tgl_exam" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                    <label>Tanggal Ujian</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $i = 1;
foreach ($dataExam as $row) : ?>
    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate<?= $row['id_exam'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Data Dosen</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/dosen/examUpdate/<?= $row['id_exam'] ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['nama_exam'] ?>" class="form-control" name="nama_exam" id="exampleFormControlInput1" placeholder="Masukan nama kelas" autocomplete="off">
                                        <label>Nama Exam</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select name="id_kelas" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                            <option selected>Pilih Kelas</option>
                                            <?php foreach ($dataKelas as $k) : ?>
                                                <?php if ($row['id_kelas'] == $k["id_kelas"]) : ?>
                                                    <option value="<?= $k["id_kelas"] ?>" selected> <?= $k["nama"] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $k["id_kelas"] ?>"><?= $k["nama"] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="exampleFormControlSelect1">Kelas</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select name="id_matkul" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                            <option selected>Pilih Mata Kuliah</option>
                                            <?php foreach ($dataMatkul as $m) : ?>
                                                <?php if ($row['id_matkul'] == $m["id_matkul"]) : ?>
                                                    <option value="<?= $m["id_matkul"] ?>" selected> <?= $m["nama"] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $m["id_matkul"] ?>"><?= $m["nama"] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="exampleFormControlSelect1">Mata Kuliah</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select name="id_sesi" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                            <option selected>Pilih Sesi</option>
                                            <?php foreach ($dataSesi as $s) : ?>
                                                <?php if ($row['id_sesi'] == $s["id_sesi"]) : ?>
                                                    <option value="<?= $s["id_sesi"] ?>" selected> <?= $s["nama_sesi"] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $s["id_sesi"] ?>"><?= $s["nama_sesi"] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="exampleFormControlSelect1">Sesi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="time" value="<?= $row['start_time'] ?>" class="form-control" name="start_time" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                        <label>Waktu Mulai</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="time" value="<?= $row['end_time'] ?>" class="form-control" name="end_time" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                        <label>Waktu Berakhir</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="date" value="<?= $row['tgl_exam'] ?>" class="form-control" name="tgl_exam" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                        <label>Tanggal Ujian</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Setelah dihapus, data Anda akan benar-benar hilang!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/dosen/examDelete/" + id;
            } else {
                Swal.fire('Data tidak jadi dihapus!', '', 'info');
            }
        });
    }
</script>


<?= $this->endSection() ?>