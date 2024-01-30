<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Soal</h5>
<!-- Multilingual -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
        <div class="card-header">
                <div class="row">
                    <!-- Judul Daftar Soal -->
                    <div class="col-md-6">
                        <h5 class="mb-0">Daftar Soal</h5>
                    </div>

                    <!-- Tombol Tambah Soal dan Export Soal -->
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <!-- Link Export Soal -->
                        <a href="/admin/exportQuestions/<?= $id ?>" class="btn btn-secondary btn-sm me-2">Export Soal</a>

                        <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalImport">
                            Import Data Excel
                        </button>

                        <!-- Tombol Tambah Soal -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdd">
                            Tambah Soal
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mt-2">
                    <?php $i = 1;
                    foreach ($dataExamQuestion as $question) : ?>

                        <?php
                        // Menguraikan string pilihan jawaban dan gambar pilihan dari format JSON ke array PHP
                        $pilihan = json_decode($question['pilihan'], true);
                        $gambar_pilihan = json_decode($question['gambar_pilihan'], true);
                        $jawaban_benar = $question['correct_answer'];  // Mengambil jawaban yang benar dari database
                        ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-column">
                                        <!-- Tampilkan gambar soal jika ada -->
                                        <?php if (!empty($question['gambar_soal'])) : ?>
                                            <img src="<?= base_url('/assets/images/exam/soal/' . $question['gambar_soal']); ?>" alt="Gambar Soal" class="img-fluid" width="120px">
                                        <?php endif; ?>
                                        <h5 class="my-3"><?= $i++ ?>. <?= strip_tags($question['soal'], '<strong><em><u><ol><ul><li><img><a>'); ?></h5>
                                    </div>
                                    <span class="mb-0"><?= $question['nilai'] ?> Poin</span>
                                </div>
                                <!-- Tampilkan pilihan jawaban -->
                                <?php foreach ($pilihan as $key => $value) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jawaban_<?= $question['id_question']; ?>" id="jawaban_<?= $key; ?>" value="<?= $key; ?>" <?= $key == $jawaban_benar ? 'checked' : ''; ?> disabled>
                                        <label class="form-check-label" for="jawaban_<?= $key; ?>">
                                            <!-- Tampilkan gambar pilihan jika ada -->
                                            <?php if (!empty($gambar_pilihan[$key])) : ?>
                                                <img src="<?= base_url('/assets/images/exam/pilihan/' . $gambar_pilihan[$key]); ?>" alt="Gambar Pilihan <?= $key; ?>" class="img-fluid" width="100px">
                                            <?php else : ?>
                                                <!-- Tampilkan teks pilihan jika tidak ada gambar -->
                                                <?= $key; ?>. <?= $value; ?>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Tombol Edit dan Hapus -->
                                <div class="mt-3">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $question['id_question']; ?>">
                                            <i class="mdi mdi-grease-pencil text-sm"></i>
                                        </button>
                                        <a class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $question['id_question']; ?>')"><i class="mdi mdi-delete text-sm"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
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
                                <td><b>Tanggal</b></td>
                                <td><?= formatTanggalIndonesia($dataExam['tgl_exam'])  ?></td>
                            </tr>
                            <tr>
                                <td><b>Kelas</b></td>
                                <td><?= $dataExam['nama_kelas']  ?></td>
                                <td><b>Waktu</b></td>
                                <td><?= $dataExam['start_time']  . ' - ' . $dataExam['end_time'] ?></td>
                            </tr>
                            <tr>
                                <td><b>Sesi</b></td>
                                <td><?= $dataExam['nama_sesi']  ?></td>
                                <td><b>Nilai</b></td>
                                <td> 100 </td>
                            </tr>
                            <tr>
                                <td><b>Mata Kuliah</b></td>
                                <td><?= $dataExam['nama_matkul'] ?></td>
                                <td><b>Total Nilai</b></td>
                                <td><?= $totalPoints ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Input Data Soal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/admin/questionAdd/<?= $dataExam['id_exam'] ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_exam" value="<?= $dataExam['id_exam'] ?>">
                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <h5>Soal Ujian</h5>
                                <textarea class="form-control" name="soal"></textarea>
                                <h5 class="mt-3">Upload Gambar Soal (opsional)</h5>
                                <input type="file" name="gambar_soal" accept="image/*" class="form-control">
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" value="" class="form-control" name="nilai" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                    <label for="exampleFormControlInput1">Poin</label>
                                </div>
                            </div>
                            <?php
                            $hurufPilihan = ['A', 'B', 'C', 'D'];
                            foreach ($hurufPilihan as $huruf) : ?>
                                <div class="col-md-12 mb-4">
                                    <h5>Pilihan <?= $huruf; ?></h5>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text form-check mb-0">
                                            <input class="form-check-input m-auto" type="radio" name="jawaban_benar" value="<?= $huruf; ?>" aria-label="Radio button for following text input" />
                                        </div>
                                        <input type="text" class="form-control" name="pilihan_<?= strtolower($huruf); ?>" aria-label="Text input with radio button" placeholder="Masukkan teks pilihan <?= $huruf; ?> atau biarkan kosong jika mengunggah gambar" />
                                        <input type="file" name="gambar_pilihan_<?= strtolower($huruf); ?>" accept="image/*" class="form-control" placeholder="Unggah gambar untuk pilihan <?= $huruf; ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $i = 1;
foreach ($dataExamQuestion as $question) :
    $pilihan = json_decode($question['pilihan'], true);
    $gambar_pilihan = json_decode($question['gambar_pilihan'], true);  // tambahkan baris ini
?>
    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate<?= $question['id_question'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Data Soal</h4> <!-- Ubah teks title modal -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/admin/questionUpdate/<?= $question['id_question'] ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_exam" value="<?= $dataExam['id_exam'] ?>">
                            <div class="row">
                                <div class="col-md-12 mb-5">
                                    <h5>Soal Ujian</h5>
                                    <textarea class="form-control" name="soal"><?= $question['soal'] ?></textarea>
                                    <input type="file" class="form-control mt-2" name="gambar_soal" accept="image/*"> <!-- tambahkan input file untuk gambar soal -->
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="number" value="<?= $question['nilai'] ?>" class="form-control" name="nilai" id="exampleFormControlInput1" placeholder="" autocomplete="off">
                                        <label>Poin</label>
                                    </div>
                                </div>
                                <?php
                                $hurufPilihan = ['A', 'B', 'C', 'D'];
                                foreach ($hurufPilihan as $huruf) : ?>
                                    <div class="col-md-12 mb-4">
                                        <h5>Pilihan <?= $huruf; ?></h5>
                                        <div class="input-group">
                                            <div class="input-group-text form-check mb-0">
                                                <input class="form-check-input m-auto" type="checkbox" name="jawaban_benar" value="<?= $huruf; ?>" <?= ($question['correct_answer'] == $huruf) ? 'checked' : ''; ?> aria-label="Checkbox for following text input" />
                                            </div>
                                            <input type="text" class="form-control" name="pilihan_<?= strtolower($huruf); ?>" value="<?= $pilihan[$huruf] ?>" aria-label="Text input with checkbox" />
                                            <input type="file" class="form-control" name="gambar_pilihan_<?= strtolower($huruf); ?>" accept="image/*"> <!-- tambahkan input file untuk gambar pilihan -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
<?php endforeach; ?>

<div class="modal fade" id="modalImport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Import Data Soal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Tempat untuk download template -->
                        <div class="">
                            <label class="form-label">Unduh template excel</label>
                        </div>
                        <div>
                            <a href="/assets/file/import_soal.xlsx" download="Import_Soal.xlsx" class="btn btn-success">
                                <i class="mdi mdi-file-download-outline"></i> Download Template
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Form untuk upload file -->
                        <form action="/admin/importQuestion/<?= $id ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="fileToUpload" class="form-label">Upload File Excel</label>
                                <input class="form-control" type="file" id="fileToUpload" name="fileToUpload" accept=".xlsx, .xls">
                                <div id="fileHelp" class="form-text">Upload file Excel dengan format yang telah ditentukan.</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Import Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                window.location.href = "/admin/questionDelete/" + id;
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