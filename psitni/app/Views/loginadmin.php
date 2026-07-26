<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Login - Bintang Timur Prestasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/dist/dist/css/adminlte.min.css">

  <style>
    * {
      box-sizing: border-box;
    }
    
    body.login-page {
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
      font-family: 'Inter', 'Source Sans Pro', -apple-system, BlinkMacSystemFont, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 20px 15px;
      overflow-x: hidden;
    }

    .admin-login-wrapper {
      width: 100%;
      max-width: 440px;
      margin: 0 auto;
    }

    .card-login {
      background: rgba(30, 41, 59, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.12);
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-login:hover {
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.65);
    }

    .login-header {
      padding: 35px 30px 20px;
      text-align: center;
    }

    .admin-icon-box {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 30px;
      box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
      margin-bottom: 15px;
    }

    .login-header h3 {
      color: #ffffff;
      font-weight: 700;
      font-size: 24px;
      margin: 0 0 5px 0;
      letter-spacing: -0.5px;
    }

    .login-header p {
      color: #94a3b8;
      font-size: 14px;
      margin: 0;
    }

    .card-login-body {
      padding: 10px 30px 35px;
    }

    .form-group-custom {
      margin-bottom: 20px;
      position: relative;
    }

    .form-group-custom label {
      display: block;
      color: #cbd5e1;
      font-size: 13px;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrapper i.input-icon {
      position: absolute;
      left: 16px;
      color: #64748b;
      font-size: 16px;
      transition: color 0.3s ease;
      z-index: 2;
    }

    .form-control-custom {
      width: 100%;
      height: 50px;
      background: rgba(15, 23, 42, 0.6);
      border: 1.5px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 12px 16px 12px 46px;
      color: #f8fafc;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .form-control-custom:focus {
      background: rgba(15, 23, 42, 0.85);
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.25);
      outline: none;
      color: #ffffff;
    }

    .form-control-custom:focus + i.input-icon,
    .input-wrapper:focus-within i.input-icon {
      color: #3b82f6;
    }

    .form-control-custom::placeholder {
      color: #64748b;
    }

    .btn-toggle-password {
      position: absolute;
      right: 14px;
      background: none;
      border: none;
      color: #64748b;
      font-size: 16px;
      cursor: pointer;
      padding: 0;
      z-index: 2;
      transition: color 0.3s ease;
    }

    .btn-toggle-password:hover {
      color: #3b82f6;
    }

    .btn-login-submit {
      width: 100%;
      height: 50px;
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      border: none;
      border-radius: 12px;
      color: #ffffff;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: 25px;
    }

    .btn-login-submit:hover {
      background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
      box-shadow: 0 12px 25px rgba(37, 99, 235, 0.5);
      transform: translateY(-2px);
    }

    .btn-login-submit:active {
      transform: translateY(0);
    }

    .login-footer-text {
      text-align: center;
      color: #64748b;
      font-size: 12px;
      margin-top: 25px;
    }

    /* Media Queries for HP / Mobile Responsiveness */
    @media (max-width: 480px) {
      body.login-page {
        padding: 15px 10px;
      }
      .card-login-body {
        padding: 10px 20px 25px;
      }
      .login-header {
        padding: 25px 20px 15px;
      }
      .admin-icon-box {
        width: 60px;
        height: 60px;
        font-size: 24px;
      }
      .login-header h3 {
        font-size: 20px;
      }
      .form-control-custom {
        height: 46px;
        font-size: 14px;
      }
      .btn-login-submit {
        height: 46px;
        font-size: 15px;
      }
    }
  </style>
</head>
<body class="hold-transition login-page">

<div class="admin-login-wrapper">
  <div class="card-login">
    <div class="login-header">
      <div class="admin-icon-box">
        <i class="fas fa-user-shield"></i>
      </div>
      <h3>Admin Portal</h3>
      <p>Bintang Timur Prestasi</p>
    </div>

    <div class="card-login-body">
      <form action="<?= base_url() ?>/belakang/checklogin" method="post">
        <div class="form-group-custom">
          <label for="username">Username</label>
          <div class="input-wrapper">
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="Masukkan username admin" required autocomplete="username" autofocus>
          </div>
        </div>

        <div class="form-group-custom">
          <label for="password">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="Masukkan password" required autocomplete="current-password">
            <button type="button" class="btn-toggle-password" id="togglePassword" title="Tampilkan/Sembunyikan Password">
              <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-login-submit">
          <i class="fas fa-sign-in-alt"></i> Masuk Admin
        </button>
      </form>

      <div class="login-footer-text">
        &copy; <?= date('Y') ?> Bintang Timur Prestasi. All rights reserved.
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function() {
    $('#togglePassword').on('click', function() {
      const passwordInput = $('#password');
      const eyeIcon = $('#eyeIcon');
      
      if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        passwordInput.attr('type', 'password');
        eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
  });
</script>

</body>
</html>