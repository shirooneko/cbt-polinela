<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Mahasiswa</h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-3">
                <h5 class="card-title fw-bold">Data Mahasiswa</h5>
            </div>
            <div class="col-md-9 mt-1 d-flex justify-content-end">
                <a href="javascript:location.reload();" class="btn btn-primary btn-sm me-2 fs-6 fs-md-5 fs-lg-4 fs-xl-3">
                    <span class="mdi mdi-refresh"></span>
                </a>
                <button type="button" class="btn btn-secondary btn-sm me-2 fs-6 fs-md-5 fs-lg-4 fs-xl-3" data-bs-toggle="modal" data-bs-target="#modalImport">
                    <i class="mdi mdi-file-import-outline me-1"></i> Import Data Excel
                </button>
                <button type="button" class="btn btn-primary fs-sm-6 btn-sm fs-md-5 fs-lg-4 fs-xl-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    <i class="mdi mdi-plus me-1"></i> Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="row mb-2">
            <div class="col-md-12">
                <div>
                    <span class="badge rounded-pill bg-info mb-2">Informasi :</span>
                    <code class="text-primary">
                        <ul>
                            <li>Gunakan Filter pencarian berdasarkan kelas, atau cari berdasarkan nama atau npm</li>
                            <li>Jika kelas belum ada maka tambahkan dulu di menu <a href="/admin/kelas" class="badge rounded-pill bg-success">kelas</a></li>
                        </ul>
                    </code>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <select name="id_kelas" class="form-select" id="kelas" aria-label="Default select example">
                        <option>Pilih Kelas</option>
                        <?php foreach ($dataKelas as $k) : ?>
                            <option value="<?= $k["id_kelas"] ?>"><?= $k["nama"] .' - '. $k['nama_prodi'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Kelas</label>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari mahasiswa berdasarkan nama atau npm...">
                    <label>Cari Mahasiswa</label>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mt-5" width="100%" id="tables">
                <thead class="table-dark">
                    <tr>
                        <th> No </th>
                        <th> Foto </th>
                        <th width="25%"> Nama & NPM </th>
                        <th> sex </th>
                        <th width="12%"> Tempat, Tanggal Lahir </th>
                        <th width="27%" >Keterangan</th>
                        <th> Email </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>
</div>
<!--/ Multilingual -->

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Input Data Mahasiswa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/admin/mahasiswaAdd" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" value="" class="form-control" name="npm" placeholder="Masukan NPM" autocomplete="off">
                                    <label>NPM</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="nama" placeholder="Masukan Nama Dosen" autocomplete="off">
                                    <label>Nama Mahasiswa</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="sex" class="form-select" id="" aria-label="Default select example">
                                        <option selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label>Jenis Kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="email" value="" class="form-control" name="email" placeholder="Masukan Email Dosen" autocomplete="off">
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="tempat_lahir" placeholder="Masukan tempat lahir" autocomplete="off">
                                    <label>Tempat Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="date" value="" class="form-control" name="tgl_lahir" placeholder="" autocomplete="off">
                                    <label>Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_jurusan" id="selectJurusan" class="form-select" aria-label="Default select example" onchange="updateProdiOptions()">
                                        <option selected>Pilih Jurusan</option>
                                        <?php foreach ($dataJurusan as $j) : ?>
                                            <option value="<?= $j["id_jurusan"] ?>"><?= $j["nama_jurusan"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Jurusan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_prodi" id="selectProdi" class="form-select" aria-label="Default select example">
                                        <option selected>Pilih Program Studi</option>
                                    </select>
                                    <label>Program Studi</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_kelas" class="form-select" id="" aria-label="Default select example">
                                        <option selected>Pilih Kelas</option>
                                        <?php foreach ($dataKelas as $k) : ?>
                                            <option value="<?= $k["id_kelas"] ?>"><?= $k["nama"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="angkatan" placeholder="" autocomplete="off">
                                    <label>Angkatan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" value="" class="form-control" name="password" placeholder="Masukan Password" autocomplete="off">
                                    <label>Password </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="file" value="" class="form-control" name="foto" id="upload-file" placeholder="Masukan Email Dosen" autocomplete="off">
                                    <label>Foto</label>
                                </div>
                            </div>

                            <div class="col-md-3 mb-5">
                                <div class="form-group text-center">
                                    <p>Preview Foto</p>
                                    <img id="preview" src="" alt="Preview" width="100px" style="display: none; margin: 0 auto;">
                                </div>
                            </div>
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

<!-- Modal Update Template di mahasiswa.php -->
<div class="modal fade" id="modalUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <!-- Konten modal akan dimuat di sini secara dinamis -->
        </div>
    </div>
</div>



<!-- Modal Import Data Mahasiswa -->
<div class="modal fade" id="modalImport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Import Data Mahasiswa</h4>
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
                            <a href="/assets/file/data_mahasiswa.xlsx" download="Import_Mahasiswa.xlsx" class="btn btn-success">
                                <i class="mdi mdi-file-download-outline"></i> Download Template
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Form untuk upload file -->
                        <form action="/admin/import" method="post" enctype="multipart/form-data">
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
    function updateProdiOptions() {
        // Mendapatkan nilai yang dipilih dari dropdown "Jurusan"
        var selectedJurusan = document.getElementById("selectJurusan").value;

        // Mendapatkan dropdown "Program Studi"
        var selectProdi = document.getElementById("selectProdi");

        // Menghapus semua opsi sebelum menambahkan yang baru
        selectProdi.innerHTML = '<option selected>Pilih Program Studi</option>';

        // Menambahkan opsi sesuai dengan Jurusan yang dipilih
        <?php foreach ($dataProdi as $p) : ?>
            if ("<?= $p["id_jurusan"] ?>" === selectedJurusan) {
                var option = document.createElement("option");
                option.value = "<?= $p["id_prodi"] ?>";
                option.text = "<?= $p["nama_prodi"] ?>";
                selectProdi.add(option);
            }
        <?php endforeach; ?>
    }
</script>



<?= $this->endSection() ?>