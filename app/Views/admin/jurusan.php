<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View <?= $page_title ?></h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Data <?= $page_title ?></h5>
            </div>
            <div class="col-md-6 mt-1">
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table mt-5" width="100%" id="table">
            <thead class="table-dark">
                <tr>
                    <th> No </th>
                    <th> Nama Jurusan </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody> <!-- Buka elemen tbody di sini -->
                <?php $i = 1;
                foreach ($dataJurusan as $row) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $row['nama_jurusan'] ?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_jurusan']; ?>">
                                    <i class="mdi mdi-grease-pencil text-sm me-2"></i>
                                </button>
                                <a class="btn btn-danger" onclick="confirmDelete('<?= $row['id_jurusan']; ?>')"><i class="mdi mdi-delete text-sm me-2"></i></a>
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
                <h4 class="modal-title" id="modalCenterTitle">Input Data Jurusan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/admin/jurusanAdd" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="nama_jurusan" id="exampleFormControlInput1" placeholder="Masukan nama jurusan" autocomplete="off">
                                    <label>Nama Jurusan</label>
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
foreach ($dataJurusan as $row) : ?>
    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate<?= $row['id_jurusan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Data Jurusan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/admin/jurusanUpdate/<?= $row['id_jurusan'] ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['nama_jurusan'] ?>" class="form-control" name="nama_jurusan" id="exampleFormControlInput1" placeholder="Masukan nama jurusan" autocomplete="off">
                                        <label>Nama jurusan</label>
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
                window.location.href = "/admin/jurusanDelete/" + id;
            } else {
                Swal.fire('Data tidak jadi dihapus!', '', 'info');
            }
        });
    }
</script>



<?= $this->endSection() ?>