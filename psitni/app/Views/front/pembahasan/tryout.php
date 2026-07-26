<?php
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pembahasan Tryout - Bintang Timur Prestasi</title>
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
            padding-top: 10px !important;
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
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .exam-header-title {
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
            margin-bottom: 4px;
            display: inline-block;
        }

        .tahapan-wrapper {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 6px;
            padding-bottom: 2px;
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
            margin-bottom: 15px;
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

        .question-body-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;
            min-height: 140px;
        }

        .question-text {
            color: #0f172a;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.45;
            margin: 0;
            word-wrap: break-word;
        }

        /* Jawaban Container Overrides */
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
            align-items: flex-start !important;
            width: 100% !important;
            background: #f8fafc !important;
            border: 2px solid #cbd5e1 !important;
            border-radius: 10px !important;
            padding: 10px 14px !important;
            cursor: pointer !important;
            transition: all 0.15s ease-in-out !important;
            color: #1e293b !important;
            font-size: 15px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
            white-space: normal !important;
            margin: 0 !important;
            user-select: none !important;
        }

        .jawaban_dv:hover {
            background: #e2e8f0 !important;
            border-color: #94a3b8 !important;
        }

        .jawaban_dv label {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 28px !important;
            height: 28px !important;
            background: #ffffff !important;
            color: #334155 !important;
            border-radius: 6px !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            margin-right: 10px !important;
            margin-bottom: 0 !important;
            flex-shrink: 0 !important;
            border: 1.5px solid #cbd5e1 !important;
        }

        .jawaban_dv span {
            flex-grow: 1 !important;
            font-size: 15px !important;
            line-height: 1.35 !important;
            color: #1e293b !important;
        }

        .jawaban_dv img {
            max-width: 100% !important;
            border-radius: 6px !important;
            margin-top: 6px !important;
        }

        /* Jawaban Selected State */
        .jawaban_dv[style*="#00a65a"],
        .jawaban_dv[style*="rgb(0, 166, 90)"] {
            background: #dcfce7 !important;
            border: 2px solid #16a34a !important;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.18) !important;
        }

        .jawaban_dv[style*="#00a65a"] label,
        .jawaban_dv[style*="rgb(0, 166, 90)"] label {
            background: #16a34a !important;
            color: #ffffff !important;
            border-color: #16a34a !important;
        }

        /* Action Buttons & Pembahasan */
        #dv_button {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        #dv_button .btn {
            border-radius: 8px !important;
            padding: 8px 20px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
        }

        #dv_button .btn-success {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
            border: none !important;
            color: #ffffff !important;
        }

        #dv_button .btn-success:hover {
            background: linear-gradient(135deg, #15803d 0%, #166534 100%) !important;
            transform: translateY(-1px) !important;
        }

        #dv_pembahasan {
            margin-top: 10px !important;
        }

        #dv_pembahasan button {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25) !important;
            transition: all 0.2s ease !important;
        }

        #dv_pembahasan button:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35) !important;
        }

        #spoiler {
            border: 1px solid #93c5fd !important;
            background-color: #eff6ff !important;
            border-radius: 10px !important;
            padding: 12px !important;
            margin-top: 10px !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08) !important;
        }

        #spoiler img {
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
        }

        #spoiler div {
            border-radius: 8px !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04) !important;
            margin: 8px 0 !important;
            border: 1px solid #e2e8f0;
        }

        /* Navigasi Box Container */
        .box-nosoal-wrapper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-top: 6px;
            margin-bottom: 15px;
            max-height: 460px;
            overflow-y: auto;
        }

        .box-nosoal-title {
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .legend-container {
            display: flex;
            gap: 6px;
            margin-bottom: 10px;
            font-size: 11px;
            font-weight: 600;
            flex-wrap: wrap;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .legend-correct { background: #dcfce7; color: #15803d; }
        .legend-wrong { background: #fee2e2; color: #b91c1c; }
        .legend-active { background: #dbeafe; color: #1d4ed8; }

        #dv_boxnosoal {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
            justify-content: flex-start !important;
            align-items: center !important;
            padding: 2px 0 !important;
        }

        #dv_boxnosoal > div {
            flex: 0 0 calc(20% - 5px) !important; /* 5 columns grid */
            width: auto !important;
            height: 36px !important;
            margin: 0 !important;
            padding: 2px !important;
            border-radius: 6px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            user-select: none !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03) !important;
            text-align: center !important;
            line-height: 1.1 !important;
        }

        #dv_boxnosoal > div:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 3px 6px rgba(0,0,0,0.08) !important;
        }

        /* Green border (Benar) */
        #dv_boxnosoal > div[style*="#3cce3c"],
        #dv_boxnosoal > div[style*="rgb(60, 206, 60)"] {
            background-color: #dcfce7 !important;
            border: 1.5px solid #16a34a !important;
            color: #15803d !important;
        }

        /* Red border (Salah) */
        #dv_boxnosoal > div[style*="red"] {
            background-color: #fee2e2 !important;
            border: 1.5px solid #dc2626 !important;
            color: #b91c1c !important;
        }

        /* Blue border (Current active) */
        #dv_boxnosoal > div[style*="blue"] {
            background-color: #dbeafe !important;
            border: 2.5px solid #2563eb !important;
            color: #1d4ed8 !important;
            font-weight: 700 !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
        }

        /* Responsive Mobile Adjustments */
        @media (max-width: 768px) {
            .content {
                padding-top: 4px !important;
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

            .jawaban_dv {
                padding: 8px 10px !important;
                font-size: 14px !important;
                border-radius: 8px !important;
            }

            .jawaban_dv label {
                width: 24px !important;
                height: 24px !important;
                font-size: 12px !important;
                margin-right: 8px !important;
            }

            .jawaban_dv span {
                font-size: 14px !important;
            }

            .box-nosoal-wrapper {
                padding: 10px;
                margin-top: 6px;
                max-height: 320px;
            }

            #dv_boxnosoal > div {
                flex: 0 0 calc(20% - 5px) !important;
                height: 36px !important;
                font-size: 11px !important;
            }

            #dv_button {
                flex-wrap: wrap;
            }

            #dv_button .btn {
                width: 100%;
                margin-bottom: 5px;
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
                    <div class="row align-items-stretch" style="margin-bottom: 6px;">
                        <!-- Tahapan Ujian Card (matches left col width: col-lg-8 col-md-7) -->
                        <div class="col-lg-8 col-md-7 col-7" style="padding-right: 5px;">
                            <div class="card-exam-header" style="height: 100%;">
                                <div class="exam-header-title">
                                    <i class="fa fa-tasks text-primary" style="margin-right:4px;"></i> Tahapan Ujian
                                </div>
                                <input type="hidden" id="inp_group_id">
                                <div class="tahapan-wrapper">
                                    <?php foreach ($group as $key) : ?>
                                        <div class="tahapan-item <?= ($request->uri->getSegment(4) == $key->group_soal_id) ? 'active' : '' ?>">
                                            <?= $key->group_nm ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Timer Card (matches right col width: col-lg-4 col-md-5) -->
                        <div class="col-lg-4 col-md-5 col-5" style="padding-left: 5px;">
                            <div class="card-timer-header" style="height: 100%;">
                                <span class="timer-label"><i class="fa fa-clock-o" style="margin-right:4px;"></i> Waktu</span>
                                <span id="countdown" class="timer-display">00:00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Row Main Exam Area -->
                    <div class="row">
                        <!-- Left: Question & Answers Box -->
                        <div class="col-lg-8 col-md-7 col-12">
                            <div class="card-soal-main">
                                <span class="no-soal-badge" id="p_no_soal">Soal no. 1</span>

                                <div class="question-body-box">
                                    <p id="inp_soal_nm" class="question-text"></p>
                                    <div id="dv_img_soal" style="margin-top:8px;"></div>
                                    <input type="hidden" value="" id="inp_soal_id">
                                    <input type="hidden" value="1" id="inp_no_soal">
                                    <input type="hidden" value="<?= $used ?>" id="inp_used">
                                    <input type="hidden" value="" id="inp_kolom_id">
                                </div>

                                <div id="dv_main_jawaban">
                                    <!-- Dynamic Jawaban items loaded via AJAX -->
                                </div>

                                <input type="hidden" value="" id="inp_jawaban_id">
                                <input type="hidden" value="" id="inp_pilihan_nm">

                                <div class="row" style="margin-top:15px;">
                                    <div class="col-md-5 col-xs-12" id="dv_button">
                                        <!-- Dynamic buttons loaded via AJAX -->
                                    </div>
                                    <div class="col-md-7 col-xs-12" id="dv_pembahasan">
                                        <!-- Dynamic Pembahasan loaded via AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Box No Soal Grid -->
                        <div class="col-lg-4 col-md-5 col-12">
                            <div class="box-nosoal-wrapper">
                                <div class="box-nosoal-title">
                                    <span><i class="fa fa-th-large text-primary" style="margin-right:4px;"></i> Navigasi Soal</span>
                                </div>
                                <div class="legend-container">
                                    <span class="legend-item legend-correct"><i class="fa fa-check-circle"></i> Benar</span>
                                    <span class="legend-item legend-wrong"><i class="fa fa-times-circle"></i> Salah</span>
                                    <span class="legend-item legend-active"><i class="fa fa-dot-circle-o"></i> Aktif</span>
                                </div>
                                <div id="dv_boxnosoal">
                                    <!-- Dynamic box no soal loaded via AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="d-none" id="loader-wrapper">
            <div class="loader"></div>
        </div>
    </div>

    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
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
        setTimeout(() => {
            startujian("start");
        }, 1000);
    });

    function selectJawaban(jawaban_id, pilihan_nm) {
        let dv = document.getElementsByClassName("jawaban_dv");
        for (let index = 0; index < dv.length; index++) {
            dv[index].style.border = "2px solid #cbd5e1";
        }
        $("#inp_jawaban_id").val(jawaban_id);
        $("#inp_pilihan_nm").val(pilihan_nm);
        let el = document.getElementById("dv_jawaban_" + jawaban_id);
        if (el) {
            el.style.border = "thick solid #00a65a";
        }
    }

    function setboxsoal(no_soal) {
        no_soalx = no_soal + 1;
        $("#inp_no_soal").val(no_soal);
        $("#p_no_soal").text("Soal no. " + no_soal);
        startujian("prev");
    }

    function startujian(proc) {
        let soal_id = $("#inp_soal_id").val();
        let jawaban_id = $("#inp_jawaban_id").val();
        let group_id = <?= $request->uri->getSegment(4) ?>;
        let no_soal = $("#inp_no_soal").val();
        let pilihan_nm = $("#inp_pilihan_nm").val();
        let kolom_id = $("#inp_kolom_id").val();
        let used = $("#inp_used").val();
        let materi = <?= $request->uri->getSegment(3) ?>;
        $.ajax({
            url: "<?= base_url('pembahasan/startujian') ?>",
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
                "used" : used
            },
            beforeSend: function() {
                // $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                if (data.proc == "selesai") {
                    if (group_id == 3) {
                        window.location.href = "<?= base_url() ?>/pembahasan/hasil/" + materi+ "/" + used;
                    } else {
                        let grp_id = group_id + 1;
                        window.location.href = "<?= base_url() ?>/pembahasan/pilihanmateri/" + materi + "/" + grp_id;
                    }
                } else {
                    if (data == "jawaban_kosong") {
                        alert("Jawaban belum dipilih");
                    } else {
                        if (data.group_id == 1 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(2700);
                        } else if (data.group_id == 2 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(5400);
                        } else if (data.group_id == 3 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(2700);
                        } else if (data.group_id == 4 && data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(60);
                        }

                        $("#inp_soal_id").val(data.soal_id);
                        $("#inp_soal_nm").text(data.soal_nm);
                        $("#p_no_soal").text("Soal no. " + data.no_soal);
                        $("#inp_group_id").val(data.group_id);
                        $("#inp_no_soal").val(data.no_soal);
                        $("#inp_kolom_id").val(data.kolom_id);
                        $("#dv_main_jawaban").html(data.jawaban_nm);
                        $("#dv_boxnosoal").html(data.boxnomorsoal);
                        $("#dv_button").html(data.button);
                        $("#dv_pembahasan").html(data.pembahasan);
                        $("#inp_jawaban_id").val("");
                        $("#inp_pilihan_nm").val("");
                        $("#dv_img_soal").html(data.img_soal);
                        setTimeout(() => {
                            selectJawaban(data.jawaban_idx,data.pilihan_nms);
                        }, 10);
                    }
                }

                let dv = document.getElementsByClassName("jawaban_dv");
                for (let index = 0; index < dv.length; index++) {
                    dv[index].style.border = "2px solid #cbd5e1";
                }
            },
            error: function() {
                alert("Error system");
            }
        });
    }

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        return (min < 10 ? '0' + min : min) + ":" + (sec < 10 ? '0' + sec : sec);
    }

    function countdown(detik) {
        var seconds = detik;
        var group_id = <?= $request->uri->getSegment(4) ?>;
        var materi = <?= $request->uri->getSegment(3) ?>;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000); // every second

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds <= 0) {
                let grp_id = group_id + 1;
                window.location.href = "<?= base_url() ?>/pembahasan/pilihanMateri/" + materi + "/" + grp_id;
            }
        }
    }
    </script>
</body>

</html>