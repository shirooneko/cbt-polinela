<?= $this->extend('mahasiswa/layout') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User Profile /</span> Profile</h4>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <center><img class="img-thumbnail mb-3" src="/assets/images/mahasiswa/<?= $dataMahasiswa['foto'] ?>" width="150"></center>
                <div class="text-center">
                    <h6><b>Program Studi</b>, <span class="fw-light"><?= $dataProdi[0]["nama_prodi"] ?>  - <?= $dataMahasiswa["angkatan"] ?></span></h6>
                    <h6><b>Jurusan</b> - <span class="fw-light"><?= $dataJurusan[0]["nama_jurusan"] ?></span></h6>
                    <h6><b>Politeknik Negeri Lampung</b></h6>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Upload Foto
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Foto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/mahasiswa/updateFoto" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_mahasiswa" value="<?= $dataMahasiswa["id_mahasiswa"] ?>">
                                <div class="modal-body">
                                    <input type="file" class="form-control" id="foto" name="foto" value="<?= old('foto'); ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header mb-0">
                <h4 class="fw-bold mb-0">Profil Mahasiswa</h4>
            </div>
            <hr>
            <div class="card-body">
                <form action="/mahasiswa/mahasiswaUpdate/<?= $dataMahasiswa["id_mahasiswa"] ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_siswa" value="<?= $dataMahasiswa["id_mahasiswa"] ?>">
                    <div class="tab-pane fade show active" id="nav-siswa" role="tabpanel" aria-labelledby="nav-siswa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="<?= $dataMahasiswa['npm'] ?>" class="form-control" name="npm" placeholder="Masukan Nama Administrator" autocomplete="off" disabled>
                                    <label>NPM</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="<?= $dataMahasiswa['nama'] ?>" class="form-control" name="nama" placeholder="Masukan Nama Administrator" autocomplete="off">
                                    <label>Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="<?= $dataMahasiswa['tempat_lahir'] ?>" class="form-control" name="tempat_lahir" placeholder="Masukan Nama Administrator" autocomplete="off">
                                    <label>Tempat Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="date" value="<?= $dataMahasiswa['tgl_lahir'] ?>" class="form-control" name="tgl_lahir" placeholder="Masukan Nama Administrator" autocomplete="off">
                                    <label>Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_jurusan" id="selectJurusan" class="form-select" aria-label="Default select example" name="jurusan" disabled>
                                        <option selected>Pilih Jurusan</option>
                                        <?php foreach ($dataJurusan as $j) : ?>
                                            <option value="<?= $j["id_jurusan"] ?>" <?= ($j["id_jurusan"] == $dataMahasiswa['id_jurusan']) ? 'selected' : '' ?>>
                                                <?= $j["nama_jurusan"] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Jurusan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_prodi" id="selectProdi" class="form-select" aria-label="Default select example" disabled>
                                        <option selected>Pilih Program Studi</option>
                                        <?php foreach ($dataProdi as $p) : ?>
                                            <option value="<?= $p["id_prodi"] ?>" <?= ($p["id_prodi"] == $dataMahasiswa['id_prodi']) ? 'selected' : '' ?>>
                                                <?= $p["nama_prodi"] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Program Studi</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="<?= $dataMahasiswa['email'] ?>" class="form-control" name="email" placeholder="Masukan Username" autocomplete="off">
                                    <label>Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" class="form-control" name="password" placeholder="Masukan Password Baru" autocomplete="off">
                                    <sub class="text-primary">biarkan kosong jika tidak ingin mengubah</sub>
                                    <label>Password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-ortu" role="tabpanel" aria-labelledby="nav-profile-tab">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>