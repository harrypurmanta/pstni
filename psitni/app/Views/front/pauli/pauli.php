<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pauli - Bintang Timur Prestasi</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Source+Sans+Pro:wght@400;600;700&display=swap">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f5f9 !important;
            font-family: 'Plus Jakarta Sans', 'Source Sans Pro', -apple-system, BlinkMacSystemFont, sans-serif !important;
            color: #1e293b;
        }

        .wrapper {
            display: flex !important;
            flex-direction: column !important;
            min-height: 100vh !important;
            background-color: #f1f5f9 !important;
        }

        .content-wrapper {
            background-color: #f1f5f9 !important;
            flex: 1 0 auto !important;
            padding: 20px 0 40px 0;
        }

        .main-footer {
            flex-shrink: 0 !important;
        }

        .page-header-title {
            text-align: center;
            margin-bottom: 25px;
            margin-top: 5px;
        }

        .page-header-title h2 {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            margin: 0;
        }

        /* Clickable Card Wrapper */
        .small-box-link {
            display: block;
            text-decoration: none !important;
            color: inherit !important;
            cursor: pointer;
            margin-bottom: 24px;
        }

        .small-box-link:hover,
        .small-box-link:focus {
            text-decoration: none !important;
            color: inherit !important;
        }

        /* Card Container (Keeping original small-box size & proportions) */
        .small-box {
            border-radius: 12px !important;
            position: relative;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            min-height: 120px;
            margin-bottom: 0 !important;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .small-box-link:hover .small-box {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
        }

        .small-box > .inner {
            padding: 24px 16px 18px 16px;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .small-box > .inner h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            line-height: 1.35;
            text-align: center;
            word-wrap: break-word;
            font-family: 'Plus Jakarta Sans', 'Source Sans Pro', sans-serif;
        }

        /* Completed (Green) */
        .small-box.bg-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #ffffff !important;
        }

        .small-box.bg-green > .inner h3 {
            color: #ffffff !important;
        }

        .small-box.bg-green .small-box-footer {
            background: rgba(0, 0, 0, 0.16) !important;
            color: #ffffff !important;
        }

        .small-box-link:hover .small-box.bg-green .small-box-footer {
            background: rgba(0, 0, 0, 0.28) !important;
        }

        /* Pending / Belum (Gray) */
        .small-box.bg-gray {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            border: 1px solid #cbd5e1;
            color: #1e293b !important;
        }

        .small-box.bg-gray > .inner h3 {
            color: #0f172a !important;
        }

        .small-box.bg-gray .small-box-footer {
            background: rgba(0, 0, 0, 0.05) !important;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            color: #334155 !important;
        }

        .small-box-link:hover .small-box.bg-gray .small-box-footer {
            background: rgba(0, 0, 0, 0.12) !important;
            color: #0f172a !important;
        }

        /* Card Footer / Action Button */
        .small-box .small-box-footer {
            position: relative;
            text-align: center;
            padding: 9px 0;
            font-size: 13.5px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.2s ease;
        }

        .small-box-link:hover .small-box-footer i {
            transform: translateX(3px);
        }

        .small-box-footer i {
            transition: transform 0.2s ease;
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
                        <div class="col-md-12 page-header-title">
                            <h2><b>PAULI</b></h2>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                    $this->session = \Config\Services::session();
                                    $user_id = $this->session->user_id;
                                    $db = db_connect();

                                    $completed_ids = [];
                                    if (!empty($user_id)) {
                                        $query_respon = $db->query("SELECT DISTINCT materi FROM respon WHERE created_user_id = ? AND status_cd != 'nullified' AND group_id = 8", [$user_id])->getResultArray();
                                        foreach ($query_respon as $r) {
                                            $completed_ids[$r['materi']] = true;
                                        }
                                    }

                                    foreach ($materi as $key) {
                                        $title = str_replace('Materi', 'Pauli', $key->materi_nm);

                                        if (isset($completed_ids[$key->materi_id])) {
                                            $click = base_url() . "/tryout/hasiltryoutPauli/" . $key->materi_id . "/8";
                                            $class_bg = "bg-green";
                                        } else {
                                            $click = base_url() . "/materi/petunjukSoalPauli/" . $key->materi_id . "/8";
                                            $class_bg = "bg-gray";
                                        }
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <a href="<?= $click ?>" class="small-box-link" title="Mulai <?= esc($title) ?>">
                                        <div class="small-box <?= $class_bg ?>">
                                            <div class="inner text-center">
                                                <h3><?= esc($title) ?></h3>
                                            </div>
                                            <div class="small-box-footer">
                                                Mulai <i class="fa fa-arrow-circle-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
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
</body>

</html>