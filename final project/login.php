<?php
  include 'inc/header.php';
  Session::CheckLogin();
?>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
  $userLog = $users->userLoginAuthotication($_POST);
}
  if (isset($userLog)) {
  echo $userLog;
}
  $logout = Session::get('logout');
  if (isset($logout)) {
  echo $logout;
}
?>

<div class="card ">
  <div class="card-header">
    <h3 class='text-center'><i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบหอพักนักศึกษาหญิง</h3>
  </div>
  <div class="card-body">
    <div style="width:450px; margin:0px auto">
      <form class="" action="" method="post">
      <br>
        <div class="form-group">
          <label for="email">อีเมล</label>
          <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
          <center>
          <button type="submit" name="login" class="btn btn-primary">เข้าสู่ระบบ</button>
          </center>
        </div>
      </form>
    </div>
  </div>
</div>
<br><br><br><br>

<?php
  include 'inc/footer.php';
?>