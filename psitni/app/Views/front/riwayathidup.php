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
    <!-- Google Fonts for Modern Typography -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <style>
        body {
            font-family: 'Inter', 'Source Sans Pro', sans-serif;
            overflow-y: auto;
        }
        .form-riwayat-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border: none;
            margin-top: 10px;
            margin-bottom: 10px;
            overflow: hidden;
            border-top: 4px solid #3c8dbc;
        }
        .form-riwayat-header {
            background: linear-gradient(135deg, #3c8dbc, #224d73);
            color: #ffffff;
            padding: 15px 25px;
        }
        .form-riwayat-header h3 {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 20px;
        }
        .form-riwayat-header p {
            margin: 4px 0 0 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .form-riwayat-body {
            padding: 20px 25px 10px 25px;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-group label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 6px;
            font-size: 13px;
        }
        .input-group-addon {
            background-color: #f8fafc;
            border-color: #d2d6de;
            color: #718096;
            transition: all 0.3s;
            border-radius: 6px 0 0 6px !important;
            padding: 6px 12px;
        }
        .form-control {
            border-radius: 0 6px 6px 0 !important;
            border-color: #d2d6de;
            height: 38px;
            box-shadow: none;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #3c8dbc;
            box-shadow: 0 0 8px rgba(60, 141, 188, 0.25);
        }
        .input-group:focus-within .input-group-addon {
            border-color: #3c8dbc;
            background-color: #ebf8ff;
            color: #3c8dbc;
        }
        .textarea-alamat {
            border-radius: 6px !important;
            height: auto;
            resize: none;
            padding: 8px 12px;
        }
        .btn-submit-riwayat {
            background: linear-gradient(135deg, #3c8dbc, #286090);
            border: none;
            padding: 10px 25px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(60, 141, 188, 0.3);
            transition: all 0.3s;
            color: #fff;
        }
        .btn-submit-riwayat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(60, 141, 188, 0.4);
            color: #fff;
            background: linear-gradient(135deg, #286090, #1f486c);
        }
        .btn-submit-riwayat:active {
            transform: translateY(0);
        }
    </style>
</head>
<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <?php $session = \Config\Services::session(); ?>
        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
                            <div class="box form-riwayat-card">
                                <div class="form-riwayat-header">
                                    <h3><i class="fa fa-id-card-o"></i> FORM RIWAYAT HIDUP</h3>
                                    <p>Silakan isi data riwayat hidup Anda dengan lengkap sebelum memulai simulasi CAT.</p>
                                </div>
                                
                                <form id="form-riwayat" method="post">
                                    <div class="form-riwayat-body">
                                        <!-- Alert Notification -->
                                        <div id="alert-container" style="display: none; margin-bottom: 15px;"></div>

                                        <!-- Row 1: Nama & Agama -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="person_nm">Nama Lengkap</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input type="text" class="form-control" id="person_nm" name="person_nm" 
                                                               value="<?= esc($session->get('person_nm')) ?>" placeholder="Nama Lengkap sesuai KTP/Ijazah" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="religion">Agama</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                                        <select class="form-control" id="religion" name="religion" required>
                                                            <option value="" disabled <?= empty($session->get('religion')) ? 'selected' : '' ?>>-- Pilih Agama --</option>
                                                            <?php if (isset($religions) && !empty($religions)): ?>
                                                                <?php foreach ($religions as $rel): ?>
                                                                    <?php $selected = ($session->get('religion') == $rel->religion_nm) ? 'selected' : ''; ?>
                                                                    <option value="<?= esc($rel->religion_nm) ?>" <?= $selected ?>><?= esc($rel->religion_nm) ?></option>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <?php
                                                                $fallbackReligions = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'];
                                                                foreach ($fallbackReligions as $rel) {
                                                                    $selected = ($session->get('religion') == $rel) ? 'selected' : '';
                                                                    echo "<option value=\"$rel\" $selected>$rel</option>";
                                                                }
                                                                ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 2: TTL -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="birth_place">Tempat Lahir</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                                        <input type="text" class="form-control" id="birth_place" name="birth_place" 
                                                               value="<?= esc($session->get('birth_place')) ?>" placeholder="Tempat Lahir" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="birth_dttm">Tanggal Lahir</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="date" class="form-control" id="birth_dttm" name="birth_dttm" 
                                                               value="<?= esc($session->get('birth_dttm')) ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 3: Nama Ortu & Pekerjaan Ortu -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ortu_nm">Nama Orang Tua</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                                        <input type="text" class="form-control" id="ortu_nm" name="ortu_nm" 
                                                               value="<?= esc($session->get('ortu_nm')) ?>" placeholder="Nama Orang Tua" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ortu_job">Pekerjaan Orang Tua</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                                        <input type="text" class="form-control" id="ortu_job" name="ortu_job" 
                                                               value="<?= esc($session->get('ortu_job')) ?>" placeholder="Pekerjaan Orang Tua" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 4: Alamat -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="addr_txt">Alamat Lengkap</label>
                                                    <textarea class="form-control textarea-alamat" id="addr_txt" name="addr_txt" rows="2" 
                                                              placeholder="Alamat Lengkap domisili saat ini" required><?= esc($session->get('addr_txt')) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="box-footer text-right" style="background: #fdfdfd; padding: 12px 30px !important; border-top: 1px solid #f4f4f4;">
                                        <button type="submit" id="btn-submit" class="btn btn-submit-riwayat">
                                            <i class="fa fa-save"></i> Simpan & Lanjutkan <i class="fa fa-chevron-right" style="font-size: 12px; margin-left: 5px;"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="modal fade" id="modal-token">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <!-- <h4>Masukkan Token</h4> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="modal_body" class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <input class="form-control" type="text" name="token" id="token" placeholder="Masukkan Token" maxlength="6" minlength="6" autocomplete="off">
                                        <input class="form-control" type="hidden" name="group_idx" id="group_idx">
                                        <input class="form-control" type="hidden" name="materi_id" id="materi_id">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button style="margin-top: 25px;" class="btn btn-primary" type="button" onclick="checktoken()">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script src="<?= base_url() ?>/dist/js/demo.js"></script>
    <script>
        function showtoken(group_id, materi_id) {
            $("#token").val("");
            $("#token").focus();
            $("#group_idx").val(group_id);
            $("#materi_id").val(materi_id);
            $("#modal-token").modal("show");
        }

        function checktoken() {
            var token = $("#token").val();
            var group_id = $("#group_idx").val();
            var materi_id = $("#materi_id").val();
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
                    alert("Error");
                    $("#loader-wrapper").addClass("d-none");
                }
            });
        }

        $(document).ready(function() {
            $("#form-riwayat").on("submit", function(e) {
                e.preventDefault();
                
                var btn = $("#btn-submit");
                var originalText = btn.html();
                
                // Disable button and show spinner
                btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
                
                // Clear alerts
                $("#alert-container").hide().html('');

                $.ajax({
                    url: "<?= base_url('materi/simpanriwayathidup') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'sukses') {
                            // Success alert
                            var successHtml = '<div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 6px;">' +
                                              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                              '<strong><i class="fa fa-check-circle"></i> Berhasil!</strong> Data riwayat hidup berhasil disimpan. Menghubungkan ke tryout...' +
                                              '</div>';
                            $("#alert-container").html(successHtml).fadeIn();
                            
                            // Redirect to tryout selection page
                            setTimeout(function() {
                                window.location.href = "<?= base_url('materi/pilihanMateri/' . $materi_id . '/1') ?>";
                            }, 1500);
                        } else {
                            // Error alert
                            var errorMsg = response.message || 'Terjadi kesalahan saat menyimpan data.';
                            var errorHtml = '<div class="alert alert-danger alert-dismissible" role="alert" style="border-radius: 6px;">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                            '<strong><i class="fa fa-exclamation-triangle"></i> Gagal!</strong> ' + errorMsg +
                                            '</div>';
                            $("#alert-container").html(errorHtml).fadeIn();
                            btn.prop("disabled", false).html(originalText);
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorHtml = '<div class="alert alert-danger alert-dismissible" role="alert" style="border-radius: 6px;">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                        '<strong><i class="fa fa-exclamation-triangle"></i> Terjadi Kesalahan!</strong> Koneksi ke server bermasalah.' +
                                        '</div>';
                        $("#alert-container").html(errorHtml).fadeIn();
                        btn.prop("disabled", false).html(originalText);
                    }
                });
            });
        });
    </script>
</body>

</html>