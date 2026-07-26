<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Petunjuk Ujian - Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap">
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            background-color: #f1f5f9 !important;
            font-family: 'Inter', 'Source Sans Pro', -apple-system, sans-serif !important;
            color: #1e293b;
        }

        .wrapper {
            display: flex !important;
            flex-direction: column !important;
            min-height: 100vh !important;
        }

        .content-wrapper {
            background-color: #f1f5f9 !important;
            flex: 1 0 auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 10px 15px;
        }

        .main-footer {
            flex-shrink: 0 !important;
        }

        .instruction-card {
            max-width: 520px;
            width: 100%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
            text-align: center;
            margin: 0 auto;
        }

        .icon-header-badge {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
            margin-bottom: 10px;
        }

        .instruction-title {
            font-weight: 700;
            font-size: 18px;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .group-name-pill {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            font-weight: 700;
            font-size: 13px;
            padding: 4px 16px;
            border-radius: 30px;
            margin-bottom: 14px;
        }

        .instruction-body-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 18px;
            text-align: left;
        }

        .instruction-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 8px;
            font-size: 13px;
            line-height: 1.45;
            color: #334155;
        }

        .instruction-item:last-child {
            margin-bottom: 0;
        }

        .instruction-item i {
            color: #16a34a;
            margin-right: 10px;
            font-size: 15px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .btn-start-exam {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 36px !important;
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.3) !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
        }

        .btn-start-exam:hover {
            box-shadow: 0 8px 24px rgba(22, 163, 74, 0.45) !important;
            transform: translateY(-2px);
            color: #ffffff !important;
        }

        /* Modal Token Modern Styling */
        .modal-content {
            border-radius: 16px !important;
            border: none !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
            overflow: hidden;
        }

        .modal-header-custom {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 18px 24px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header-custom h4 {
            margin: 0;
            font-weight: 700;
            font-size: 18px;
        }

        .modal-header-custom .close {
            color: #ffffff;
            opacity: 0.8;
            font-size: 24px;
            outline: none;
        }

        .token-input-field {
            font-size: 24px !important;
            letter-spacing: 6px !important;
            text-align: center !important;
            text-transform: uppercase !important;
            font-weight: 700 !important;
            height: 54px !important;
            border-radius: 12px !important;
            border: 2px solid #cbd5e1 !important;
            transition: all 0.2s ease !important;
        }

        .token-input-field:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
        }

        .btn-token-submit {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            border: none !important;
            border-radius: 12px !important;
            height: 50px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3) !important;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 10px 10px !important;
                min-height: auto !important;
            }
            .instruction-card {
                padding: 16px 14px;
                border-radius: 14px;
            }
            .icon-header-badge {
                width: 48px;
                height: 48px;
                font-size: 22px;
                border-radius: 12px;
                margin-bottom: 10px;
            }
            .instruction-title {
                font-size: 16px;
                margin-bottom: 4px;
            }
            .group-name-pill {
                font-size: 12px;
                padding: 3px 12px;
                margin-bottom: 10px;
            }
            .instruction-body-box {
                padding: 10px 12px;
                margin-bottom: 14px;
                border-radius: 10px;
            }
            .instruction-item {
                font-size: 12px;
                margin-bottom: 6px;
                line-height: 1.35;
            }
            .instruction-item i {
                font-size: 14px;
                margin-right: 8px;
                margin-top: 1px;
            }
            .btn-start-exam {
                width: 100%;
                padding: 10px 16px !important;
                font-size: 15px !important;
            }
        }
    </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <div class="content-wrapper">
            <div class="container d-flex justify-content-center align-items-center">
                <div class="instruction-card">
                    <div class="icon-header-badge">
                        <i class="fa fa-file-text-o"></i>
                    </div>

                    <h3 class="instruction-title">Petunjuk Pengerjaan Soal</h3>
                    <div class="group-name-pill"><?= $group[0]->group_nm ?></div>

                    <div class="instruction-body-box">
                        <div class="instruction-item">
                            <i class="fa fa-hand-o-up text-primary"></i>
                            <span>Untuk menjawab, <b>sentuh / tekan langsung kartu pilihan jawaban</b> yang Anda pilih. Sistem akan otomatis menyimpan jawaban dan melanjut ke soal berikutnya.</span>
                        </div>
                        <div class="instruction-item">
                            <i class="fa fa-check-circle"></i>
                            <span>Pilihlah jawaban yang menurut Anda paling tepat.</span>
                        </div>
                        <div class="instruction-item">
                            <i class="fa fa-clock-o"></i>
                            <span>Saat Anda menekan tombol <b>Mulai Ujian</b>, timer waktu akan langsung berjalan.</span>
                        </div>
                        <div class="instruction-item">
                            <i class="fa fa-info-circle"></i>
                            <span>Pastikan membaca setiap soal dengan teliti. Selamat mengerjakan!</span>
                        </div>
                    </div>

                    <?php
                        if ($group[0]->group_soal_id == 1) {
                            echo "<a onclick='showtoken(".$group[0]->group_soal_id.", ".$materi_id.")' href='javascript:void(0)' class='btn-start-exam'><i class='fa fa-play-circle mr-2'></i> Mulai Ujian</a>";
                        } else {
                            if ($group[0]->group_soal_id == 8) {
                                $url = base_url("tryout/ujianPauli/" . $materi_id . "/" . $group[0]->group_soal_id);
                            } else {
                                $url = base_url("tryout/ujian/" . $materi_id . "/" . $group[0]->group_soal_id);
                            }
                            echo "<a href='" . $url . "' class='btn-start-exam'><i class='fa fa-play-circle mr-2'></i> Mulai Ujian</a>";
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- Modal Token Modern -->
        <div class="modal fade" id="modal-token" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <h4><i class="fa fa-key mr-2 text-warning"></i> Masukkan Token</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label for="token" class="font-weight-bold text-secondary mb-2" style="font-size: 13px;">KODE TOKEN UJIAN</label>
                            <input class="form-control token-input-field" type="text" name="token" id="token" placeholder="******" maxlength="6" minlength="6" autocomplete="off">
                            <input type="hidden" name="group_idx" id="group_idx">
                            <input type="hidden" name="materi_id" id="materi_id">
                        </div>
                        <button class="btn btn-token-submit btn-block mt-3" type="button" onclick="checktoken()"><i class="fa fa-arrow-right mr-1"></i> Verifikasi & Lanjut</button>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include('front/footer') ?>
    </div>

    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#modal-token').on('shown.bs.modal', function () {
                $('#token').focus();
            });
        });

        function showtoken(group_id, materi_id) {
            $("#token").val("");
            $("#group_idx").val(group_id);
            $("#materi_id").val(materi_id);
            $("#modal-token").modal("show");
        }

        function checktoken() {
            var token = $("#token").val();
            var group_id = $("#group_idx").val();
            var materi_id = $("#materi_id").val();
            if (!token) {
                alert("Silakan masukkan token terlebih dahulu");
                return;
            }
            $.ajax({
                url: "<?= base_url('token/checktoken') ?>",
                type: "post",
                dataType: "json",
                data: {
                    "token": token,
                    "group_id": group_id,
                    "materi_id": materi_id
                },
                beforeSend: function() {
                    $("#loader-wrapper").removeClass("d-none");
                },
                success: function(data) {
                    if (data == "sukses") {
                        if (group_id == 8) {
                            window.location.href = "<?= base_url() ?>/tryout/ujianPauli/"+materi_id+"/"+group_id;
                        } else {
                            window.location.href = "<?= base_url() ?>/tryout/ujian/"+materi_id+"/"+group_id;
                        } 
                    } else {
                        alert("Token salah/tidak ada, hubungi administrator");
                    }
                    $("#loader-wrapper").addClass("d-none");
                },
                error: function() {
                    alert("Error system");
                    $("#loader-wrapper").addClass("d-none");
                }
            });
        }
    </script>
</body>

</html>