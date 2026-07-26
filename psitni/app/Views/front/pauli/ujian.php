<?php
$request = \Config\Services::request();
$db = \Config\Database::connect();
$materi_row = $db->table('materi')->where('materi_id', $materi_id)->get()->getRow();
$materi_nm = $materi_row ? $materi_row->materi_nm : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tes Pauli - Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.css">
    <link rel="icon" href="images/bg/favicon.ico" type="image/gif">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Sans+Pro:wght@400;600;700&display=swap">
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
            padding-top: 10px !important;
            padding-bottom: 20px;
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

        /* Timer Box Header */
        .card-pauli-timer {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 14px;
            padding: 10px 16px;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
            text-align: center;
            max-width: 480px;
            margin: 0 auto 10px auto;
        }

        .pauli-timer-label {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }

        .pauli-timer-display {
            font-size: 26px;
            font-weight: 700;
            color: #38bdf8;
            font-family: 'Inter', monospace;
            line-height: 1.1;
            margin-top: 2px;
        }

        /* Main Pauli Area Card */
        .card-pauli-main {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
            max-width: 480px;
            margin: 0 auto;
            text-align: center;
        }

        .pauli-header-title {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            font-weight: 700;
            font-size: 13px;
            padding: 5px 14px;
            border-radius: 20px;
            margin-top: 2px;
            margin-bottom: 6px;
        }

        /* Question Numbers Boxes */
        .pauli-soal-wrapper {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 10px !important;
            margin-top: 12px !important;
            margin-bottom: 16px !important;
        }

        .pauli-num-box {
            background: linear-gradient(135deg, #475569 0%, #334155 100%) !important;
            color: #ffffff !important;
            width: 82px !important;
            height: 82px !important;
            font-size: 52px !important;
            font-weight: 800 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 14px !important;
            box-shadow: 0 6px 16px rgba(0,0,0,0.14) !important;
            font-family: 'Inter', monospace !important;
            user-select: none !important;
        }

        /* Numpad Keypad Grid */
        .pauli-numpad-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 12px !important;
            max-width: 320px !important;
            margin: 14px auto 8px auto !important;
            justify-content: center !important;
        }

        .pauli-numpad-btn {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            color: #ffffff !important;
            font-size: 32px !important;
            font-weight: 700 !important;
            border: none !important;
            border-radius: 14px !important;
            height: 62px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3) !important;
            transition: all 0.1s ease !important;
            user-select: none !important;
            -webkit-tap-highlight-color: transparent !important;
            cursor: pointer !important;
        }

        .pauli-numpad-btn:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4) !important;
        }

        .pauli-numpad-btn:active {
            transform: scale(0.94) !important;
        }

        .numpad-btn-zero {
            grid-column: 2 !important;
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding-top: 6px !important;
                padding-bottom: 10px;
            }
            .card-pauli-timer {
                padding: 8px 12px;
                border-radius: 12px;
                margin-bottom: 8px;
            }
            .pauli-timer-label {
                font-size: 10px;
            }
            .pauli-timer-display {
                font-size: 22px;
            }
            .card-pauli-main {
                padding: 12px 10px;
                border-radius: 14px;
            }
            .pauli-header-title {
                font-size: 12px;
                padding: 4px 12px;
                margin-bottom: 4px;
            }
            .pauli-num-box {
                width: 74px !important;
                height: 74px !important;
                font-size: 46px !important;
                border-radius: 12px !important;
            }
            .pauli-numpad-grid {
                gap: 10px !important;
                max-width: 290px !important;
                margin-top: 10px !important;
            }
            .pauli-numpad-btn {
                height: 56px !important;
                font-size: 28px !important;
                border-radius: 12px !important;
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
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Timer Box Header -->
                            <div class="card-pauli-timer">
                                <span class="pauli-timer-label"><i class="fa fa-clock-o mr-1"></i> Waktu</span>
                                <div class="pauli-timer-display" id="countdown">00:00</div>
                            </div>

                            <!-- Main Pauli Area Card -->
                            <div class="card-pauli-main">
                                <div id="lb_kolom" class="pauli-header-title">
                                    <?= $materi_nm ?> - Kolom
                                </div>

                                <div id="dv_soal">
                                    <!-- Dynamic Soal & Numpad Render -->
                                </div>

                                <div id="dv_button" class="mt-2"></div>
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
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>
    <script>
    var timers;
    const materi_nm = "<?= $materi_nm ?>";
    $(document).ready(function() {
        setTimeout(() => {
            startujian("start","","","",<?= $request->uri->getSegment(4) ?>,0,1,<?= $request->uri->getSegment(3) ?>,1);
        }, 1000);

        $(document).on('keydown', function (e) {
            if (e.keyCode >= 48 && e.keyCode <= 57) {
                let angka = e.key;
                let btn = $(".tombol_pauli").filter(function () {
                    return $(this).text().trim() === angka;
                });

                if (btn.length > 0) {
                    btn.click();
                }
                e.preventDefault();
            }
        });
    });

    function renderSoal(data) {
        let soal = data.data_soal.soal_nm
                    .replace(/\s+/g,'')
                    .replace(/\+/g,'')
                    .split('');

        let html = `<div class="pauli-soal-wrapper">`;

        soal.forEach(function(item){
            html += `
            <div class="pauli-num-box">
                ${item}
            </div>`;
        });

        html += `</div><div class="pauli-numpad-grid">`;

        data.data_soal.jawaban.forEach(function(j){
            let isZero = (j.pilihan_nm.trim() === "0");
            let zeroClass = isZero ? "numpad-btn-zero" : "";
            html += `
            <button onclick='startujian(
                "next",
                "${j.pilihan_nm}",
                ${j.jawaban_id},
                ${data.data_soal.soal_id},
                ${data.group_id},
                ${data.no_soal},
                ${data.kolom_id},
                <?= $request->uri->getSegment(3) ?>,
                ${data.sk_group_id}
            )'
            class='btn pauli-numpad-btn ${zeroClass} tombol_pauli'>
                ${j.pilihan_nm}
            </button>`;
        });

        html += `</div>`;

        $("#dv_soal").html(html);
        $("#lb_kolom").text(materi_nm + " - Lembar " + data.sk_group_id + " - Kolom " + data.kolom_id + " - Pertanyaan " + data.no_soal);
    }

    function startujian(proc,pilihan_nm,jawaban_id,soal_id,group_id,no_soal,kolom_id,materi,sk_group_id) {
        $.ajax({
            url: "<?= base_url('tryout/pauliujian') ?>",
            type: "post",
            dataType: "json",
            data: {
                "proc": proc,
                "jawaban_id": jawaban_id,
                "soal_id": soal_id,
                "no_soal": no_soal,
                "pilihan_nm": pilihan_nm,
                "group_id": group_id,
                "materi": materi,
                "kolom_id": kolom_id,
                "sk_group_id": sk_group_id
            },
            beforeSend: function() {
            },
            success: function(data) {
                if (data.ret === "persiapan") {
                    window.clearInterval(timers);
                    timers = null;
                    $("#lb_kolom").text("Persiapan . . .");
                    $("#dv_soal").html("");
                    countdown(2, data.kolom_id, data.sk_group_id, "persiapan");
                    return;
                }

                if (data.ret === "selesai") {
                    updateFinishRespon(
                        <?= $request->uri->getSegment(3) ?>,
                        <?= $request->uri->getSegment(4) ?>
                    );
                    Swal.fire("Tes selesai", "Terima kasih", "success")
                    .then(() => {
                        window.location.href =
                        "<?= base_url() ?>/tryout/hasiltryout/<?= $request->uri->getSegment(3) ?>/<?= $request->uri->getSegment(4) ?>";
                    });
                    return;
                }

                if (data.ret === "ok") {
                    renderSoal(data);

                    let durasi = 60;
                    if (data.no_soal === 1) {
                        countdown(durasi, data.kolom_id, data.sk_group_id);
                    }
                    return;
                }

                if (data.ret === "soal_tidak_ada") {
                    alert("Soal tidak ada");
                }
            },
            error: function(e) {
                alert(e.responseText);
            }
        });
    }

    function convertSeconds(s) {
        var min = Math.floor(s / 60);
        var sec = s % 60;
        if (sec < 10) {
            sec = "0"+sec;
        }

        if (min < 10) {
            min = "0"+min;
        }
        return min + ":" + sec;
    }

    function countdown(detik,kolom_id,sk_group_id,proc) {
        var seconds = detik;
        timers = window.setInterval(function() {
            myFunction();
        }, 1000);

        function myFunction() {
            seconds--;
            $("#countdown").text(convertSeconds(seconds));
            if (seconds === 0) {
                window.clearInterval(timers);
                if (proc == "persiapan") {
                    kolom_id = kolom_id + 1;
                    if (kolom_id == 21) {
                        sk_group_id = sk_group_id + 1;
                        kolom_id = 1;
                        if (sk_group_id == 5) {
                            startujian("selesai");
                        } else {
                            startujian("nextkolom","","","",<?= $request->uri->getSegment(4) ?>,0,kolom_id,<?= $request->uri->getSegment(3) ?>,sk_group_id);
                        }
                    } else {
                        startujian("nextkolom","","","",<?= $request->uri->getSegment(4) ?>,0,kolom_id,<?= $request->uri->getSegment(3) ?>,sk_group_id);
                    }
                } else {
                    startujian("persiapan","","","",<?= $request->uri->getSegment(4) ?>,0,kolom_id,<?= $request->uri->getSegment(3) ?>,sk_group_id);
                }
            }
        }
    }

    function updateFinishRespon(materi_id,group_id) {
        $.ajax({
            url: "<?= base_url('tryout/updateFinishRespon') ?>",
            type: "post",
            dataType: "json",
            data: {
                "materi_id": materi_id,
                "group_id": group_id
            },
            beforeSend: function() {
                $("#loader-wrapper").removeClass("d-none")
            },
            success: function(data) {
                $("#loader-wrapper").addClass("d-none");
            },
            error: function() {
                Swal.fire("Ada terjadi sesuatu, mohon hubungi administrator", "", "warning");
            }
        });
    }
    </script>
</body>

</html>