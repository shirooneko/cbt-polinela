<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php $validation = session()->getFlashdata('validation'); ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Dosen</h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Data Dosen</h5>
            </div>
            <div class="col-md-6 mt-1">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-stripted" width="100%" id="table1">
            <thead class="table-dark">
                <tr>
                    <th width="1%"> No </th>
                    <th width="6%"> Foto </th>
                    <th> NIP </th>
                    <th> Nama </th>
                    <th> No Telepon </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody> <!-- Buka elemen tbody di sini -->
                <?php $i = 1;
                foreach ($dataDosen as $row) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td>
                            <img src="/assets/images/dosen/<?= $row['foto'] ?>" alt="image" width="70px" />
                        </td>
                        <td><?= $row['nip'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_dosen'] ?>">
                                    <i class="mdi mdi-grease-pencil text-sm me-2"></i>
                                </button>
                                <a class="btn btn-danger" onclick="confirmDelete('<?= $row['id_dosen']; ?>')"><i class="mdi mdi-delete text-sm me-2"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody> <!-- Tutup elemen tbody di sini -->
        </table>
    </div>
</div>
<!--/ Multilingual -->

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Input Data Dosen</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/admin/dosenAdd" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control <?= (isset($validation) && $validation->hasError('nip')) ? 'is-invalid' : ''; ?>" name="nip" id="exampleFormControlInput1" placeholder="Masukan NIP Dosen" autocomplete="off">
                                    <label for="exampleFormControlInput1">NIP</label>
                                    <?php if (isset($validation) && $validation->hasError('nip')) : ?>
                                        <div class="invalid-feedback"><?= $validation->getError('nip'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="exampleFormControlInput2" placeholder="Masukan Nama Dosen" autocomplete="off">
                                    <label for="exampleFormControlInput2">Nama Dosen</label>
                                    <?php if (isset($validation) && $validation->hasError('nama')) : ?>
                                        <div class="invalid-feedback"><?= $validation->getError('nama'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="exampleFormControlInput3" placeholder="Masukan Email Dosen" autocomplete="off">
                                    <label for="exampleFormControlInput3">Email</label>
                                    <?php if (isset($validation) && $validation->hasError('email')) : ?>
                                        <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="exampleFormControlInput4" placeholder="Masukan Password" autocomplete="off">
                                    <label for="exampleFormControlInput4">Password</label>
                                    <?php if (isset($validation) && $validation->hasError('password')) : ?>
                                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="file" class="form-control <?= (isset($validation) && $validation->hasError('foto')) ? 'is-invalid' : ''; ?>" name="foto" id="upload-file" placeholder="Masukan Email Dosen" autocomplete="off">
                                    <label for="upload-file">Foto</label>
                                    <?php if (isset($validation) && $validation->hasError('foto')) : ?>
                                        <div class="invalid-feedback"><?= $validation->getError('foto'); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="col-md-12 form-group text-center">
                                    <p>Preview Foto</p>
                                    <img id="preview" src="" alt="Preview" width="100px" style="display: none; margin: 0 auto;">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $i = 1;
foreach ($dataDosen as $row) : ?>
    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate<?= $row['id_dosen'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Data Dosen</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/admin/dosenUpdate/<?= $row['id_dosen'] ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="number" class="form-control <?= (session('validation') && session('validation')->hasError('nip')) ? 'is-invalid' : ''; ?>" name="nip" id="nip" placeholder="Masukan NIP Dosen" autocomplete="off" value="<?= old('nip', $row['nip']) ?>">
                                        <label for="nip">NIP</label>
                                        <?php if (session('validation') && session('validation')->hasError('nip')) : ?>
                                            <div class="invalid-feedback"><?= session('validation')->getError('nip'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control <?= (session('validation') && session('validation')->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" placeholder="Masukan Nama Dosen" autocomplete="off" value="<?= old('nama', $row['nama']) ?>">
                                        <label for="nama">Nama Dosen</label>
                                        <?php if (session('validation') && session('validation')->hasError('nama')) : ?>
                                            <div class="invalid-feedback"><?= session('validation')->getError('nama'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="email" class="form-control <?= (session('validation') && session('validation')->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="Masukan Email Dosen" autocomplete="off" value="<?= old('email', $row['email']) ?>">
                                        <label for="email">Email</label>
                                        <?php if (session('validation') && session('validation')->hasError('email')) : ?>
                                            <div class="invalid-feedback"><?= session('validation')->getError('email'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Password" autocomplete="off">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="file" class="form-control <?= (session('validation') && session('validation')->hasError('foto')) ? 'is-invalid' : ''; ?>" name="foto" id="upload-file" placeholder="Upload Foto Dosen" autocomplete="off">
                                        <label for="upload-file">Foto</label>
                                        <?php if (session('validation') && session('validation')->hasError('foto')) : ?>
                                            <div class="invalid-feedback"><?= session('validation')->getError('foto'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="col-md-12 form-group text-center">
                                        <p>Preview Foto</p>
                                        <img id="preview" src="/assets/images/dosen/<?= $row['foto'] ?>" alt="Preview" width="100px">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
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
                window.location.href = "/admin/dosenDelete/" + id;
            } else {
                Swal.fire('Data tidak jadi dihapus!', '', 'info');
            }
        });
    }
</script>

<script>
    // Tambahkan log untuk debugging
    console.log('Script dijalankan.');

    // Fungsi untuk menampilkan modal jika terdapat validasi error
    function showModalIfValidationFailed() {
        <?php if ($validation) : ?>
            console.log('Memunculkan modal.');
            $('#modalAdd').modal('show');
        <?php endif; ?>
    }

    // Pastikan jQuery telah dimuat sebelum memanggil fungsi ini
    $(document).ready(showModalIfValidationFailed);
</script>



<?= $this->endSection() ?>