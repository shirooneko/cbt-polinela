<?= $this->extend('mahasiswa/layoutExam') ?>
<?= $this->section('content') ?>

<!-- Multilingual -->
<div class="row">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header">
                Detail Ujian
            </div>
            <div class="card-body">
                <table class="table table-stripted">
                    <tbody style="font-size: 13px;">
                        <tr>
                            <td><b>Nama Ujian</b></td>
                            <td><?= $dataExam['nama_exam'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Kelas</b></td>
                            <td><?= $dataExam['nama_kelas']  ?></td>
                        </tr>
                        <tr>
                            <td><b>Sesi</b></td>
                            <td><?= $dataExam['nama_sesi']  ?></td>
                        </tr>
                        <tr>
                            <td><b>Mata Kuliah</b></td>
                            <td><?= $dataExam['nama_matkul'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Sisa Waktu</b></td>
                            <td > <h1 class="badge bg-danger mb-0" id="countdown-timer"></h1></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">

        <div class="mb-1 mt-2">
            <span class="badge rounded-pill bg-secondary mb-3">Navigasi Soal</span>
            <ul class="list-inline">
                <?php foreach ($questionOrder as $index => $questionNumber) : ?>
                    <li class="list-inline-item mb-2">
                        <?php
                        // Temukan id_question berdasarkan nomor_soal
                        $questionId = null;
                        foreach ($allQuestions as $question) {
                            if ($question['nomor_soal'] == $questionNumber) {
                                $questionId = $question['id_question'];
                                break;
                            }
                        }
                        $isAnswered = array_key_exists($questionId, $answers) && !is_null($answers[$questionId]);
                        $tooltipText = $isAnswered ? 'Dijawab' : 'Belum Dijawab';

                        // Ganti link sesuai kebutuhan Anda
                        $link = base_url('mahasiswa/gotoQuestion/' . $id . '/' . $index);
                        ?>
                        <a href="<?= $link; ?>" class="btn <?= ((int)$currentOrderIndex === (int)$index) ? 'btn-primary active' : ($isAnswered ? 'btn-success' : 'btn-outline-primary'); ?>" data-toggle="tooltip" data-placement="top" title="<?= $tooltipText; ?>">
                            <?= $index + 1; ?> <!-- Menampilkan nomor soal -->
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Aktivasi Bootstrap Tooltip -->
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip();
            })
        </script>

        <div class="">
            <?php $i = 1;
            if ($singleQuestion !== null) : ?>
                <div class="card mb-3">
                    <div class="card-header">
                    <h1 class="badge rounded-pill bg-danger" id="countdown-timer"></h1>
                    </div>
                    <div class="card-body">

                        <!-- menampilkan soal -->
                        <h5 class="fw-bold mb-4"><?= ($currentOrderIndex + 1) . '. ' . strip_tags($singleQuestion['soal'], '<strong><em><u><ol><ul><li><img><a>'); ?></h5>

                        <!-- Menampilkan gambar soal jika ada -->
                        <?php if (!empty($singleQuestion['gambar_soal'])) : ?>
                            <div class="mt-2 mb-4">
                                <a href="<?= base_url('assets/images/exam/soal/' . $singleQuestion['gambar_soal']); ?>" data-lightbox="soal">
                                    <img src="<?= base_url('assets/images/exam/soal/' . $singleQuestion['gambar_soal']); ?>" alt="Gambar Soal" class="img-responsive" width="200" title="Klik untuk memperbesar gambar">
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Tampilkan pilihan jawaban -->
                        <?php $pilihan = json_decode($singleQuestion['pilihan'], true); ?>
                        <?php $gambar_pilihan = json_decode($singleQuestion['gambar_pilihan'], true); ?>
                        <?php foreach ($pilihan as $key => $value) : ?>
                            <?php
                            $jawabanKey = 'jawaban_' . $id . '_' . $singleQuestion['id_question'] . '_' . session('id_mahasiswa');
                            $jawabanTersimpan = session($jawabanKey);
                            $checked = ($jawabanTersimpan == $key) ? 'checked' : '';
                            ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="jawaban_<?= $singleQuestion['id_question']; ?>" id="jawaban_<?= $key; ?>" value="<?= $key; ?>" <?= $checked; ?> required>
                                <label class="form-check-label" for="jawaban_<?= $key; ?>">
                                    <?= $key; ?>. <?= $value; ?>
                                    <!-- Menampilkan gambar pilihan jika ada -->
                                    <?php if (!empty($gambar_pilihan[$key])) : ?>
                                        <a href="<?= base_url('assets/images/exam/pilihan/' . $gambar_pilihan[$key]); ?>" data-lightbox="pilihan-<?= $singleQuestion['id_question']; ?>">
                                            <img src="<?= base_url('assets/images/exam/pilihan/' . $gambar_pilihan[$key]); ?>" alt="Gambar Pilihan <?= $key; ?>" class="img-responsive" width="150" title="Klik untuk memperbesar gambar">
                                        </a>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($jawabanTersimpan) : ?>
                            <button type="button" id="clearAnswerButton" class="btn btn-xs btn-warning mt-5">Bersihkan Jawaban Saya</button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div class="btn-group">
                        <!-- Tombol Sebelumnya -->
                        <a href="<?= $currentOrderIndex > 0 ? base_url('mahasiswa/previousQuestion/' . $id) : '#'; ?>" class="btn btn-primary <?= $currentOrderIndex > 0 ? '' : 'disabled'; ?>">
                            <i class="mdi mdi-chevron-left text-lg me-2"></i>
                        </a>

                        <!-- Tombol Selanjutnya -->
                        <a href="<?= $currentOrderIndex < $totalQuestions - 1 ? base_url('mahasiswa/nextQuestion/' . $id) : '#'; ?>" class="btn btn-primary <?= $currentOrderIndex < $totalQuestions - 1 ? '' : 'disabled'; ?>">
                            <i class="mdi mdi-chevron-right text-lg me-2"></i>
                        </a>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="button" class="btn btn-success <?= $currentOrderIndex == $totalQuestions - 1 ? '' : 'disabled'; ?>" id="reviewModalButton" data-bs-toggle="modal" data-bs-target="#reviewAnswer<?= $id ?>" <?= $currentOrderIndex == $totalQuestions - 1 ? '' : 'disabled'; ?>>
                        Submit
                    </button>
                </div>

            <?php else : ?>
                <p>Belum ada pertanyaan yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Modal Review -->
<div class="modal fade" id="reviewAnswer<?= $id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalCenterTitle">Exam Status</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Soal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allQuestions as $index => $question) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= strip_tags($question['soal'], '<strong><em><u><ol><ul><li><img><a>') ?></td>
                                <td>
                                    <?php if (isset($answers[$question['id_question']])) : ?>
                                        <span class="badge bg-success">Sudah Dijawab</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger">Belum Dijawab</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <a href="<?= base_url('mahasiswa/submitAnswer/' . $id . '/' . $singleQuestion['id_question']); ?>" id="submitBtn" class="btn btn-success">Ya, Submit</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var remainingSeconds = <?= $remaining_seconds ?>;
        var countdownElement = document.getElementById('countdown-timer');
        var id_exam = "<?= $id; ?>";

        function checkAnswerSelected() {
            $('#clearAnswerButton').toggle($('input[type=radio]:checked').length > 0);
        }

        function sendAjaxRequest(url, data, successCallback) {
            $.ajax({
                url: url,
                method: "POST",
                data: data,
                success: successCallback,
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
        }

        function showModalOnReload() {
            var showModal = sessionStorage.getItem('showModal');
            if (showModal === 'true') {
                var modal = new bootstrap.Modal(document.getElementById('reviewAnswer' + id_exam));
                modal.show();
                sessionStorage.removeItem('showModal');
            }
        }

        function autoSubmitExam() {
            Swal.fire({
                title: 'Waktu Habis!',
                text: 'Ujian akan dikumpulkan secara otomatis.',
                icon: 'warning',
                showConfirmButton: false, // Tambahkan baris ini
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                timer: 3000,
                didClose: function() {
                    var submitUrl = document.querySelector('#submitBtn').getAttribute('href');
                    window.location.href = submitUrl;
                }
            });
        }

        $('input[type=radio]').on('change', function() {
            var jawaban = $(this).val();
            var id_question = $(this).attr('name').split('_')[1];
            checkAnswerSelected();
            sendAjaxRequest("<?= base_url('mahasiswa/saveAnswer/' . $id); ?>", {
                jawaban: jawaban,
                id_question: id_question
            }, console.log);
        });

        $('#clearAnswerButton').on('click', function() {
            var id_question = $('input[type=radio]:checked').attr('name').split('_')[1];
            $('input[type=radio]:checked').prop('checked', false);
            checkAnswerSelected();
            sendAjaxRequest("<?= base_url('mahasiswa/clearAnswer/' . $id); ?>", {
                id_question: id_question
            }, console.log);
        });

        $('#reviewModalButton').on('click', function() {
            sessionStorage.setItem('showModal', 'true');
            location.reload();
        });

        var interval = setInterval(function() {
            remainingSeconds--;
            var hours = Math.floor(remainingSeconds / 3600);
            var minutes = Math.floor((remainingSeconds % 3600) / 60);
            var seconds = remainingSeconds % 60;
            countdownElement.textContent = (hours < 10 ? '0' + hours : hours) + ':' + (minutes < 10 ? '0' + minutes : minutes) + ':' + (seconds < 10 ? '0' + seconds : seconds);
            if (remainingSeconds <= 0) {
                clearInterval(interval);
                autoSubmitExam();
            }
        }, 1000);

        checkAnswerSelected();
        showModalOnReload();
    });
</script>


<?= $this->endSection() ?>