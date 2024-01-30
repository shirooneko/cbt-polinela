<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Mata Kuliah</h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Data Mata Kuliah</h5>
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
                    <th> Kode </th>
                    <th> Nama </th>
                    <th> Dosen </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody> <!-- Buka elemen tbody di sini -->
                <?php $i = 1;
                foreach ($dataMatkul as $row) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $row['kode_matkul'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['nama_dosen'] ?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalUpdate<?= $row['id_matkul']; ?>">
                                    <i class="mdi mdi-grease-pencil text-sm me-2"></i>
                                </button>
                                <a class="btn btn-danger" onclick="confirmDelete('<?= $row['id_matkul']; ?>')"><i class="mdi mdi-delete text-sm me-2"></i></a>
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
                <h4 class="modal-title" id="modalCenterTitle">Input Data Mata Kuliah</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form action="/admin/matkulAdd" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="kode_matkul" id="exampleFormControlInput1" placeholder="Masukan kode mata kuliah" autocomplete="off">
                                    <label>Kode Mata Kuliah</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="nama" id="exampleFormControlInput1" placeholder="Masukan nama mata kuliah" autocomplete="off">
                                    <label>Nama Mata Kuliah</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="semester" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option selected>Pilih Semester</option>
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                    <label for="exampleFormControlSelect1">Semester</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select name="id_dosen" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">Pilih Dosen</option>
                                        <?php foreach ($dataDosen as $dosen) : ?>
                                            <option value="<?= $dosen['id_dosen'] ?>"><?= $dosen['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="exampleFormControlSelect1">Semester</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" value="" class="form-control" name="thn_ajaran" id="exampleFormControlInput1" placeholder="Masukan tahun ajaran" autocomplete="off">
                                    <label>Tahun Ajaran</label>
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

<?php $i = 1;
foreach ($dataMatkul as $row) : ?>
    <!-- Modal Update -->
    <div class="modal fade" id="modalUpdate<?= $row['id_matkul'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalCenterTitle">Update Data Mata Kuliah</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form action="/admin/matkulUpdate/<?= $row['id_matkul'] ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['kode_matkul'] ?>" class="form-control" name="kode_matkul" id="exampleFormControlInput1" placeholder="Masukan kode mata kuliah" autocomplete="off">
                                        <label>Kode Mata Kuliah</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['nama'] ?>" class="form-control" name="nama" id="exampleFormControlInput1" placeholder="Masukan nama mata kuliah" autocomplete="off">
                                        <label>Nama Mata Kuliah</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select name="semester" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                            <option selected>Pilih Semester</option>
                                            <?php
                                            $semester = ['Ganjil', 'Genap'];
                                            foreach ($semester as $semester) {
                                                $selected = ($semester == $row['semester']) ? 'selected' : '';
                                                echo "<option value='$semester' $selected>$semester</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="exampleFormControlSelect1">Semester</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select name="id_dosen" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                            <option value="">Pilih Dosen</option>
                                            <?php foreach ($dataDosen as $dosen) : ?>
                                                <?php if ($row['id_dosen'] == $dosen["id_dosen"]) : ?>
                                                    <option value="<?= $dosen["id_dosen"] ?>" selected> <?= $dosen["nama"] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $dosen["id_dosen"] ?>"><?= $dosen["nama"] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="exampleFormControlSelect1">Semester</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" value="<?= $row['thn_ajaran'] ?>" class="form-control" name="thn_ajaran" id="exampleFormControlInput1" placeholder="Masukan tahun ajaran" autocomplete="off">
                                        <label>Tahun Ajaran</label>
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
                window.location.href = "/admin/matkulDelete/" + id;
            } else {
                Swal.fire('Data tidak jadi dihapus!', '', 'info');
            }
        });
    }
</script>

<?= $this->endSection() ?>