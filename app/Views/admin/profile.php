<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View <?= $page_title ?></h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Data Administrator</h5>
            </div>
            <div class="col-md-6 mt-1">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table mt-5" width="100%" id="table1">
            <thead class="table-dark">
                <tr>
                    <th> No </th>
                    <th> Foto </th>
                    <th> Nama </th>
                    <th> Username </th>
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_user']; ?>">
                                    <i class="mdi mdi-grease-pencil text-sm me-2"></i>
                                </button>
                                <a class="btn btn-danger" onclick="confirmDelete('<?= $row['id_user']; ?>')"><i class="mdi mdi-delete text-sm me-2"></i></a>
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
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Input Data <?= $page_title ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/admin/userAdd" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="nama" id="exampleFormControlInput1" placeholder="Masukan Nama administator" autocomplete="off">
                                    <label>Nama Administrator</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="username" id="exampleFormControlInput1" placeholder="Masukan username" autocomplete="off">
                                    <label>Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" value="" class="form-control" name="password" id="exampleFormControlInput1" placeholder="Masukan Password" autocomplete="off">
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

<?php $i = 1;
foreach ($dataUser as $row) : ?>
    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate<?= $row['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Data <?= $page_title ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/admin/userUpdate/<?= $row['id_user'] ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['nama'] ?>" class="form-control" name="nama" id="exampleFormControlInput1" placeholder="Masukan Nama Administrator" autocomplete="off">
                                        <label>Nama Administrator</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['username'] ?>" class="form-control" name="username" id="exampleFormControlInput1" placeholder="Masukan Username" autocomplete="off">
                                        <label>Username</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="password" class="form-control" name="password" id="exampleFormControlInput1" placeholder="Masukan Password Baru (biarkan kosong jika tidak ingin mengubah)" autocomplete="off">
                                        <label>Password</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="file" class="form-control" name="foto" id="upload-file" placeholder="Upload Foto Baru" autocomplete="off">
                                        <label>Foto</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-5">
                                    <div class="form-group text-center">
                                        <p>Foto Saat Ini</p>
                                        <img id="preview" src="/assets/images/user/<?= $row['foto'] ?>" alt="Preview" width="100px">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                                <button type="submit" class="btn btn-primary">Update Data</button>
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
                window.location.href = "/admin/userDelete/" + id;
            } else {
                Swal.fire('Data tidak jadi dihapus!', '', 'info');
            }
        });
    }
</script>

<?= $this->endSection() ?>