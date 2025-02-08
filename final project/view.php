<?php
include 'inc/header.php';
Session::CheckSession();

 ?>

<?php

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}




 ?>

<div class="card ">
  <div class="card-header">
    <center>
      <h3>ข้อมูลส่วนตัว <span class="text-center"></h3>
    </center>
  </div>
  <div class="card-body">
    <?php
    $getUinfo = $users->getUserInfoById($userid);
    if ($getUinfo) {
    ?>
    <div style="width:800px; margin:0px auto">
      <form class="" action="" method="POST">
        <center>
          <div class="form-group-image">
            <label for="img_profile">รูปนักศึกษาของคุณ</label>
            <br>
            <?php if (!empty($getUinfo->img_profile)): ?>
            <img src="assets/images/upload/<?php echo $getUinfo->img_profile; ?>" alt="Profile Image"
              style="max-width: 350px; max-height: 350px; object-fit: cover;">
            <?php else: ?>
            <p>ไม่มีรูปภาพในระบบ</p>
            <?php endif; ?>
          </div>
        </center>
        <br>
        <div class="form-group row">
          <div class="col-md-6">
            <label for="user_id">รหัสนักศึกษา</label>
            <input type="text" name="user_id" readonly value="<?php echo $getUinfo->user_id; ?>" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="name">ชื่อจริง + นามสกุล</label>
            <input type="text" name="name" readonly value="<?php echo $getUinfo->name; ?>" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-6">
            <label for="username">ชื่อเล่น</label>
            <input type="text" name="username" readonly value="<?php echo $getUinfo->username; ?>" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="religion">ศาสนา</label>
            <input type="text" name="religion" readonly value="<?php echo $getUinfo->religion; ?>" class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="birthdate">วันเกิด</label>
            <input type="text" name="birthdate" readonly value="<?php echo $getUinfo->birthdate; ?>"
              class="form-control">
          </div>
          <div class="col-md-6">
            <label for="age">อายุ</label>
            <input type="text" name="age" readonly value="<?php echo $getUinfo->age; ?>" class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="university">มาจาก</label>
          <input type="text" name="university" readonly value="<?php echo $getUinfo->university; ?>"
            class="form-control">
        </div>

        <div class="form-group row">
          <div class="col-md-4">
            <label for="faculty">คณะ</label>
            <input type="text" name="faculty" readonly value="<?php echo $getUinfo->faculty; ?>" class="form-control">
          </div>
          <div class="col-md-4">
            <label for="branch">สาขา</label>
            <input type="text" name="branch" readonly value="<?php echo $getUinfo->branch; ?>" class="form-control">
          </div>
          <div class="col-md-4">
            <label for="year">ชั้นปี</label>
            <input type="text" name="year" readonly value="<?php echo $getUinfo->year; ?>" class="form-control">
          </div>
        </div>


        <div class="form-group row">
          <div class="col-md-6">
            <label for="email">อีเมล</label>
            <input type="email" id="email" name="email" readonly value="<?php echo $getUinfo->email; ?>"
              class="form-control">
          </div>
          <div class="col-md-6">
            <label for="mobile">เบอร์โทรศัพท์</label>
            <input type="text" id="mobile" name="mobile" readonly value="<?php echo $getUinfo->mobile; ?>"
              class="form-control">
          </div>
        </div>

        <div class="form-group">
          <label for="address">ที่อยู่</label>
          <input type="text" name="address" readonly value="<?php echo $getUinfo->address; ?>" class="form-control">
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="guardian_name">ชื่อผู้ปกครอง</label>
            <input type="text" name="guardian_name" readonly value="<?php echo $getUinfo->guardian_name; ?>"
              class="form-control">
          </div>
          <div class="col-md-6">
            <label for="guardian_mobile">เบอร์โทรผู้ปกครอง</label>
            <input type="text" name="guardian_mobile" readonly value="<?php echo $getUinfo->guardian_mobile; ?>"
              class="form-control">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6">
            <label for="room_number">หมายเลขห้อง</label>
            <input type="text" name="room_number" readonly value="<?php echo $getUinfo->room_number; ?>"
              class="form-control">
          </div>
          <div class="col-md-6">
            <label for="room_status">สถานะห้องพัก</label>
            <input type="text" name="room_status" readonly value="<?php echo $getUinfo->room_status; ?>"
              class="form-control">
          </div>
        </div>


        <div class="form-group row">
          <div class="col-md-6">
            <label for="created_at">ถูกสร้างเมื่อ</label>
            <input type="text" name="created_at" readonly value="<?php echo $getUinfo->created_at; ?>"
              class="form-control">
          </div>
          <div class="col-md-6">
            <label for="updated_at">ถูกอัปเดตเมื่อ</label>
            <input type="text" name="updated_at" readonly value="<?php echo $getUinfo->updated_at; ?>"
              class="form-control">
          </div>
        </div>


        <?php if (Session::get("roleid") == '1') { ?>

        <div class="form-group
              <?php if (Session::get("roleid") == '1' && Session::get("id") == $getUinfo->id) {
                echo "d-none";
              } ?>
              ">
        </div>

        <?php }else{?>
        <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
        <?php } ?>

        <?php if (Session::get("id") == $getUinfo->id) {?>



        <?php   }else{ ?>
        <div class="form-group">
          <center>
            <a class="btn btn-primary" href="index.php">กลับ</a>
          </center>
        </div>
        <?php } ?>
        <div class="form-group">
          <center>
            <a class="btn btn-primary" href="index.php">กลับ</a>
          </center>
        </div>
      </form>
    </div>
    <?php }else{
        header('Location:index.php');
      } ?>
  </div>
</div>

<?php
  include 'inc/footer.php';
?>