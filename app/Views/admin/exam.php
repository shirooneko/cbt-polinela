<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php helper('custom_helper'); ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Exam</h5>
<div class="card">
    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-header">Data Exam</h5>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalAdd">
                            Tambah Data
                        </button>
                    </div>
                </div>
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-examPending" aria-controls="navs-pills-justified-home" aria-selected="true">
                            <i class="tf-icons mdi mdi-archive-clock-outline me-1"></i> Pending
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1"><?= $exam_count['pending'] ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-examActive" aria-controls="navs-pills-justified-home" aria-selected="false">
                            <i class="tf-icons mdi mdi-archive-check-outline me-1"></i> Aktif
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1"><?= $exam_count['publish'] ?></span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-examExpired" aria-controls="navs-pills-justified-profile" aria-selected="false">
                            <i class="tf-icons mdi mdi-archive-eye-outline me-1"></i> Selesai
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1"><?= $exam_count['expired'] ?></span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-pills-justified-examPending" role="tabpanel">
                    <div class="card-body table-responsive">
                        <table class="table mt-5" width="100%" id="table1">
                            <thead class="table-dark">
                                <tr>
                                    <th> No </th>
                                    <th width="15%"> Nama </th>
                                    <th width="15%"> Nama Mata Kuliah </th>
                                    <th> Kelas dan Sesi</th>
                                    <th> Waktu Ujian </th>
                                    <th> Status </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px;">
                                <?php $i = 1;
                                foreach ($dataExamPending as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['nama_exam'] ?></td>
                                        <td><?= $row['nama_matkul'] ?></td>
                                        <td><?= '<b>' . "Kelas" . ':</b> ' . $row['nama_kelas'] . '<br>' . '<b>' . "Sesi" . ':</b> ' . $row['nama_sesi'] ?></td>
                                        <td>
                                            <?= '<b>Tanggal:</b> ' . formatTanggalIndonesia($row['tgl_exam']) . '<br><b>Jam:</b> ' . $row['start_time'] . '-' . $row['end_time'] ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] === 'pending') : ?>
                                                <span class="badge bg-label-primary"><?= $row['status'] ?></span>
                                            <?php elseif ($row['status'] === 'publish') : ?>
                                                <span class="badge bg-label-success"><?= $row['status'] ?></span>
                                            <?php elseif ($row['status'] === 'expired') : ?>
                                                <span class="badge bg-label-danger"><?= $row['status'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="/admin/publish/<?= $row['id_exam'] ?>" class="dropdown-item <?= ($row['status'] == 'publish') ? 'disabled' : ''; ?>">
                                                        <i class="mdi mdi-upload-multiple me-1"></i> Publish Exam
                                                    </a>
                                                    <a href="/admin/question/<?= $row['id_exam'] ?>" class="dropdown-item">
                                                        <i class="mdi mdi-file-document-arrow-right-outline me-1"></i> Manage Soal
                                                    </a>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_exam']; ?>">
                                                        <i class="mdi mdi-pencil-outline me-1"></i> Update Exam
                                                    </button>
                                                    <button type="button" class="dropdown-item" onclick="confirmDelete('<?= $row['id_exam']; ?>')">
                                                        <i class="mdi mdi-trash-can-outline me-1"></i> Hapus Exam
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-justified-examActive" role="tabpanel">
                    <div class="card-body table-responsive">
                        <table class="table mt-5" width="100%" id="table2">
                            <thead class="table-dark">
                                <tr>
                                    <th> No </th>
                                    <th width="15%"> Nama </th>
                                    <th width="15%"> Nama Mata Kuliah </th>
                                    <th> Kelas dan Sesi</th>
                                    <th> Waktu Ujian </th>
                                    <th> Status </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px;">
                                <?php $i = 1;
                                foreach ($dataExamPublish  as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['nama_exam'] ?></td>
                                        <td><?= $row['nama_matkul'] ?></td>
                                        <td><?= '<b>' . "Kelas" . ':</b> ' . $row['nama_kelas'] . '<br>' . '<b>' . "Sesi" . ':</b> ' . $row['nama_sesi'] ?></td>
                                        <td><?= '<b>' . "Tanggal" . ':</b> ' . formatTanggalIndonesia($row['tgl_exam']) . '<br>' . '<b>' . "Jam" . ':</b> ' . $row['start_time'] . "-" . $row['end_time'] ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'pending') : ?>
                                                <span class="badge bg-label-primary"><?= $row['status'] ?></span>
                                            <?php elseif ($row['status'] === 'publish') : ?>
                                                <span class="badge bg-label-success"><?= $row['status'] ?></span>
                                            <?php elseif ($row['status'] === 'expired') : ?>
                                                <span class="badge bg-label-danger"><?= $row['status'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="/admin/publish/<?= $row['id_exam'] ?>" class="dropdown-item <?= ($row['status'] == 'publish') ? 'disabled' : ''; ?>">
                                                        <i class="mdi mdi-upload-multiple me-1"></i> Publish Exam
                                                    </a>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_exam']; ?>">
                                                        <i class="mdi mdi-pencil-outline me-1"></i> Update Exam
                                                    </button>
                                                    <button type="button" class="dropdown-item" onclick="confirmDelete('<?= $row['id_exam']; ?>')">
                                                        <i class="mdi mdi-trash-can-outline me-1"></i> Hapus Exam
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-justified-examExpired" role="tabpanel">
                    <div class="card-body table-responsive">
                        <table class="table mt-5" width="100%" id="table3">
                            <thead class="table-dark">
                                <tr>
                                    <th> No </th>
                                    <th width="15%"> Nama </th>
                                    <th width="15%"> Nama Mata Kuliah </th>
                                    <th> Kelas dan Sesi</th>
                                    <th> Waktu Ujian </th>
                                    <th> Status </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 13px;">
                                <?php $i = 1;
                                foreach ($dataExamExpired as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['nama_exam'] ?></td>
                                        <td><?= $row['nama_matkul'] ?></td>
                                        <td><?= '<b>' . "Kelas" . ':</b> ' . $row['nama_kelas'] . '<br>' . '<b>' . "Sesi" . ':</b> ' . $row['nama_sesi'] ?></td>
                                        <td><?= '<b>' . "Tanggal" . ':</b> ' . formatTanggalIndonesia($row['tgl_exam']) . '<br>' . '<b>' . "Jam" . ':</b> ' . $row['start_time'] . "-" . $row['end_time'] ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'pending') : ?>
                                                <span class="badge bg-label-primary"><?= $row['status'] ?></span>
                                            <?php elseif ($row['status'] === 'publish') : ?>
                                                <span class="badge bg-label-success"><?= $row['status'] ?></span>
                                            <?php elseif ($row['status'] === 'expired') : ?>
                                                <span class="badge bg-label-danger"><?= $row['status'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a href="/admin/examViewResult/<?= $row['id_exam'] ?>" class="dropdown-item">
                                                        <i class="mdi mdi-upload-multiple me-1"></i> Lihat Hasil
                                                    </a>
                                                    <a href="/admin/question/<?= $row['id_exam'] ?>" class="dropdown-item">
                                                        <i class="mdi mdi-file-document-arrow-right-outline me-1"></i> Manage Soal
                                                    </a>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_exam']; ?>">
                                                        <i class="mdi mdi-pencil-outline me-1"></i> Update Exam
                                                    </button>
                                                    <button type="button" class="dropdown-item" onclick="confirmDelete('<?= $row['id_exam']; ?>')">
                                                        <i class="mdi mdi-trash-can-outline me-1"></i> Hapus Exam
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Multilingual -->

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
                    <form action="/admin/examAdd" method="post" enctype="multipart/form-data">
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
                        <form action="/admin/examUpdate/<?= $row['id_exam'] ?>" method="post" enctype="multipart/form-data">
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
                window.location.href = "/admin/examDelete/" + id;
            } else {
                Swal.fire('Data tidak jadi dihapus!', '', 'info');
            }
        });
    }
</script>

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