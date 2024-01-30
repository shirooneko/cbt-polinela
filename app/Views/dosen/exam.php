<?= $this->extend('dosen/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Exam</h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title fw-bold">Data Exam</h5>
            </div>
            <div class="col-md-9 mt-1 d-flex justify-content-end">
                <a href="javascript:location.reload();" class="btn btn-primary me-2 fs-6 fs-md-5 fs-lg-4 fs-xl-3">
                    <span class="mdi mdi-refresh"></span>
                </a>
                <button type="button" class="btn btn-primary fs-sm-6 fs-md-5 fs-lg-4 fs-xl-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    <i class="mdi mdi-plus me-1"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <select name="status" class="form-select" id="status" aria-label="Default select example">
                        <option value="">Pilih Status</option>
                        <option value="publish">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="expired">Selesai</option>
                    </select>
                    <label>Status</label>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <select name="id_kelas" class="form-select" id="kelas" aria-label="Default select example">
                        <option selected>Pilih Kelas</option>
                        <?php foreach ($dataKelas as $k) : ?>
                            <option value="<?= $k["id_kelas"] ?>"><?= $k["nama"] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Kelas</label>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <select name="id_sesi" class="form-select" id="sesi" aria-label="Default select example">
                        <option selected>Pilih Sesi</option>
                        <?php foreach ($dataSesi as $s) : ?>
                            <option value="<?= $s["id_sesi"] ?>"><?= $s["nama_sesi"] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Sesi</label>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <select name="id_matkul" class="form-select" id="matkul" aria-label="Default select example">
                        <option selected>Pilih Mata Kuliah</option>
                        <?php foreach ($dataMatkul as $m) : ?>
                            <option value="<?= $m["id_matkul"] ?>"><?= $m["nama"] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Mata Kuliah</label>
                </div>
            </div>
        </div>
        <div class="card-deck" style="display: flex; flex-wrap: wrap; gap: 1rem;">
            <!-- Konten kartu akan di-render dengan JavaScript -->
        </div>
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

<!-- Script untuk handle AJAX dan rendering kartu -->
<script>
    $(document).ready(function() {
        // Fungsi untuk mengambil data dan memperbarui UI
        function fetchData() {
            var status = $('#status').val();
            var id_kelas = $('#kelas').val();
            var id_sesi = $('#sesi').val();
            var id_matkul = $('#matkul').val();

            // Struktur data untuk permintaan AJAX
            var requestData = {
                status: status,
                id_kelas: id_kelas === 'Pilih Kelas' ? '' : id_kelas,
                id_sesi: id_sesi === 'Pilih Sesi' ? '' : id_sesi,
                id_matkul: id_matkul === 'Pilih Mata Kuliah' ? '' : id_matkul
            };

            // Permintaan AJAX untuk mengambil data
            $.ajax({
                url: '<?= site_url('dosen/filterExams') ?>', // Sesuaikan dengan URL endpoint Anda
                type: 'GET',
                dataType: 'json',
                data: requestData,
                // Lanjutan dari fungsi success dalam permintaan AJAX Anda
                success: function(data) {
                    // Kosongkan card deck
                    $('.card-deck').empty();

                    // Loop melalui data yang dikembalikan dan buat kartu
                    data.forEach(function(exam) {
                        var updateModalId = "modalUpdate" + exam.id_exam; // Pastikan ID ini sesuai dengan ID modal update Anda
                        var cardHtml = `
                        <div class="card" style="width: 18rem; flex: 0 0 auto; border: 1px solid #0E8388; margin-bottom: 1rem;">
                            <img src="/assets/images/thumbnail.webp" class="card-img-top" alt="Thumbnail">
                            <div class="card-body">
                                <h5 class="card-title">${exam.nama_exam}</h5>
                                <p class="card-text">
                                    Mata Kuliah: ${exam.nama_matkul}<br>
                                    Kelas: ${exam.nama_kelas}<br>
                                    Sesi: ${exam.nama_sesi}<br>
                                    Waktu: ${exam.start_time} - ${exam.end_time}<br>
                                    Tanggal: ${formatTanggalIndonesia(exam.tgl_exam)}<br>
                                </p>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary">Manage Exam</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#${updateModalId}">
                                                <i class="mdi mdi-pencil-outline me-1"></i> Update Exam
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item" onclick="confirmDelete('${exam.id_exam}')">
                                                <i class="mdi mdi-trash-can-outline me-1"></i> Hapus Exam
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        ${exam.status === 'pending' ? `
                                            <li>
                                                <a class="dropdown-item" href="/dosen/publish/${exam.id_exam}">
                                                    <i class="mdi mdi-upload-multiple me-1"></i> Publish Exam
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="/dosen/question/${exam.id_exam}">
                                                    <i class="mdi mdi-file-document-arrow-right-outline me-1"></i> Beri Soal
                                                </a>
                                            </li>
                                        ` : ''}
                                        ${exam.status === 'publish' ? `
                                            <!-- Opsional: Tombol untuk status 'publish' -->
                                        ` : ''}
                                        ${exam.status === 'expired' ? `
                                            <li>
                                                <a class="dropdown-item" href="/dosen/examViewResult/${exam.id_exam}">
                                                    <i class="mdi mdi-upload-multiple me-1"></i> Lihat Hasil
                                                </a>
                                            </li>
                                        ` : ''}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                        $('.card-deck').append(cardHtml);
                    });
                    // Tambahkan Bootstrap JavaScript untuk dropdown jika belum di-load
                    // Jika Anda menggunakan Bootstrap 5:
                    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                    dropdownElementList.map(function(dropdownToggleEl) {
                        return new bootstrap.Dropdown(dropdownToggleEl);
                    });

                    // Tampilkan pesan jika tidak ada data
                    if (data.length === 0) {
                        $('.card-deck').html('<div class="alert alert-solid-primary" role="alert"> Tidak ada ujian yang ditemukan </div>');
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching filtered exams: ' + textStatus, errorThrown);
                    $('.card-deck').html('<div class="alert alert-solid-danger" role="alert"> Terjadi Kesalahan dalam Memuat data </div>');
                }
            });
        }

        // Event listener untuk setiap select box
        $('#status, #kelas, #sesi, #matkul').change(fetchData);

        // Memanggil fungsi fetchData saat halaman dimuat untuk pertama kali
        fetchData(); // Jika Anda ingin data ditampilkan saat halaman pertama kali dimuat
    });
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