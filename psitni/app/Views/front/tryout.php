<?php
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Simulasi CAT Psikologi - Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f5f9 !important;
            font-family: 'Inter', 'Source Sans Pro', -apple-system, sans-serif !important;
            color: #1e293b;
        }

        .content-wrapper {
            background-color: #f1f5f9 !important;
            padding-top: 0px !important;
            padding-bottom: 20px;
        }

        .content {
            padding-top: 4px !important;
        }

        .d-none {
            display: none !important;
        }

        #loader-wrapper {
            display: flex;
            position: fixed;
            z-index: 1060;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 0.625em;
            overflow-x: hidden;
            background-color: rgba(253, 253, 253, 0.7);
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3b82f6;
            border-bottom: 8px solid #0284c7;
            width: 48px;
            height: 48px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Header Stage & Timer Cards */
        .card-exam-header {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .exam-header-title {
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
            margin-bottom: 2px;
            display: inline-block;
        }

        .tahapan-wrapper {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 6px;
            padding-top: 2px;
            scroll-behavior: smooth;
        }

        .tahapan-wrapper::-webkit-scrollbar {
            height: 3px;
        }

        .tahapan-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .tahapan-item {
            flex: 0 0 auto;
            padding: 4px 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            white-space: nowrap;
            cursor: pointer;
            background: #f8fafc;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            transition: all 0.2s ease;
        }

        .tahapan-item.active {
            background: #16a34a;
            color: #ffffff;
            border-color: #16a34a;
            box-shadow: 0 2px 6px rgba(22, 163, 74, 0.25);
        }

        .card-timer-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 12px;
            padding: 6px 10px;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .timer-label {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .timer-display {
            font-size: 20px;
            font-weight: 700;
            color: #38bdf8;
            font-family: 'Inter', monospace;
            line-height: 1;
            margin-top: 1px;
        }

        /* Main Soal Card */
        .card-soal-main {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-top: 6px;
        }

        .soal-materi-tag {
            display: inline-block;
            background: #f1f5f9;
            color: #334155;
            font-weight: 600;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            margin-bottom: 8px;
        }

        .question-body-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;
            min-height: 200px !important;
        }

        .no-soal-badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0284c7;
            font-weight: 700;
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 6px;
        }

        .question-text {
            color: #0f172a;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.45;
            margin: 0;
            word-wrap: break-word;
        }

        /* Instruction Hint for Choices */
        .pilihan-instruction-hint {
            font-size: 12px;
            font-weight: 600;
            color: #1d4ed8;
            background: #eff6ff;
            border: 1.5px dashed #93c5fd;
            border-radius: 8px;
            padding: 6px 12px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        /* Answer Choices Area */
        #dv_main_jawaban {
            display: flex !important;
            flex-direction: column !important;
            gap: 8px !important;
            margin-top: 6px !important;
            margin-bottom: 10px !important;
            width: 100% !important;
        }

        .jawaban_dv {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            background: #f1f5f9 !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            cursor: pointer !important;
            transition: all 0.15s ease-in-out !important;
            color: #1e293b !important;
            font-size: 15px !important;
            min-height: 46px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
            position: relative !important;
            user-select: none !important;
        }

        .jawaban_dv:hover {
            background: #e2e8f0 !important;
            border-color: #94a3b8 !important;
        }

        .jawaban_dv:active {
            transform: scale(0.99);
        }

        .jawaban_dv.selected {
            background: #dcfce7 !important;
            border-color: #16a34a !important;
            color: #14532d !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.18) !important;
        }

        .pilihan-letter {
            width: 28px !important;
            height: 28px !important;
            border-radius: 6px !important;
            background: #ffffff !important;
            color: #334155 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            margin-right: 10px !important;
            flex-shrink: 0 !important;
            border: 1.5px solid #cbd5e1 !important;
            transition: all 0.15s ease !important;
        }

        .jawaban_dv.selected .pilihan-letter {
            background: #16a34a !important;
            color: #ffffff !important;
            border-color: #16a34a !important;
        }

        .jawaban-text {
            flex-grow: 1;
            font-size: 15px;
            line-height: 1.35;
        }

        .tap-indicator-icon {
            margin-left: auto;
            font-size: 13px;
            color: #94a3b8;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .jawaban_dv:hover .tap-indicator-icon {
            color: #2563eb;
            transform: translateX(2px);
        }

        .jawaban_dv.selected .tap-indicator-icon {
            color: #16a34a;
        }

        #dv_main_jawaban.horizontal_layout {
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        #dv_main_jawaban.horizontal_layout .jawaban_dv {
            width: auto !important;
            flex: 1 1 0px !important;
            min-width: 130px !important;
            justify-content: center !important;
            text-align: center !important;
        }

        .btn-selesai-custom {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3) !important;
            transition: all 0.2s ease !important;
        }

        /* Box No Soal Container */
        .box-nosoal-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-top: 6px;
            max-height: 460px;
            overflow-y: auto;
        }

        .box-nosoal-wrapper::-webkit-scrollbar {
            width: 5px;
        }

        .box-nosoal-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .box-nosoal-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .box-nosoal-grid {
            display: grid !important;
            grid-template-columns: repeat(5, 1fr) !important;
            gap: 6px !important;
        }

        .box-item-nosoal {
            height: 36px !important;
            border-radius: 6px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            text-decoration: none !important;
        }

        .box-item-nosoal.unanswered {
            background: #fff1f2 !important;
            border: 1.5px solid #fca5a5 !important;
            color: #991b1b !important;
        }

        .box-item-nosoal.answered {
            background: #f0fdf4 !important;
            border: 1.5px solid #86efac !important;
            color: #166534 !important;
        }

        .box-item-nosoal.active {
            background: #eff6ff !important;
            border: 2.5px solid #2563eb !important;
            color: #1e40af !important;
            font-weight: 700 !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
        }

        /* Compact Mobile Rules */
        @media (max-width: 768px) {
            .content-wrapper {
                padding-top: 0px !important;
                padding-bottom: 10px;
            }
            .card-exam-header {
                padding: 6px 8px;
                border-radius: 10px;
            }
            .exam-header-title {
                font-size: 11px;
                margin-bottom: 2px;
            }
            .card-timer-header {
                padding: 6px 8px;
                border-radius: 10px;
                flex-direction: row !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 8px;
            }
            .timer-label {
                font-size: 11px;
                margin-bottom: 0 !important;
            }
            .timer-display {
                font-size: 16px;
                margin-top: 0 !important;
            }
            .tahapan-item {
                padding: 4px 8px;
                font-size: 11px;
                border-radius: 6px;
            }
            .card-soal-main {
                padding: 10px;
                margin-top: 4px;
                border-radius: 10px;
            }
            .question-body-box {
                padding: 10px;
                margin-bottom: 8px;
                border-radius: 8px;
                min-height: 200px !important;
            }
            .no-soal-badge {
                font-size: 11px;
                padding: 2px 8px;
                margin-bottom: 4px;
            }
            .question-text {
                font-size: 14px;
                line-height: 1.35;
            }
            .pilihan-instruction-hint {
                font-size: 11px;
                padding: 4px 8px;
                margin-bottom: 6px;
            }
            .jawaban_dv {
                padding: 8px 10px !important;
                font-size: 14px !important;
                min-height: 42px !important;
                border-radius: 8px !important;
            }
            .pilihan-letter {
                width: 24px !important;
                height: 24px !important;
                font-size: 12px !important;
                margin-right: 8px !important;
                border-radius: 5px !important;
            }
            .box-nosoal-wrapper {
                padding: 10px;
                margin-top: 6px;
                max-height: 320px;
            }
            .btn-selesai-custom {
                width: 100%;
                margin-left: 0 !important;
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
            <div class="container">
                <section class="content">

                    <!-- Row Top Header: Tahapan & Waktu -->
                    <div class="row align-items-stretch">
                        <!-- Tahapan Ujian Card -->
                        <div class="col-lg-8 col-md-7 col-7 pr-1">
                            <div class="card-exam-header h-100">
                                <?php
                                    $db = \Config\Database::connect();
                                    $materi_row = $db->table('materi')->where('materi_id', $soal[0]->materi)->get()->getRow();
                                    $materi_nm = $materi_row ? $materi_row->materi_nm : '';
                                ?>
                                <span class="exam-header-title"><i class="fa fa-tasks text-primary mr-1"></i> Ujian <?= $materi_nm ?></span>
                                <input type="hidden" id="inp_group_id">
                                <!-- Wrapper Scroll -->
                                <div class="tahapan-wrapper">
                                    <?php 
                                    $active_group_id = $request->uri->getSegment(4);
                                    if (empty($active_group_id) && isset($soal[0])) {
                                        $active_group_id = $soal[0]->group_id;
                                    }
                                    foreach ($group as $key) { ?>
                                        <div class="tahapan-item <?= ($active_group_id == $key->group_soal_id ? 'active' : '') ?>">
                                            <?= $key->group_nm ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <!-- Timer Card -->
                        <div class="col-lg-4 col-md-5 col-5 pl-1">
                            <div class="card-timer-header h-100">
                                <span class="timer-label"><i class="fa fa-clock-o mr-1"></i> Waktu</span>
                                <div class="timer-display" id="countdown">00:00</div>
                            </div>
                        </div>
                    </div>

                    <!-- Row Main Exam Area -->
                    <div class="row">
                        <!-- Left: Question & Answers Box -->
                        <div class="col-lg-8 col-md-7 col-12">
                            <div class="card-soal-main">

                                <!-- Question Box -->
                                <div class="question-body-box">
                                    <span id="p_no_soal" class="no-soal-badge">Soal No. <?= $soal[0]->no_soal ?></span>
                                    <div id="inp_soal_nm" class="question-text"></div>
                                    <div id="dv_img_soal" style="margin-top: 8px;"></div>
                                    <input type="hidden" value="<?= $soal[0]->soal_id ?>" id="inp_soal_id">
                                    <input type="hidden" value="1" id="inp_no_soal">
                                    <input type="hidden" value="<?= $soal[0]->kolom_id ?>" id="inp_kolom_id">
                                </div>

                                <?php
                                    $is_img_jawaban = false;
                                    foreach ($jawaban as $jwb) {
                                        if (!empty($jwb->jawaban_img)) {
                                            $is_img_jawaban = true;
                                            break;
                                        }
                                    }
                                ?>
                                <div id="dv_main_jawaban" class="<?= $is_img_jawaban ? 'horizontal_layout' : '' ?>">
                                    <?php
                                        foreach ($jawaban as $key) {
                                            $img_jwb = "";
                                            if (!empty($key->jawaban_img)) {
                                                $img_jwb = "<img style='max-width:300px;height:100%;' class='img-fluid rounded mt-2' src='".base_url()."/images/jawaban/materi/".$soal[0]->materi."/group/".$soal[0]->group_id."/".$key->jawaban_img."'>";
                                            }
                                    ?>
                                    <div id="dv_jawaban_<?= $key->jawaban_id ?>"
                                        onclick="selectJawaban(<?= $key->jawaban_id ?>,'<?= $key->pilihan_nm ?>')"
                                        class="jawaban_dv">
                                        <span class="pilihan-letter"><?= $key->pilihan_nm ?></span>
                                        <span class="jawaban-text"><?= $key->jawaban_nm ?></span>
                                        <div><?= $img_jwb ?></div>
                                        <i class="fa fa-chevron-right tap-indicator-icon"></i>
                                    </div>
                                    <?php } ?>
                                </div>
                                <input type="hidden" value="" id="inp_jawaban_id">
                                <input type="hidden" value="" id="inp_pilihan_nm">

                                <div id="dv_button">
                                    <!-- Action buttons -->
                                </div>
                            </div>
                        </div>

                        <!-- Right: Box No Soal Grid -->
                        <div class="col-lg-4 col-md-5 col-12">
                            <div class="box-nosoal-wrapper box-nosoal-container">
                                <div style="font-weight: 700; font-size: 13px; margin-bottom: 10px; color: #0f172a;">
                                    <i class="fa fa-th-large text-primary mr-1"></i> Navigasi Soal
                                </div>
                                <div id="dv_boxnosoal" class="box-nosoal-grid">
                                    <!-- Box items -->
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>

        <div class="d-none" id='loader-wrapper'>
            <div class="loader"></div>
        </div>
    </div>

    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>
    <script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true,
            wrapping: false
        });
    });

    var timers;
    $(document).ready(function() {
        // Auto-scroll stage tab into view
        setTimeout(() => {
            let activeTab = document.querySelector('.tahapan-item.active');
            if (activeTab) {
                activeTab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }, 100);

        setTimeout(() => {
            startujian("start");
        }, 800);
    });

    function selectJawaban(jawaban_id, pilihan_nm, autoNext = true) {
        let dv = document.getElementsByClassName("jawaban_dv");
        for (let index = 0; index < dv.length; index++) {
            dv[index].classList.remove("selected");
        }
        $("#inp_jawaban_id").val(jawaban_id);
        $("#inp_pilihan_nm").val(pilihan_nm);
        let el = document.getElementById("dv_jawaban_" + jawaban_id);
        if (el) {
            el.classList.add("selected");
        }

        // Ketika jawaban diklik oleh siswa, otomatis lanjut ke soal berikutnya (Auto-Next)
        if (autoNext && jawaban_id && pilihan_nm) {
            setTimeout(() => {
                startujian("next");
            }, 120);
        }
    }

    function setboxsoal(no_soal) {
        $("#inp_no_soal").val(no_soal);
        $("#p_no_soal").text("Soal No. " + no_soal);
        startujian("prev");
    }

    function startujian(proc) {
        let soal_id = $("#inp_soal_id").val();
        let jawaban_id = $("#inp_jawaban_id").val();
        let group_id = <?= $request->uri->getSegment(4) ?>;
        let no_soal = $("#inp_no_soal").val();
        let pilihan_nm = (group_id == 7 && parseInt(no_soal) >= 11 && parseInt(no_soal) <= 20) ? $("#inp_pilihan_nm_7").val() : $("#inp_pilihan_nm").val();
        let kolom_id = $("#inp_kolom_id").val();
        let materi = <?= $request->uri->getSegment(3) ?>;
        let waktu = document.getElementById('countdown').textContent;
        $.ajax({
            url: "<?= base_url('tryout/startujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "group_id": group_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "kolom_id": kolom_id,
                "materi": materi,
                "proc": proc,
                "waktu": waktu
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.status == "jawaban_kosong" || data == "jawaban_kosong") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jawaban Belum Dipilih',
                        text: 'Silakan pilih salah satu jawaban terlebih dahulu sebelum melanjutkan.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else if (data.proc == "selesai") {
                    let grp_id = group_id + 1;
                    window.location.href = "<?= base_url() ?>/materi/pilihanMateri/" + materi + "/" + grp_id;
                } else {
                    if (data.no_soal == 1) {
                        window.clearInterval(timers);
                        countdown(600);
                    }

                    $("#inp_soal_id").val(data.soal_id);
                    $("#inp_soal_nm").text(data.soal_nm);
                    $("#p_no_soal").text("Soal No. " + data.no_soal);
                    $("#inp_group_id").val(data.group_id);
                    $("#inp_no_soal").val(data.no_soal);
                    $("#inp_kolom_id").val(data.kolom_id);

                    // 1. Build Jawaban HTML
                    let jawabanHtml = "";
                    $("#dv_main_jawaban").removeClass("horizontal_layout");
                    if (data.group_id == 7 && parseInt(data.no_soal) >= 11 && parseInt(data.no_soal) <= 20) {
                        jawabanHtml = `<div class='jawaban_dv' style='padding: 10px;'>
                            <input type='text' class='form-control' name='inp_pilihan_nm_7' id='inp_pilihan_nm_7' placeholder='Ketik jawaban di sini...' autocomplete='off' value='${data.pilihan_nmx || ""}' style='color:#000;font-size:16px;height:45px;'>
                        </div>`;
                    } else {
                        if (data.jawaban_list) {
                            let isImageAnswer = data.jawaban_list.some(key => key.jawaban_img);
                            if (isImageAnswer) {
                                $("#dv_main_jawaban").addClass("horizontal_layout");
                            }
                            data.jawaban_list.forEach(key => {
                                let isSelected = (data.pilihan_nms == key.pilihan_nm) ? "selected" : "";
                                let img_jwb = "";
                                if (key.jawaban_img) {
                                    img_jwb = `<img style='max-width:300px;height:100%;' class='img-fluid rounded mt-2' src='${data.base_url}/images/jawaban/materi/${data.soal.materi}/group/${data.group_id}/${key.jawaban_img}'>`;
                                }
                                jawabanHtml += `
                                    <div id='dv_jawaban_${key.jawaban_id}' 
                                        onclick='selectJawaban(${key.jawaban_id},"${key.pilihan_nm}")' 
                                        class='jawaban_dv ${isSelected}'>
                                        <span class='pilihan-letter'>${key.pilihan_nm}</span>
                                        <span class='jawaban-text'>${key.jawaban_nm}</span>
                                        <div>${img_jwb}</div>
                                        <i class='fa fa-chevron-right tap-indicator-icon'></i>
                                    </div>`;
                            });
                        }
                    }
                    $("#dv_main_jawaban").html(jawabanHtml);

                    // 2. Build Box No Soal HTML
                    let boxHtml = "";
                    if (data.box_list) {
                        data.box_list.forEach(boxsoal => {
                            let stateClass = boxsoal.has_respon ? "answered" : "unanswered";
                            if (boxsoal.no_soal == data.no_soal) {
                                stateClass += " active";
                            }
                            let pilihan_nm_txt = boxsoal.has_respon ? " " + boxsoal.pilihan_nm : "";
                            boxHtml += `<div class='box-item-nosoal ${stateClass}' onclick='setboxsoal(${boxsoal.no_soal})'>${boxsoal.no_soal}${pilihan_nm_txt}</div>`;
                        });
                    }
                    $("#dv_boxnosoal").html(boxHtml);
                    
                    setTimeout(() => {
                        let container = document.querySelector(".box-nosoal-wrapper");
                        let activeBox = document.querySelector("#dv_boxnosoal .box-item-nosoal.active");
                        if (container && activeBox) {
                            let boxTop = activeBox.offsetTop - container.offsetTop;
                            container.scrollTop = boxTop - 10;
                        }
                    }, 50);

                    // 3. Build Button HTML (Tombol Next dihapus; hanya tampilkan Selesai jika di soal terakhir atau isian)
                    let buttonHtml = "";
                    if (data.jumlah_jawab >= data.total_soal_count - 1 || data.no_soal == data.total_soal_count) {
                        buttonHtml = `<button onclick='startujian("selesai")' class='btn btn-selesai-custom btn-block'><i class='fa fa-check-circle mr-1'></i> Selesai Ujian</button>`;
                    } else if (data.group_id == 7 && parseInt(data.no_soal) >= 11 && parseInt(data.no_soal) <= 20) {
                        buttonHtml = `<button onclick='startujian("next")' class='btn btn-primary btn-block'><i class='fa fa-arrow-right mr-1'></i> Lanjut</button>`;
                    }
                    $("#dv_button").html(buttonHtml);

                    $("#inp_jawaban_id").val("");
                    $("#inp_pilihan_nm").val("");

                    // 4. Build Image Soal HTML
                    let imgSoalHtml = "";
                    if (data.soal && data.soal.soal_img) {
                        imgSoalHtml = `
                            <a href='${data.base_url}/images/soal/materi/${data.soal.materi}/group/${group_id}/besar/${data.soal.soal_img}' data-toggle='lightbox'>
                                <img style='max-width: 100%; max-height: 250px; margin-top: 8px;' src='${data.base_url}/images/soal/materi/${data.soal.materi}/group/${group_id}/${data.soal.soal_img}' class='img-fluid rounded'>
                            </a>`;
                    }
                    $("#dv_img_soal").html(imgSoalHtml);

                    setTimeout(() => {
                        selectJawaban(data.jawaban_idx, data.pilihan_nms, false);
                        if ($("#inp_pilihan_nm_7").length > 0) {
                            setTimeout(function() {
                                $("#inp_pilihan_nm_7").focus();
                            }, 50);
                        }
                    }, 10);
                }

            },
            error: function() {
                alert("Error system");
            }
        });
    }

    $(document).on('keypress', '#inp_pilihan_nm_7', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            startujian("next");
        }
    });

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        if (sec < 10) {
            sec = "0" + sec;
        }
        if (min < 10) {
            min = "0" + min;
        }
        return min + ":" + sec;
    }

    function countdown(detik) {
        var seconds = detik;
        var group_id = <?= $request->uri->getSegment(4) ?>;
        var materi = <?= $request->uri->getSegment(3) ?>;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000);

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds === 0) {
                let grp_id = group_id + 1;
                window.location.href = "<?= base_url() ?>/materi/pilihanMateri/" + materi + "/" + grp_id;
            }
        }
    }
    </script>
</body>

</html>