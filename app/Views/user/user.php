<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between mb-5">
                            <h4 class="card-title mb-1">Manajemen Data Pengguna</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                Tambah Data
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table mt-5" width="100%" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th> No </th>
                                        <th> Foto </th>
                                        <th> Nama </th>
                                        <th> Username </th>
                                        <th> Role </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody> <!-- Buka elemen tbody di sini -->
                                    <?php $i = 1;
                                    foreach ($dataUser as $row) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td>
                                                <img src="/assets/images/user/<?= $row['foto'] ?>" alt="image" width="70px" />
                                            </td>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['username'] ?></td>
                                            <td>
                                                <?php if ($row['role'] === 'administrator') : ?>
                                                    <div class="badge badge-info"><?= $row['role'] ?></div>
                                                <?php elseif ($row['role'] === 'akademik') : ?>
                                                    <div class="badge badge-warning"><?= $row['role'] ?></div>
                                                <?php elseif ($row['role'] === 'dosen') : ?>
                                                    <div class="badge badge-primary"><?= $row['role'] ?></div>
                                                <?php elseif ($row['role'] === 'mahasiswa') : ?>
                                                    <div class="badge badge-danger"><?= $row['role'] ?></div>
                                                <?php else : ?>
                                                    <?= $row['role'] ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" onclick="confirmDelete('<?= $row['id_user']; ?>')"><i class="mdi mdi-delete text-sm me-2"></i></a>
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_user'] ?>">
                                                    <i class="mdi mdi-grease-pencil text-sm me-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody> <!-- Tutup elemen tbody di sini -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/user/add" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
                            <input type="text" value="" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="nama" id="exampleFormControlInput1" placeholder="Masukan nama lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Masukan Username</label>
                            <input type="text" value="" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="username" id="exampleFormControlInput1" placeholder="Masukan username">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Masukan Password</label>
                            <input type="password" value="" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="password" id="exampleFormControlInput1" placeholder="Masukan password">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Role</label>
                            <select name="role" id="" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="administrator">Administrator</option>
                                <option value="akademik">Akademik</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto Pengguna</label>
                            <input type="file" value="" name="foto" class="file-upload-default <?= isset($errors['foto']) ? 'is-invalid' : ''; ?>">
                            <?php if (isset($errors['foto'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $errors['foto'] ?>
                                </div>
                            <?php endif; ?>
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $i = 1;
    foreach ($dataUser as $row) : ?>
        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit<?= $row['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Update Data Dosen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/user/update/<?= $row['id_user'] ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
                            <input type="text" value="<?= $row['nama'] ?>" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="nama" id="exampleFormControlInput1" placeholder="Masukan nama lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Masukan Username</label>
                            <input type="text" value="<?= $row['username'] ?>" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="username" id="exampleFormControlInput1" placeholder="Masukan username">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Masukan Password <sub>| abaikan jika tidak update password</sub></label>
                            <input type="password" value="" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : ''; ?>" name="password" id="exampleFormControlInput1" placeholder="Masukan password">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Role</label>
                            <select name="role" id="" class="form-control">
                                <option value="">Pilih Role</option>
                                <option value="administrator">Administrator</option>
                                <option value="akademik">Akademik</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <?php
                                    $role = ['administrator', 'akademik', 'dosen', 'mahasiswa'];
                                    foreach ($role as $role) {
                                        $selected = ($role == $row['role']) ? 'selected' : '';
                                        echo "<option value='$role' $selected>$role</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto Pengguna</label>
                            <input type="file" value="" name="foto" class="file-upload-default <?= isset($errors['foto']) ? 'is-invalid' : ''; ?>">
                            <?php if (isset($errors['foto'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $errors['foto'] ?>
                                </div>
                            <?php endif; ?>
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
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
                    window.location.href = "/user/delete/" + id;
                } else {
                    Swal.fire('Data tidak jadi dihapus!', '', 'info');
                }
            });
        }
    </script>

    <?= $this->endSection() ?>