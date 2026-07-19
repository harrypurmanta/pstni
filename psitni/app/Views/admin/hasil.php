<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Users</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
 <!-- Navbar -->
 

 <?= $this->include('admin/navbar') ?>
  <!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Hasil Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                  <table class="table table-sm table-borderless m-0 w-100">
                    <?php
                    foreach ($user as $key) {
                        $dttm = explode(" ", $key->birth_dttm ?? '');
                        $formatted_date = !empty($dttm[0]) ? date("d-m-Y", strtotime($dttm[0])) : '';
                        $gender = (($key->gender_cd ?? '') == 'l') ? 'Laki-laki' : ((($key->gender_cd ?? '') == 'm') ? 'Perempuan' : esc($key->gender_cd ?? ''));
                    ?>
                    <tr>
                      <td class='font-weight-bold' style='width: 15%;'>Nama</td>
                      <td style='width: 2%;'>:</td>
                      <td style='width: 33%;'><?= esc($key->person_nm ?? '') ?></td>
                      
                      <td class='font-weight-bold' style='width: 15%;'>Email</td>
                      <td style='width: 2%;'>:</td>
                      <td style='width: 33%;'><?= esc($key->email ?? '') ?></td>
                    </tr>
                    <tr>
                      <td class='font-weight-bold'>TTL</td>
                      <td>:</td>
                      <td><?= esc($key->birth_place ?? '') ?><?= $formatted_date ? ', ' . $formatted_date : '' ?></td>
                      
                      <td class='font-weight-bold'>No. HP</td>
                      <td>:</td>
                      <td><?= esc($key->cellphone ?? '') ?></td>
                    </tr>
                    <tr>
                      <td class='font-weight-bold'>Jenis Kelamin</td>
                      <td>:</td>
                      <td><?= $gender ?></td>
                      
                      <td class='font-weight-bold'>Username</td>
                      <td>:</td>
                      <td><code class='text-primary'><?= esc($key->user_nm ?? '') ?></code></td>
                    </tr>
                    <tr>
                      <td colspan="3"></td>
                      <td class='font-weight-bold'>Satuan</td>
                      <td>:</td>
                      <td><?= esc($key->satuan ?? '') ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </table>
                </div>
              <div class="card-body">
              <table id="example2" class="table table-bordered table-striped table-hover">
                  <thead class="bg-light">
                  <tr>
                    <th style="text-align:center;">Materi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>
                        <div class="list-group list-group-flush">
                        <?php
                            foreach ($materi as $km) {
                                $pdf_links = "<a class='btn btn-xs btn-outline-danger mx-1' target='_blank' href='".base_url()."/admin/users/hasilpdf_salah/$user_id/".$km->materi_id."'><i class='fas fa-file-pdf'></i> PDF Salah</a>";
                                $pdf_links .= " <a class='btn btn-xs btn-outline-dark mx-1' target='_blank' href='".base_url()."/admin/users/hasilpdf_pauli/$user_id/".$km->materi_id."'><i class='fas fa-file-pdf'></i> PDF Pauli</a>";
                                
                                echo " <div class='list-group-item d-flex align-items-center justify-content-between py-2'>
                                    <span class='font-weight-bold'><i class='fas fa-book mr-1 text-secondary'></i> ".$km->materi_nm."</span>
                                    <div>
                                        ".$pdf_links."
                                    </div>
                                </div>";
                            }
                        ?>
                        </div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

        
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="padding: 0px 10px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="modal_body" class="modal-body">

          </div>
          
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  </div>
  <!-- /.content-wrapper -->


</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
 function listmaterilatihan() {
    var user_id = <?= $user_id; ?>;
    $.ajax({
        url: "<?= base_url('admin/hasil/listmaterilatihan') ?>",
        type: "post",
        data: {
          "user_id": user_id
        },
        success: function(data) {
          $('#listlatihan').html(data);
        },
        error: function() {
          alert("error");
        }
    });
 }

 function listsubmaterilatihan() {
    var user_id = <?= $user_id; ?>;
    $.ajax({
        url: "<?= base_url('admin/hasil/listsubmaterilatihan') ?>",
        type: "post",
        data: {
          "user_id": user_id
        },
        success: function(data) {
          $('#listlatihan').html(data);
        },
        error: function() {
          alert("error");
        }
    });
}
</script>
</body>
</html>