<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profil Saya - Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <style>
        .profile-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            border: 1px solid #e3e3e3;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .profile-header {
            background: #3c8dbc;
            color: #ffffff;
            padding: 20px;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            text-align: center;
        }
        .profile-header h3 {
            margin: 0;
            font-weight: 600;
        }
        .profile-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .profile-body {
            padding: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            border-bottom: 2px solid #3c8dbc;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 15px;
            color: #333;
        }
        .btn-save {
            background: #3c8dbc;
            color: #fff;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 4px;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-save:hover {
            background: #307196;
            color: #fff;
        }
        .btn-save:disabled {
            background: #a5c3d4;
        }
        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <!-- Loader wrapper -->
    <div id="loader-wrapper" class="hidden">
        <i class="fa fa-refresh fa-spin fa-3x fa-fw" style="color: #3c8dbc;"></i>
    </div>

    <div class="wrapper">
        <header class="main-header">
            <?= $this->include('front/navbar') ?>
        </header>

        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="profile-card">
                                <div class="profile-header">
                                    <h3><i class="fa fa-user-circle"></i> PROFIL SAYA</h3>
                                    <p>Lihat dan perbarui data profil serta riwayat hidup Anda di sini</p>
                                </div>
                                <div class="profile-body">
                                    <div id="alert-container" style="display: none; margin-bottom: 20px;"></div>

                                    <form id="form-profile" method="post">
                                        <!-- Data Akun & Registrasi -->
                                        <div class="section-title"><i class="fa fa-id-card"></i> Data Registrasi</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="user_nm">Username</label>
                                                    <input type="text" class="form-control" id="user_nm" value="<?= $user->user_nm ?>" disabled>
                                                    <small class="text-muted">Username tidak dapat diubah</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="person_nm">Nama Lengkap *</label>
                                                    <input type="text" name="person_nm" class="form-control" id="person_nm" value="<?= $user->person_nm ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gender_cd">Jenis Kelamin *</label>
                                                    <select name="gender_cd" id="gender_cd" class="form-control" required>
                                                        <option value="L" <?= $user->gender_cd == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                                        <option value="P" <?= $user->gender_cd == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cellphone">No. Handphone (WA) *</label>
                                                    <input type="text" name="cellphone" class="form-control" id="cellphone" value="<?= $user->cellphone ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="birth_place">Tempat Lahir *</label>
                                                    <input type="text" name="birth_place" class="form-control" id="birth_place" value="<?= $user->birth_place ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="birth_dttm">Tanggal Lahir *</label>
                                                    <input type="date" name="birth_dttm" class="form-control" id="birth_dttm" value="<?= date('Y-m-d', strtotime($user->birth_dttm)) ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="satuan">Satuan / Sekolah *</label>
                                                    <input type="text" name="satuan" class="form-control" id="satuan" value="<?= $user->satuan ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="addr_txt">Alamat Rumah *</label>
                                                    <textarea name="addr_txt" class="form-control" id="addr_txt" rows="3" required><?= $user->addr_txt ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Data Riwayat Hidup -->
                                        <div class="section-title"><i class="fa fa-folder-open"></i> Data Riwayat Hidup</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="religion">Agama</label>
                                                    <select name="religion" id="religion" class="form-control">
                                                        <option value="">-- Pilih Agama --</option>
                                                        <?php foreach ($religions as $rel) { ?>
                                                            <option value="<?= $rel->religion_nm ?>" <?= $user->religion == $rel->religion_nm ? 'selected' : '' ?>>
                                                                <?= $rel->religion_nm ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ortu_nm">Nama Orang Tua</label>
                                                    <input type="text" name="ortu_nm" class="form-control" id="ortu_nm" value="<?= $user->ortu_nm ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="ortu_job">Pekerjaan Orang Tua</label>
                                                    <input type="text" name="ortu_job" class="form-control" id="ortu_job" value="<?= $user->ortu_job ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pengaturan Keamanan -->
                                        <div class="section-title"><i class="fa fa-lock"></i> Ganti Password</div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">Password Baru</label>
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <a href="<?= base_url('home') ?>" class="btn btn-default" style="margin-right: 10px;">Kembali</a>
                                                <button type="submit" id="btn-save" class="btn btn-save">
                                                    <i class="fa fa-save"></i> Simpan Perubahan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
        $(document).ready(function() {
            $("#form-profile").on("submit", function(e) {
                e.preventDefault();
                
                var btn = $("#btn-save");
                var originalText = btn.html();
                
                btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
                $("#loader-wrapper").removeClass("hidden");
                $("#alert-container").hide().html('');

                $.ajax({
                    url: "<?= base_url('profile/update') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $("#loader-wrapper").addClass("hidden");
                        if (response.status === 'sukses') {
                            var successHtml = '<div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 4px;">' +
                                              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                              '<strong><i class="fa fa-check-circle"></i> Berhasil!</strong> Data profil Anda berhasil diperbarui.' +
                                              '</div>';
                            $("#alert-container").html(successHtml).fadeIn();
                            btn.prop("disabled", false).html(originalText);
                            
                            // Optional password update logic - clear input
                            $("#password").val("");
                            
                            // Update name in navbar header instantly
                            $(".hidden-xs").text($("#person_nm").val());
                            
                            // Scroll to top of form
                            $('html, body').animate({ scrollTop: 0 }, 'slow');
                        } else {
                            var errorMsg = response.message || 'Terjadi kesalahan saat menyimpan data.';
                            var errorHtml = '<div class="alert alert-danger alert-dismissible" role="alert" style="border-radius: 4px;">' +
                                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                            '<strong><i class="fa fa-exclamation-triangle"></i> Gagal!</strong> ' + errorMsg +
                                            '</div>';
                            $("#alert-container").html(errorHtml).fadeIn();
                            btn.prop("disabled", false).html(originalText);
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#loader-wrapper").addClass("hidden");
                        var errorHtml = '<div class="alert alert-danger alert-dismissible" role="alert" style="border-radius: 4px;">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                        '<strong><i class="fa fa-exclamation-triangle"></i> Gagal!</strong> Terjadi kesalahan jaringan. Silakan coba lagi.' +
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
