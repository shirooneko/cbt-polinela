<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User Profile /</span> Profile</h4>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <center><img class="img-thumbnail mb-3" src="/assets/images/user/<?= $dataUser['foto'] ?>" width="150"></center>
                <div class="text-center">
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
                            <form action="/admin/user/updateFoto" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_user" value="<?= $dataUser["id_user"] ?>">
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
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form action="/admin/userUpdate/<?= $dataUser["id_user"] ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_siswa" value="<?= $dataUser["id_user"] ?>">
                    <div class="tab-pane fade show active" id="nav-siswa" role="tabpanel" aria-labelledby="nav-siswa">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="<?= $dataUser['nama'] ?>" class="form-control" name="nama" id="exampleFormControlInput1" placeholder="Masukan Nama Administrator" autocomplete="off">
                                    <label>Nama Administrator</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="<?= $dataUser['username'] ?>" class="form-control" name="username" id="exampleFormControlInput1" placeholder="Masukan Username" autocomplete="off">
                                    <label>Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" class="form-control" name="password" id="exampleFormControlInput1" placeholder="Masukan Password Baru" autocomplete="off">
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