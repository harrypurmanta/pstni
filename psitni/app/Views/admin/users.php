<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Data Users</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/adminlte.min.css">

  <style>
    .btn-group .btn {
      margin: 0 2px;
      border-radius: 4px !important;
    }
    .table td, .table th {
      vertical-align: middle !important;
    }
  </style>
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
            <h1 class="m-0 text-dark"><i class="fas fa-users-cog mr-2"></i> Managemen Data Users</h1>
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
            <div class="card card-primary card-outline shadow">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title"><i class="fas fa-table mr-1"></i> Daftar Pengguna</h3>
                <button onclick="tambahuser()" class="btn btn-success ml-auto" data-toggle="modal" data-target="#modal-lg">
                  <i class="fas fa-plus mr-1"></i> Tambah User
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped table-hover">
                  <thead class="bg-light">
                  <tr>
                    <th class="text-center" style="width: 5%">No.</th>
                    <th>Nama</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">TTL</th>
                    <th class="text-center" style="width: 8%">Gender</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">No. HP</th>
                    <th>Alamat</th>
                    <th class="text-center" style="width: 8%">Level</th>
                    <th class="text-center" style="width: 15%">Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                    foreach ($users as $key) {
                    ?>
                  <tr>
                    <td class="text-center font-weight-bold"><?= $no++ ?></td>
                    <td class="font-weight-bold text-gray-dark"><?= esc($key->person_nm) ?></td>
                    <td class="text-center"><?= esc($key->satuan) ?></td>
                    <td class="text-center">
                      <?= esc($key->birth_place) ?><br>
                      <small class="text-muted"><i class="far fa-calendar-alt"></i> <?= esc(date("d-m-Y", strtotime($key->birth_dttm))) ?></small>
                    </td>
                    <td class="text-center">
                      <?php if ($key->gender_cd == 'l'): ?>
                        <span class="badge bg-info"><i class="fas fa-mars mr-1"></i> L</span>
                      <?php else: ?>
                        <span class="badge bg-danger"><i class="fas fa-venus mr-1"></i> P</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center"><code class="text-primary font-weight-bold"><?= esc($key->user_nm) ?></code></td>
                    <td class="text-center"><?= esc($key->cellphone) ?></td>
                    <td class="small"><?= esc($key->addr_txt) ?></td>
                    <td class="text-center">
                      <?php if ($key->user_group == 'admin'): ?>
                        <span class="badge badge-danger shadow-sm"><i class="fas fa-user-shield mr-1"></i> Admin</span>
                      <?php else: ?>
                        <span class="badge badge-success shadow-sm"><i class="fas fa-user mr-1"></i> Siswa</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <div class="btn-group">
                        <button onclick="editperson(<?= $key->person_id ?>)" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#modal-lg" title="Edit User">
                          <i class="fa fa-pencil-alt"></i>
                        </button>
                        <a href="<?= base_url('admin/hasil/' . $key->user_id) ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Detail Hasil">
                          <i class="fa fa-eye"></i> Detail
                        </a>
                        <a href="<?= base_url('admin/users/resetmateri/' . $key->user_id) ?>" class="btn btn-sm btn-outline-warning" title="Reset Materi">
                          <i class="fa fa-sync-alt"></i> Reset
                        </a>
                        <button onclick="hapusperson(<?= $key->person_id ?>)" class="btn btn-sm btn-outline-danger" title="Hapus User">
                          <i class="fa fa-trash"></i>
                        </button>
                      </div>
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

    <!-- Modal Dialog -->
    <div class="modal fade" id="modal-lg">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" id="modal_content">
           <!-- Loaded Dynamically via AJAX -->
        </div>
      </div>
    </div>

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/dist/js/adminlte.min.js"></script>

<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "paginate": {
          "first": "Pertama",
          "last": "Terakhir",
          "next": "Selanjutnya",
          "previous": "Sebelumnya"
        }
      }
    });
  });

  function tambahuser() {
    $('#modal_content').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2">Memuat form...</p></div>');
    $.ajax({
        url: "<?= base_url('admin/users/tambahuser') ?>",
        success: function(data) {
          $('#modal_content').html(data);
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error (tambahuser):", error, xhr.responseText);
          Swal.fire("Error", "Gagal memuat form tambah user.<br><small class='text-danger'>" + (error || xhr.statusText) + "</small>", "error");
        }
      });
  }

  function editperson(person_id) {
    $('#modal_content').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x text-success"></i><p class="mt-2">Memuat form...</p></div>');
    $.ajax({
        url: "<?= base_url('admin/users/edituser') ?>",
        type: "post",
        dataType: "html",
        data: {
          "person_id": person_id
        },
        success: function(data) {
          $('#modal_content').html(data);
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error (editperson):", error, xhr.responseText);
          let rawError = xhr.responseText ? xhr.responseText.substring(0, 500) : error;
          Swal.fire({
            icon: "error",
            title: "Error",
            html: "Gagal memuat form edit user.<br><pre class='text-danger text-left bg-light p-2 mt-2' style='font-size:11px; max-height:200px; overflow-y:auto; border-radius:4px;'>" + rawError.replace(/</g, "&lt;").replace(/>/g, "&gt;") + "</pre>"
          });
        }
      });
  }

  function simpanuser() {
      var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
      var user_group = $("#user_group").val();
      var email = $("#email").val();

      if (!person_nm || !user_nm) {
          Swal.fire("Peringatan", "Nama dan Username wajib diisi!", "warning");
          return;
      }
     
      $.ajax({
        url: "<?= base_url('admin/users/simpanuser') ?>",
        type: "post",
        dataType: "json",
        data: {
            "person_nm" : person_nm,
            "satuan" : satuan,
            "birth_place" : birth_place,
            "birth_dttm" : birth_dttm,
            "cellphone" : cellphone,
            "addr_txt" : addr_txt,
            "user_nm" : user_nm,
            "user_group" : user_group,
            "gender_cd" : gender_cd,
            "email" : email
        },
        success: function(data) {
          $('#modal-lg').modal("hide");
          Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'User baru telah berhasil ditambahkan!'
          }).then(() => {
              location.reload();
          });
        },
        error: function() {
          Swal.fire("Error", "Gagal menyimpan user baru", "error");
        }
      });
  }

  function updateuser(person_id) {
      var person_nm = $("#person_nm").val();
      var satuan = $("#satuan").val();
      var birth_place = $("#birth_place").val();
      var birth_dttm = $("#birth_dttm").val();
      var cellphone = $("#cellphone").val();
      var addr_txt = $("#addr_txt").val();
      var user_nm = $("#user_nm").val();
      var gender_cd = $("#gender_cd").val();
      var user_group = $("#user_group").val();
      var email = $("#email").val();

      if (!person_nm || !user_nm) {
          Swal.fire("Peringatan", "Nama dan Username wajib diisi!", "warning");
          return;
      }
    
      $.ajax({
        url: "<?= base_url('admin/users/updateuser') ?>",
        type: "post",
        dataType: "json",
        data: {
            "person_nm" : person_nm,
            "satuan" : satuan,
            "birth_place" : birth_place,
            "birth_dttm" : birth_dttm,
            "cellphone" : cellphone,
            "addr_txt" : addr_txt,
            "user_nm" : user_nm,
            "user_group" : user_group,
            "gender_cd" : gender_cd,
            "person_id" : person_id,
            "email" : email
        },
        success: function(data) {
          $('#modal-lg').modal("hide");
          Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: 'Data user berhasil diperbarui!'
          }).then(() => {
              location.reload();
          });
        },
        error: function() {
          Swal.fire("Error", "Gagal memperbarui data user", "error");
        }
      });
  }

  function hapusperson(person_id) {
      Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Seluruh data user ini akan dinonaktifkan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                url: "<?= base_url('admin/users/hapususer') ?>",
                type: "post",
                dataType: "json",
                data: {
                  "person_id": person_id
                },
                success: function(data) {
                  Swal.fire(
                    'Berhasil!',
                    'User telah dihapus.',
                    'success'
                  ).then(() => {
                      location.reload();
                  });
                },
                error: function() {
                  Swal.fire("Error", "Gagal menghapus user", "error");
                }
              });
          }
      });
  }
</script>
</body>
</html>