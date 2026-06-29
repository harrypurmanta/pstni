<?php
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
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
            transition: background-color 0.1s;
            background-color: rgb(253 253 253 / 58%);
            -webkit-overflow-scrolling: touch;
        }

        .loader {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #3af3f5;
            border-bottom: 10px solid #3abcec;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin: 1.75rem auto;
        }



        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-moz-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-o-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-ms-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .tahapan-wrapper {
            display: flex;
            flex-wrap: nowrap;        /* jangan turun ke bawah */
            overflow-x: auto;         /* scroll horizontal */
            gap: 15px;
            padding: 10px 5px;
            scroll-behavior: smooth;
        }

        .tahapan-wrapper::-webkit-scrollbar {
            height: 6px;
        }

        .tahapan-wrapper::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .tahapan-item {
            flex: 0 0 auto;           /* supaya tidak mengecil */
            padding: 10px 20px;
            border: 1px solid green;
            border-radius: 10px;
            white-space: nowrap;      /* teks tidak turun */
            cursor: pointer;
            background: #f8f9fa;
        }

        .tahapan-item.active {
            background: #28a745;
            color: white;
        }

        #dv_main_jawaban {
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            margin-top: 30px !important;
            margin-bottom: 15px !important;
            clear: both !important;
            width: 100% !important;
        }

        #dv_main_jawaban .jawaban_dv {
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 12px 15px !important;
            background-color: #aeaebb !important;
            border-radius: 5px !important;
            cursor: pointer !important;
            text-align: left !important;
            transition: all 0.2s ease-in-out !important;
            border: 3px solid transparent;
        }

        #dv_main_jawaban .jawaban_dv:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.15) !important;
        }

        #dv_main_jawaban .jawaban_dv label {
            display: inline-block !important;
            margin-bottom: 0 !important;
            margin-right: 5px !important;
            font-size: 16px !important;
            font-weight: bold !important;
            cursor: pointer !important;
        }

        #dv_main_jawaban .jawaban_dv span {
            display: inline !important;
            font-size: 16px !important;
            cursor: pointer !important;
        }

        #dv_main_jawaban .jawaban_dv p {
            display: inline !important;
            margin: 0 !important;
        }

        #dv_main_jawaban .jawaban_dv img {
            max-width: 100% !important;
            height: auto !important;
            margin-top: 5px !important;
            display: block !important;
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
                        <div class="col-md-12 d-flex">

                            <!-- Tahapan Ujian -->
                            <div class="bg-gray col-md-8" style="border-radius:5px;">
                                
                                <div style="margin-top:10px;">
                                    <label>Tahapan Ujian</label>
                                </div>

                                <input type="hidden" id="inp_group_id">

                                <!-- Wrapper Scroll -->
                                <div class="tahapan-wrapper">
                                    <?php foreach ($group as $key) { ?>
                                        <div class="tahapan-item 
                                            <?= ($request->uri->getSegment(4) == $key->group_soal_id ? 'active' : '') ?>">
                                            <?= $key->group_nm ?>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>

                            <!-- Timer -->
                            <div class="bg-gray col-md-3 text-center"
                                style="border-radius:5px;margin-left:10px;height:85px;">
                                <span style="margin-top:15px;">Waktu</span><br>
                                <label style="font-size:35px;" id="countdown">00:00</label>
                            </div>

                        </div>
                    </div>

                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-12">
                            <div class="bg-gray col-md-7" style="border-radius:5px;">
                                <div style="margin-top:10px;">
                                    <label for="pertanyaan">Pertanyaan</label>
                                </div>
                                <div class="col-md-12"
                                    style="min-height:100px;background-color:#aeaebb;border-radius:5px;padding-bottom:25px;margin-bottom:20px;">
                                    <b>
                                        <p id="p_no_soal" style="margin-top:10px;">Soal no. <?= $soal[0]->no_soal ?></p>
                                    </b>
                                    <p id="inp_soal_nm" style="margin:5px;font-size:16px;"></p>
                                    <div id="dv_img_soal" style="margin:5px;font-size:16px;"></div>
                                    <input type="hidden" value="<?= $soal[0]->soal_id ?>" id="inp_soal_id">
                                    <input type="hidden" value="1" id="inp_no_soal">
                                    <input type="hidden" value="<?= $soal[0]->kolom_id ?>" id="inp_kolom_id">
                                </div>
                                <div id="dv_main_jawaban">
                                    <?php
                                        foreach ($jawaban as $key) {
                                    ?>
                                    <div id="dv_jawaban_<?= $key->jawaban_id ?>"
                                        onclick="selectJawaban(<?= $key->jawaban_id ?>,'<?= $key->pilihan_nm ?>')"
                                        class="btn col-md-12 jawaban_dv"
                                        style="margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;">
                                        <label for="pilihan_nm"><?= $key->pilihan_nm ?>.</label>
                                        <span><?= $key->jawaban_nm ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <input type="hidden" value="" id="inp_jawaban_id">
                                <input type="hidden" value="" id="inp_pilihan_nm">
                                <div class="row" style="margin-top:10px;margin-bottom:10px;">
                                    <div class="col-md-12" id="dv_button">

                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray col-md-4" style="border-radius:5px;margin-left:10px;">
                                <div class="row">
                                    <div id="dv_boxnosoal" class="col-md-12 text-center"
                                        style="margin-top:10px;margin-bottom:10px;display: flex;flex-wrap: wrap;justify-content: center;">

                                    </div>
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
            dv[index].style.border = "none";
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
        let pilihan_nm = (group_id == 7) ? $("#inp_pilihan_nm_7").val() : $("#inp_pilihan_nm").val();
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
                if (data.proc == "selesai") {
                    let grp_id = group_id + 1;
                    window.location.href = "<?= base_url() ?>/materi/pilihanMateri/" + materi + "/" +
                        grp_id;
                } else {
                    if (data == "jawaban_kosong") {
                        alert("Jawaban belum dipilih");
                    } else {
                        if (data.no_soal == 1) {
                            window.clearInterval(timers);
                            countdown(600);
                        } 
 
                        $("#inp_soal_id").val(data.soal_id);
                        $("#inp_soal_nm").text(data.soal_nm);
                        $("#p_no_soal").text("Soal no. " + data.no_soal);
                        $("#inp_group_id").val(data.group_id);
                        $("#inp_no_soal").val(data.no_soal);
                        $("#inp_kolom_id").val(data.kolom_id);

                        // 1. Build Jawaban HTML
                        let jawabanHtml = "";
                        if (data.group_id == 7) {
                            jawabanHtml = `<div class='btn col-md-12' style='margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;'>
                                <input type='text' class='form-control' name='inp_pilihan_nm_7' id='inp_pilihan_nm_7' placeholder='Jawaban' autocomplete='off' value='${data.pilihan_nmx || ""}' style='color:black;font-size:16px;'>
                            </div>`;
                        } else {
                            if (data.jawaban_list) {
                                data.jawaban_list.forEach(key => {
                                    let border = "";
                                    if (data.pilihan_nms == key.pilihan_nm) {
                                        border = "border: thick solid rgb(0, 166, 90);";
                                    }
                                    let img_jwb = "";
                                    if (key.jawaban_img) {
                                        img_jwb = `<img style='max-width:350px;height:100%;' src='${data.base_url}/images/jawaban/materi/${data.soal.materi}/group/${data.group_id}/${key.jawaban_img}'>`;
                                    }
                                    jawabanHtml += `
                                        <div id='dv_jawaban_${key.jawaban_id}' 
                                            onclick='selectJawaban(${key.jawaban_id},"${key.pilihan_nm}")' 
                                            class='btn col-md-12 jawaban_dv' 
                                            style='margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align:left;
                                                    word-break: break-all; overflow-wrap: break-word; white-space: normal; ${border}'>
                                            <label for='pilihan_nm'>${key.pilihan_nm}. </label> 
                                            <span>${key.jawaban_nm}</span>
                                            <div>${img_jwb}</div>
                                        </div>`;
                                });
                            }
                        }
                        $("#dv_main_jawaban").html(jawabanHtml);

                        // 2. Build Box No Soal HTML
                        let boxHtml = "";
                        if (data.box_list) {
                            data.box_list.forEach(boxsoal => {
                                let boxcursor = "cursor:pointer;";
                                let style = "";
                                let pilihan_nm_txt = "";
                                if (boxsoal.has_respon) {
                                    pilihan_nm_txt = " " + boxsoal.pilihan_nm;
                                    style = `border:2px solid #3cce3c;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;${boxcursor}`;
                                    if (boxsoal.no_soal == data.no_soal) {
                                        style = `border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;${boxcursor}`;
                                    }
                                } else {
                                    pilihan_nm_txt = "";
                                    style = `border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;${boxcursor}`;
                                    if (boxsoal.no_soal == data.no_soal) {
                                        style = `border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;${boxcursor}`;
                                    }
                                }
                                boxHtml += `<div class='col-md-2' style='${style} font-size:12px;' onclick='setboxsoal(${boxsoal.no_soal})'>${boxsoal.no_soal}${pilihan_nm_txt}</div>`;
                            });
                        }
                        $("#dv_boxnosoal").html(boxHtml);

                        // 3. Build Button HTML
                        let buttonHtml = `<button onclick='startujian("next")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>`;
                        if (data.jumlah_jawab == data.total_soal_count - 1) {
                            buttonHtml += `<button onclick='startujian("selesai")' style='font-size:16px;padding-left:25px;padding-right:25px; margin-left: 20px;' class='btn btn-warning'>Selesai</button>`;
                        }
                        $("#dv_button").html(buttonHtml);

                        $("#inp_jawaban_id").val("");
                        $("#inp_pilihan_nm").val("");

                        // 4. Build Image Soal HTML
                        let imgSoalHtml = "";
                        if (data.soal && data.soal.soal_img) {
                            imgSoalHtml = `<div class='col-sm-10'>
                                <a href='${data.base_url}/images/soal/materi/${data.soal.materi}/besar/${data.soal.soal_img}' data-toggle='lightbox'>
                                    <img style='max-width: 350px;max-height: 100%;' src='${data.base_url}/images/soal/materi/${data.soal.materi}/${data.soal.soal_img}' class='img-fluid'>
                                </a>
                            </div>`;
                        }
                        $("#dv_img_soal").html(imgSoalHtml);

                        setTimeout(() => {
                            selectJawaban(data.jawaban_idx,data.pilihan_nms);
                        }, 10);
                        
                    }
                }

                let dv = document.getElementsByClassName("jawaban_dv");
                for (let index = 0; index < dv.length; index++) {
                    dv[index].style.border = "none";
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
        if (sec < 10) {
            sec = "0"+sec;
        }

        if (min < 10) {
            min = "0"+min;
        }
        return min + ":" + sec;
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
            if (seconds === 0) {
                let grp_id = group_id + 1;
                window.location.href = "<?= base_url() ?>/materi/pilihanMateri/" + materi + "/" + grp_id;
            } else {
                //Do nothing
            }

        }
    }
    </script>
</body>

</html>