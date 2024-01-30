<div class="modal-header">
    <h4 class="modal-title" id="modalCenterTitle">Update Data Mahasiswa</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="/admin/mahasiswaUpdate/<?= $mahasiswa['id_mahasiswa'] ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <!-- NPM -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="number" value="<?= $mahasiswa['npm'] ?>" class="form-control" name="npm" placeholder="Masukan NPM" autocomplete="off">
                    <label>NPM</label>
                </div>
            </div>

            <!-- Nama Mahasiswa -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" value="<?= $mahasiswa['nama'] ?>" class="form-control" name="nama" placeholder="Masukan Nama Mahasiswa" autocomplete="off">
                    <label>Nama Mahasiswa</label>
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <select name="sex" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" <?= $mahasiswa['sex'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-Laki</option>
                        <option value="Perempuan" <?= $mahasiswa['sex'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                    <label>Jenis Kelamin</label>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="email" value="<?= $mahasiswa['email'] ?>" class="form-control" name="email" placeholder="Masukan Email" autocomplete="off">
                    <label>Email</label>
                </div>
            </div>

            <!-- Tempat Lahir -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" value="<?= $mahasiswa['tempat_lahir'] ?>" class="form-control" name="tempat_lahir" placeholder="Masukan Tempat Lahir" autocomplete="off">
                    <label>Tempat Lahir</label>
                </div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="date" value="<?= $mahasiswa['tgl_lahir'] ?>" class="form-control" name="tgl_lahir" autocomplete="off">
                    <label>Tanggal Lahir</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <select name="id_jurusan" id="selectJurusan" class="form-select" aria-label="Default select example" onchange="updateProdiOptions()">
                        <option selected>Pilih Jurusan</option>
                        <?php foreach ($dataJurusan as $j) : ?>
                            <option value="<?= $j["id_jurusan"] ?>" <?= ($j["id_jurusan"] == $mahasiswa['id_jurusan']) ? 'selected' : '' ?>>
                                <?= $j["nama_jurusan"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label>Jurusan</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <select name="id_prodi" id="selectProdi" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Program Studi</option>
                        <?php foreach ($dataProdi as $p) : ?>
                            <option value="<?= $p["id_prodi"] ?>" <?= ($p["id_prodi"] == $mahasiswa['id_prodi']) ? 'selected' : '' ?>>
                                <?= $p["nama_prodi"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label>Program Studi</label>
                </div>
            </div>


            <!-- Angkatan -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" value="<?= $mahasiswa['angkatan'] ?>" class="form-control" name="angkatan" placeholder="Masukan Angkatan" autocomplete="off">
                    <label>Angkatan</label>
                </div>
            </div>

            <!-- Kelas -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <select name="id_kelas" class="form-select" aria-label="Default select example">
                        <option selected>Pilih Kelas</option>
                        <?php foreach ($dataKelas as $kelas) : ?>
                            <option value="<?= $kelas['id_kelas'] ?>" <?= $mahasiswa['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '' ?>><?= $kelas['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Kelas</label>
                </div>
            </div>

            <!-- Password (opsional) -->
            <div class="col-md-6">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="password" class="form-control" name="password" placeholder="Masukan Password" autocomplete="off">
                    <label>Password (abaikan jika tidak update password)</label>
                </div>
            </div>

            <!-- Foto -->
            <div class="col-md-3">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="file" class="form-control" name="foto" id="upload-file">
                    <label>Foto</label>
                </div>
            </div>

            <!-- Preview Foto -->
            <div class="col-md-3 mb-5">
                <div class="form-group text-center">
                    <p>Foto Saat ini</p>
                    <img src="/assets/images/mahasiswa/<?= $mahasiswa['foto'] ?>" alt="Preview" width="100px">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
    </form>
</div>