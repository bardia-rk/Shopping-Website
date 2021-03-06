<?php

require_once("../config/DBConfig.php");
if ($_POST) {
  $message = "";
  $username = $_POST["username"];
  $password = $_POST["password"];
  $command = "select * from login where(username = ?)";
  $stmt = $conn->prepare($command);
  $stmt->bind_param("s", $username); // there is one String to Bind ("s")
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
      $passHash = $row["password"];
      if (password_verify($password, $passHash)) {
        header('Location: dashboard.php');
      } else {
        $message = '<p class="alert alert-danger">نام کاربری یا رمز عبور اشتباه است</p>';
      }
    }
  } else {
    $message = '<p class="alert alert-danger">نام کاربری یا رمز عبور اشتباه است</p>';
  }
}


?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>پنل مدیریت | صفحه ورود</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="dist/css/bootstrap-rtl.min.css">
  <!-- template rtl version -->
  <link rel="stylesheet" href="dist/css/custom-style.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index2.php"><b>ورود به سایت</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">فرم زیر را تکمیل کنید و ورود بزنید</p>
        <?php
        if (isset($message))
          echo $message;
        ?>
        <form method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="نام کاربری">
            <div class="input-group-append">
              <span class="fa fa-user input-group-text"></span>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="رمز عبور">
            <div class="input-group-append">
              <span class="fa fa-lock input-group-text"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> یاد آوری من
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">ورود</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      })
    })
  </script>
</body>

</html>