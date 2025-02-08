<?php
include 'inc/header.php';
Session::CheckSession();
 ?>
<?php

 if (isset($_GET['id'])) {
   $userid = (int)$_GET['id'];

 }



 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass'])) {
    $changePass = $users->changePasswordBysingelUserId($userid, $_POST);
 }



 if (isset( $changePass)) {
   echo  $changePass;
 }
  ?>

<div class="card">
  <div class="card-header text-center">
    <h3>เปลี่ยนรหัสผ่านของคุณ</h3>
  </div>

  <div class="card-body">
    <div style="width:600px; margin:0px auto">
      <form action="" method="POST">
        <div class="form-group">
          <label for="old_password">รหัสผ่านเก่า</label>
          <input type="password" name="old_password" class="form-control" id="old_password" required>
        </div>
        <div class="form-group">
          <label for="new_password">รหัสผ่านใหม่</label>
          <input type="password" name="new_password" class="form-control" id="new_password" required>
        </div>
        <div class="form-group d-flex justify-content-between">
          <button type="submit" name="changepass" class="btn btn-success">เปลี่ยนรหัสผ่าน</button>
          <a href="index.php?id=<?php ?>" class="btn btn-primary">กลับ</a>
        </div>
      </form>
    </div>
  </div>
</div>

<br><br>

<?php
  include 'inc/footer.php';

  ?>