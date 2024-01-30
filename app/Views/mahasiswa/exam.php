<?= $this->extend('mahasiswa/layout') ?>
<?= $this->section('content') ?>
<?php helper('custom_helper'); ?>

<h5 class="fw-bold mb-4"><span class="text-muted fw-light"><?= $page_title ?> /</span> View Exam</h5>
<!-- Multilingual -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Data Exam</h5>
            </div>
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-examActive" aria-controls="navs-pills-justified-home" aria-selected="true">
                        <i class="tf-icons mdi mdi-archive-check-outline me-1"></i> Aktif
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-examExpired" aria-controls="navs-pills-justified-profile" aria-selected="false">
                        <i class="tf-icons mdi mdi-archive-eye-outline me-1"></i> Selesai
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-examActive" role="tabpanel">
                <div class="card-body table-responsive">
                    <table class="table mt-5" width="100%" class="display">
                        <thead class="table-dark">
                            <tr>
                                <th> No </th>
                                <th width="15%"> Nama </th>
                                <th width="15%"> Nama Mata Kuliah </th>
                                <th> Kelas dan Sesi</th>
                                <th> Waktu Ujian </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="exam-data-aktif" style="font-size: 13px;"> </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-examExpired" role="tabpanel">
                <div class="card-body table-responsive">
                    <table class="table mt-5" width="100%" id="" class="display">
                        <thead class="table-dark">
                            <tr>
                                <th> No </th>
                                <th width="15%"> Nama </th>
                                <th width="15%"> Nama Mata Kuliah </th>
                                <th> Kelas dan Sesi</th>
                                <th> Waktu Ujian </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody id="exam-data-selesai" style="font-size: 13px;"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Multilingual -->

<script type="text/javascript">
    $(document).ready(function() {
        var id_kelas = "<?= session('id_kelas') ?>";

        function showLoading(targetTbody) {
            var loadingIndicator = '<tr><td colspan="6" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            $(targetTbody).html(loadingIndicator);
        }

        function hideLoading(targetTbody) {
            $(targetTbody).empty();
        }

        function loadExamData(status, targetTbody) {
            showLoading(targetTbody);
            $.ajax({
                url: '/mahasiswa/getExamData/' + encodeURIComponent(id_kelas) + '/' + encodeURIComponent(status),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    hideLoading(targetTbody);
                    var tbody = $(targetTbody);
                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="6" class="text-center">Tidak ada data ujian yang tersedia.</td></tr>');
                    } else {
                        $.each(data, function(index, row) {
                            var currentTime = new Date().getTime();

                            var tr = $('<tr>');
                            tr.append('<td>' + (index + 1) + '</td>');
                            tr.append('<td>' + row.nama_exam + '</td>');
                            tr.append('<td>' + row.nama_matkul + '</td>');
                            tr.append('<td><b>Kelas:</b> ' + row.nama_kelas + '<br><b>Sesi:</b> ' + row.nama_sesi + '</td>');
                            tr.append('<td><b>Tanggal:</b> ' + row.tgl_exam + '<br><b>Jam:</b> ' + row.start_time + '-' + row.end_time + '</td>');

                            // Mengambil waktu mulai ujian dari data
                            var startTime = new Date(row.tgl_exam + ' ' + row.start_time).getTime();

                            if (currentTime < startTime) {
                                // Jika waktu mulai ujian belum tiba, ubah tombol menjadi "Ujian Belum Dimulai"
                                tr.append('<td><span class="badge rounded-pill bg-label-warning">Ujian Belum Dimulai</span></td>');
                            } else if (row.exam_status === 'submitted') {
                                tr.append('<td><span class="badge rounded-pill bg-label-success">Total Score: ' + row.total_score + '</span></td>');
                            } else if (row.status === 'expired') {
                                tr.append('<td><span class="badge rounded-pill bg-label-info">Waktu Exam Sudah Berakhir</span></td>');
                            } else {
                                // Jika waktu mulai ujian sudah tiba, tampilkan tombol "Take Exam"
                                tr.append('<td><a href="javascript:void(0);" class="btn btn-xs btn-primary take-exam-button" data-exam-id="' + row.id_exam + '" data-start-time="' + currentTime + '">Take Exam</a></td>');
                            }

                            tbody.append(tr);
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    hideLoading(targetTbody);
                    $(targetTbody).append('<tr><td colspan="6" class="text-center">Terjadi kesalahan saat memuat data ujian. Silakan coba lagi.</td></tr>');
                }
            });
        }

        loadExamData('publish', '#exam-data-aktif');
        loadExamData('expired', '#exam-data-selesai');

        setInterval(function() {
            loadExamData('publish', '#exam-data-aktif');
            loadExamData('expired', '#exam-data-selesai');
        }, 10000);
    });

    $(document).on('click', '.take-exam-button', function() {
        console.log('Button clicked');
        var examId = $(this).data('exam-id');
        var startTime = parseInt($(this).data('start-time') || 0, 10);
        console.log('exam:', examId, 'startTime:', startTime);
        console.log('Button clicked. Start time:', startTime);


        $.ajax({
            url: '/mahasiswa/setStartTime',
            method: 'POST',
            data: {
                start_time: startTime
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.success) {
                    sessionStorage.setItem('examId', examId);

                    // Redirect ke halaman "takeExam"
                    window.location.href = '/mahasiswa/takeExam/' + examId;
                } else {
                    alert('Gagal menyimpan waktu mulai.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
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