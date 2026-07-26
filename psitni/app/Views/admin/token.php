<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Tokens</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
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
            <h1>Master Data Token</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>/admin">Home</a></li>
              <li class="breadcrumb-item active">Tokens</li>
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
            <div class="card card-primary card-outline shadow-sm">
              <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Token</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tokenTable" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th style="text-align:center; width: 80px;">No.</th>
                    <th style="text-align:center;">Token</th>
                    <th style="text-align:center;">Materi</th>
                    <th style="text-align:center;">Dibuat Oleh</th>
                    <th style="text-align:center;">Tanggal Dibuat</th>
                    <th style="text-align:center;">Tanggal Kedaluwarsa</th>
                    <th style="text-align:center; width: 120px;">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                    foreach ($tokens as $key) {
                    ?>
                  <tr>
                    <td style="text-align:center; vertical-align: middle;"><?= $no++ ?></td>
                    <td style="text-align:center; vertical-align: middle; font-weight: bold; font-size: 16px; color: #3c8dbc;"><?= esc($key->token) ?></td>
                    <td style="vertical-align: middle;"><?= esc($key->materi_nm) ?></td>
                    <td style="text-align:center; vertical-align: middle;"><?= esc($key->created_user) ?></td>
                    <td style="text-align:center; vertical-align: middle;"><?= esc($key->created_dttm) ?></td>
                    <td style="text-align:center; vertical-align: middle;">
                      <?= $key->expired_dttm ? date('d-m-Y H:i:s', strtotime($key->expired_dttm)) : '<span class="badge badge-success">Selamanya</span>' ?>
                    </td>
                    <td style="text-align:center; vertical-align: middle;">
                      <button onclick="edittoken(<?= $key->token_id ?>, '<?= esc($key->token) ?>', '<?= $key->materi_id ?>', '<?= $key->expired_dttm ?>')" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</button>
                      <button onclick="hapustoken(<?= $key->token_id ?>)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                    </td>
                  </tr>
                    <?php
                    }
                    ?>
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-key"></i> Tambah Token Baru</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="form-tambah-token">
            <div class="modal-body">
              <div class="form-group">
                <label for="token">Token</label>
                <input type="text" class="form-control" id="token" name="token" placeholder="Masukkan Kode Token (maksimal 6 karakter)" required autocomplete="off" style="text-transform: uppercase;" maxlength="6">
              </div>
              <div class="form-group">
                <label for="materi_id">Materi (Bisa pilih lebih dari satu)</label>
                <select class="form-control select2" id="materi_id" name="materi_id[]" multiple="multiple" required data-placeholder="-- Pilih Materi --" style="width: 100%;">
                  <?php foreach ($materi as $m): ?>
                    <option value="<?= $m->materi_id ?>"><?= esc($m->materi_nm) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="expired_dttm">Waktu Kedaluwarsa (Optional)</label>
                <input type="datetime-local" class="form-control" id="expired_dttm" name="expired_dttm">
                <small class="form-text text-muted">Kosongkan jika token tidak ada batas waktu (aktif selamanya).</small>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal-tambah -->

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content shadow-lg">
          <div class="modal-header bg-warning">
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Token</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="form-edit-token">
            <input type="hidden" id="edit_token_id" name="token_id">
            <div class="modal-body">
              <div class="form-group">
                <label for="edit_token">Token</label>
                <input type="text" class="form-control" id="edit_token" name="token" placeholder="Masukkan Kode Token (maksimal 6 karakter)" required autocomplete="off" style="text-transform: uppercase;" maxlength="6">
              </div>
              <div class="form-group">
                <label for="edit_materi_id">Materi</label>
                <select class="form-control select2-edit" id="edit_materi_id" name="materi_id" required data-placeholder="-- Pilih Materi --" style="width: 100%;">
                  <option value=""></option>
                  <?php foreach ($materi as $m): ?>
                    <option value="<?= $m->materi_id ?>"><?= esc($m->materi_nm) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="edit_expired_dttm">Waktu Kedaluwarsa (Optional)</label>
                <input type="datetime-local" class="form-control" id="edit_expired_dttm" name="expired_dttm">
                <small class="form-text text-muted">Kosongkan jika token tidak ada batas waktu (aktif selamanya).</small>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2026 <a href="#">Bintang Timur Prestasi</a>.</strong> All rights reserved.
  </footer>

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
<!-- Select2 -->
<script src="<?= base_url() ?>/plugins/select2/js/select2.full.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $('#tokenTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    // Initialize Select2 with dropdownParent for Bootstrap Modals
    $('#materi_id').select2({
      theme: 'bootstrap4',
      dropdownParent: $('#modal-tambah'),
      placeholder: '-- Pilih Materi --',
      allowClear: true
    });

    $('#edit_materi_id').select2({
      theme: 'bootstrap4',
      dropdownParent: $('#modal-edit'),
      placeholder: '-- Pilih Materi --',
      allowClear: true
    });

    $("#form-tambah-token").on("submit", function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url('admin/token/simpan') ?>",
        type: "post",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status === 'sukses') {
            $('#modal-tambah').modal("hide");
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Token berhasil disimpan!'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: response.message || "Gagal menyimpan token"
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Gagal terhubung ke server"
          });
        }
      });
    });

    $("#form-edit-token").on("submit", function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url('admin/token/update') ?>",
        type: "post",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status === 'sukses') {
            $('#modal-edit').modal("hide");
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Token berhasil diperbarui!'
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: response.message || "Gagal memperbarui token"
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Gagal terhubung ke server"
          });
        }
      });
    });
  });

  function edittoken(token_id, token, materi_id, expired_dttm) {
    $("#edit_token_id").val(token_id);
    $("#edit_token").val(token);
    $("#edit_materi_id").val(materi_id).trigger('change');
    if (expired_dttm && expired_dttm !== 'null' && expired_dttm !== '') {
      let formattedDate = expired_dttm.replace(' ', 'T').substring(0, 16);
      $("#edit_expired_dttm").val(formattedDate);
    } else {
      $("#edit_expired_dttm").val('');
    }
    $("#modal-edit").modal("show");
  }


  function hapustoken(token_id) {
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Token ini akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= base_url('admin/token/hapus') ?>",
          type: "post",
          data: { "token_id": token_id },
          dataType: "json",
          success: function(response) {
            if (response.status === 'sukses') {
              Swal.fire({
                icon: 'success',
                title: 'Dihapus!',
                text: 'Token berhasil dihapus.'
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message || "Gagal menghapus token"
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: "Gagal terhubung ke server"
            });
          }
        });
      }
    });
  }
</script>
</body>
</html>
