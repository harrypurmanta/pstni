<?php
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hasil Test - Bintang Timur Prestasi</title>
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
            padding-top: 15px !important;
            padding-bottom: 25px;
        }

        .main-footer {
            flex-shrink: 0 !important;
        }

        /* Result Main Card */
        .result-card-main {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            max-width: 820px;
            margin: 0 auto;
        }

        .icon-result-badge {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
            margin-bottom: 14px;
        }

        .result-card-title {
            font-weight: 700;
            font-size: 24px;
            color: #0f172a;
            margin-bottom: 22px;
            text-align: center;
        }

        /* Result Row Card Layout */
        .result-list-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 22px;
        }

        .result-row-card {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            transition: all 0.2s ease;
        }

        .result-row-card:hover {
            background: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 4px 14px rgba(0,0,0,0.04);
        }

        .result-paket-name {
            font-weight: 700;
            font-size: 16px;
            color: #0f172a;
            display: flex;
            align-items: center;
            flex: 1;
        }

        .result-stats-flex {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-pill {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6px 14px;
            border-radius: 10px;
            min-width: 82px;
            text-align: center;
        }

        .stat-pill .stat-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .stat-pill .stat-value {
            font-size: 17px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-terjawab {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
        }

        .stat-benar {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .stat-salah {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #991b1b;
        }

        /* Action Email Button */
        .btn-email-result {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 12px 36px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .btn-email-result:hover {
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45) !important;
            transform: translateY(-1px);
            color: #ffffff !important;
        }

        .notice-info-box {
            background: #eff6ff;
            border: 1.5px dashed #93c5fd;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 14px;
            color: #1e40af;
            font-weight: 500;
            margin-top: 20px;
            text-align: center;
        }

        .hidden-chart {
            position: absolute;
            left: -9999px;
            top: -9999px;
        }

        .chart-wrapper {
            max-width: 800px;
            height: 350px;
            margin: 40px auto;
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .switch input { display:none; }

        .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #2563eb;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
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

        @media (max-width: 768px) {
            .content-wrapper {
                padding-top: 10px !important;
                padding-bottom: 15px !important;
            }
            .result-card-main {
                padding: 16px 12px;
                border-radius: 14px;
            }
            .result-card-title {
                font-size: 18px;
                margin-bottom: 14px;
            }
            .icon-result-badge {
                width: 48px;
                height: 48px;
                font-size: 20px;
                border-radius: 12px;
                margin-bottom: 8px;
            }
            .result-row-card {
                flex-direction: column;
                align-items: stretch;
                padding: 12px 10px;
                gap: 10px;
            }
            .result-paket-name {
                font-size: 14px;
            }
            .result-stats-flex {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                width: 100%;
            }
            .stat-pill {
                min-width: auto;
                padding: 8px 4px;
                border-radius: 8px;
            }
            .stat-pill .stat-label {
                font-size: 9px;
            }
            .stat-pill .stat-value {
                font-size: 16px;
            }
            .btn-email-result {
                width: 100%;
                padding: 10px 16px !important;
                font-size: 15px !important;
            }
            .notice-info-box {
                font-size: 12px;
                padding: 10px 12px;
                margin-top: 14px;
                line-height: 1.4;
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
                            <div class="result-card-main">
                                <div class="text-center">
                                    <div class="icon-result-badge">
                                        <i class="fa fa-trophy"></i>
                                    </div>
                                    <h2 class="result-card-title">Hasil Test & Nilai Anda</h2>
                                </div>

                                <!-- Ultra-Readable Card List Layout -->
                                <div class="result-list-group">
                                    <?php
                                        foreach ($getRespon as $h) {
                                            $paket = $h->group_nm;
                                            $terjawab = $h->total_soal;
                                            $benar = $h->total_benar;
                                            $salah = $h->total_salah;
                                    ?>
                                    <div class="result-row-card">
                                        <div class="result-paket-name">
                                            <i class="fa fa-folder-open text-primary mr-2" style="font-size: 16px;"></i> <?= $paket ?>
                                        </div>
                                        <div class="result-stats-flex">
                                            <div class="stat-pill stat-terjawab">
                                                <span class="stat-label">Terjawab</span>
                                                <span class="stat-value"><?= $terjawab ?></span>
                                            </div>
                                            <div class="stat-pill stat-benar">
                                                <span class="stat-label">Benar</span>
                                                <span class="stat-value"><?= $benar ?></span>
                                            </div>
                                            <div class="stat-pill stat-salah">
                                                <span class="stat-label">Salah</span>
                                                <span class="stat-value"><?= $salah ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="text-center mt-3">
                                    <button onclick="kirimemail()" class="btn btn-email-result">
                                        <i class="fa fa-envelope mr-2"></i> Kirim Hasil ke Email
                                    </button>
                                </div>

                                <div class="notice-info-box">
                                    <i class="fa fa-info-circle mr-1" style="font-size: 16px;"></i> Catatan: Hasil Rorschach dan Pauli akan dikirimkan secara lengkap melalui email Anda.
                                </div>

                                <!-- Hidden chart and table elements for background processing -->
                                <div class="col-md-12 d-none" style="display: none;">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 1</h3>
                                                    </div>
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; if (isset($hasil[1]) && is_array($hasil[1])) { foreach ($hasil[1] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 2</h3>
                                                    </div>
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; if (isset($hasil[2]) && is_array($hasil[2])) { foreach ($hasil[2] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 3</h3>
                                                    </div>
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; if (isset($hasil[3]) && is_array($hasil[3])) { foreach ($hasil[3] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="text-center mb-3">
                                                        <h3>Lembar 4</h3>
                                                    </div>
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Kolom</th>
                                                                <th class="text-center">Terjawab</th>
                                                                <th class="text-center">Tidak Terjawab</th>
                                                                <th class="text-center">Salah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; if (isset($hasil[4]) && is_array($hasil[4])) { foreach ($hasil[4] as $row) { ?>
                                                            <tr>
                                                                <td class="text-center"><?= $no++ ?></td>
                                                                <td><?= $row->kolom_nm ?></td>
                                                                <td class="text-center"><?= $row->terjawab ?></td>
                                                                <td class="text-center"><?= $row->tidak_terjawab ?></td>
                                                                <td class="text-center"><?= $row->salah ?></td>
                                                            </tr>
                                                            <?php } } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 hidden-chart" style="margin-top: 10px; margin-bottom: 20px;">
                                    <div class="box text-center">
                                        <div class="box-body">
                                            <div class="col-md-12 d-flex justify-content-center align-items-center mb-3 gap-3">
                                                <label style="font-weight:bold; margin-right:10px;">Mode Grafik:</label>
                                                <label class="switch mb-0">
                                                    <input type="checkbox" id="toggleMode" checked>
                                                    <span class="slider"></span>
                                                </label>
                                                <span id="modeLabel" style="margin-left: 10px;">Per 3 Kolom</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 1</h3></div>
                                                            <canvas id="chart_sk_1"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 2</h3></div>
                                                            <canvas id="chart_sk_2"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="row col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 3</h3></div>
                                                            <canvas id="chart_sk_3"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="chart-wrapper">
                                                            <div class="text-center"><h3>Lembar 4</h3></div>
                                                            <canvas id="chart_sk_4"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?= $this->include('front/footer') ?>

        <div style="display: none;" id="loader-wrapper">
            <div class="loader"></div>
        </div>
    </div>

    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const chartInstances = {};

    const hasil = <?= json_encode($hasil ?? []) ?>;

    function buildLabelPer3Kolom(dataSk) {
        const labels = [];
        for (let i = 0; i < dataSk.length; i += 3) {
            const start = dataSk[i].kolom_nm;
            const end   = dataSk[Math.min(i + 2, dataSk.length - 1)].kolom_nm;
            labels.push(`${start}-${end} ●`);
        }
        return labels;
    }

    function buildDataPer3Kolom(dataSk) {
        const values = [];
        for (let i = 0; i < dataSk.length; i += 3) {
            const chunk = dataSk.slice(i, i + 3);
            values.push(
                chunk.reduce((s, x) => s + parseInt(x.terjawab), 0)
            );
        }
        return values;
    }

    function renderChart(sk_group_id, mode = 'group') {
        const dataSk = hasil[sk_group_id];
        if (!dataSk) return;

        const ctx = document.getElementById('chart_sk_' + sk_group_id).getContext('2d');

        if (chartInstances[sk_group_id]) {
            chartInstances[sk_group_id].destroy();
        }

        let labels, datasets;

        if (mode === 'group') {
            labels = buildLabelPer3Kolom(dataSk);
            datasets = [{
                label: 'Terjawab per 3 Kolom',
                data: buildDataPer3Kolom(dataSk),
                borderWidth: 3,
                tension: 0.3
            }];
        } else {
            labels = dataSk.map(i => i.kolom_nm);
            datasets = [{
                label: 'Terjawab per Kolom',
                data: dataSk.map(i => parseInt(i.terjawab)),
                borderWidth: 2,
                tension: 0.3
            }];
        }

        chartInstances[sk_group_id] = new Chart(ctx, {
            type: 'line',
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 0,
                        max: 60
                    }
                },
                plugins: {
                    legend: {
                        onClick: (e, legendItem) => {
                            const nextMode = legendItem.text.includes('3') ? 'group' : 'detail';
                            renderChart(sk_group_id, nextMode);
                        }
                    }
                }
            }
        });
    }

    for (let i = 1; i <= 4; i++) {
        renderChart(i, 'group');
    }

    document.getElementById('toggleMode')?.addEventListener('change', function () {
        const mode = this.checked ? 'group' : 'detail';
        document.getElementById('modeLabel').innerText = mode === 'group' ? 'Per 3 Kolom' : 'Detail Per Kolom';

        for (let i = 1; i <= 4; i++) {
            renderChart(i, mode);
        }
    });

    function kirimemail() {
        $("#loader-wrapper").show();
        let materi = <?= $request->uri->getSegment(3) ?? 0 ?>;
        let group_id = <?= $request->uri->getSegment(4) ?? 0 ?>;

        setTimeout(() => {
            const charts = getChartsBase64();
            $.ajax({
                url: "<?= base_url('tryout/kirimemail') ?>",
                type: "post",
                dataType: "json",
                data: {
                    "group_id": group_id,
                    "materi": materi,
                    "chart1": charts.chart_1,
                    "chart2": charts.chart_2,
                    "chart3": charts.chart_3,
                    "chart4": charts.chart_4
                },
                success: function(data) {
                    if (data && (data === true || data.status === "sukses")) {
                        Swal.fire("Berhasil", "Email berhasil dikirim", "success");
                    } else {
                        let msg = "Email gagal dikirim.";
                        if (data && data.debug) {
                            console.log("SMTP Debugger Output:", data.debug);
                            let cleanDebug = data.debug.replace(/<[^>]*>/g, '').trim();
                            if (cleanDebug.length > 200) {
                                cleanDebug = cleanDebug.substring(0, 200) + "...";
                            }
                            msg += "<br><br><small style='color:red;'>" + cleanDebug + "</small>";
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: msg
                        });
                    }
                    $("#loader-wrapper").hide();
                },
                error: function() {
                    alert("Error system");
                    $("#loader-wrapper").hide();
                }
            });
        }, 3000);
    }

    function getChartsBase64() {
        const charts = {};
        for (let i = 1; i <= 4; i++) {
            const canvas = document.getElementById('chart_sk_' + i);
            if (canvas) {
                charts['chart_' + i] = canvas.toDataURL("image/png");
            }
        }
        return charts;
    }
    </script>
</body>

</html>