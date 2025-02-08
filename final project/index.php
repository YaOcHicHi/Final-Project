<?php
include 'inc/header.php';
Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);
?>
<?php

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}

if (isset($removeUser)) {
  echo $removeUser;
}
if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}

if (isset($deactiveId)) {
  echo $deactiveId;
}
if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}

if (isset($activeId)) {
  echo $activeId;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <div class="container" style="max-width: 1600px;">
    <div class="card ">
      <center>
        <div class="card-header">
          <h3><i class="fas fa-users mr-2"></i>รายชื่อนักศึกษา
          </h3>
        </div>
      </center>
      <div class="card-header">
        <h3 class="text-right">
          ยินดีต้อนรับ
          <strong>
            <span class="badge badge-lg badge-primary text-white">
              <?php 
        $username = Session::get('username'); 
        if (isset($username)) {
          echo $username; 
        } 
        ?>
            </span>
          </strong>
        </h3>

        <!-- เพิ่มปุ่มที่อยู่ด้านขวา -->

      </div>


      <div class="card-body pr-2 pl-2">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead style="background-color: #007bff; color: white; font-size: 16px;">
            <tr>
              <th class="text-center" style="width: 90px;">รหัสนักศึกษา</th>
              <th class="text-center" style="width: 200px;">ชื่อนักศึกษา</th>
              <th class="text-center" style="width: 150px;">มาจาก</th>
              <th class="text-center" style="width: 150px;">คณะ</th>
              <th class="text-center" style="width: 150px;">สาขา</th>
              <th class="text-center" style="width: 100px;">เบอร์โทรศัพท์</th>
              <th class="text-center" style="width: 100px;">หมายเลขห้อง</th>
              <th class="text-center" style="width: 200px;">ข้อมูลเพิ่มเติม</th>
            </tr>
          </thead>

          <tbody>
            <?php
                      $allUser = $users->selectAllUserData();
                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;
            ?>
            <tr class="text-center" <?php if (Session::get("id") == $value->id) {
                        echo "style='background:#d9edf7' ";
                      } ?>>

              <td><?php echo $value->user_id; ?></td>
              <td><?php echo $value->name; ?>
                <br>
                <?php if ($value->roleid  == '1'){
                          echo "<span class='badge badge-lg badge-info text-white'>แอดมิน</span>";
                        } elseif ($value->roleid == '2') {
                          echo "<span class='badge badge-lg badge-dark text-white'>ผู้แก้ใข</span>";
                        }elseif ($value->roleid == '3') {
                            echo "<span class='badge badge-lg badge-dark text-white'>ผู้ใช้งาน</span>";
                        } ?>
              </td>
              <td><?php echo $value->university; ?> </td>
              <td><?php echo $value->faculty; ?> </td>
              <td><?php echo $value->branch; ?> </td>
              <td><span class="badge badge-lg badge-secondary text-white"><?php echo $value->mobile; ?></span></td>
              <td><?php echo $value->room_number; ?> </td>
              <td>
                <?php if ( Session::get("roleid") == '1') {?>
                <a class="btn btn-success btn-sm
                            " href="view.php?id=<?php echo $value->id;?>">ดูข้อมูล</a>
                <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">แก้ใข</a>
                <a class="btn btn-danger btn-sm 
    <?php if (Session::get("id") == $value->id) { echo "disabled"; } ?>" href="#"
                  onclick="confirmDelete(event, '?remove=<?php echo $value->id; ?>')">
                  ลบ
                </a>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                function confirmDelete(event, url) {
                  event.preventDefault(); // หยุดการทำงานของลิงก์ชั่วคราว
                  Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'คุณต้องการลบข้อมูลนี้หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      // เปลี่ยนเส้นทางไปยัง URL ที่ต้องการลบ
                      window.location.href = url;
                    }
                  });
                }
                </script>


                <!--<?php if ($value->isActive == '0') {  ?>
                        <a onclick="return confirm('Are you sure To Deactive ?')" class="btn btn-warning
                      <?php if (Session::get("id") == $value->id) { echo "disabled";} ?>
                        btn-sm " href="?deactive=<?php echo $value->id;?>">Disable</a>
                      <?php } elseif($value->isActive == '1'){?>
                        <a onclick="return confirm('Are you sure To Active ?')" class="btn btn-secondary
                      <?php if (Session::get("id") == $value->id) {echo "disabled";} ?>
                        btn-sm " href="?active=<?php echo $value->id;?>">Active</a>
                      <?php } ?> -->

                <?php  }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '2'){ ?>
                <a class="btn btn-success btn-sm " href="view.php?id=<?php echo $value->id;?>">ดูข้อมูล</a>
                <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">แก้ใข</a>
                <?php  }elseif( Session::get("roleid") == '2'){ ?>
                <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="view.php?id=<?php echo $value->id;?>">ดูข้อมูล</a>
                <a class="btn btn-info btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">แก้ใข</a>
                <?php }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '3'){ ?>
                <a class="btn btn-success btn-sm " href="view.php?id=<?php echo $value->id;?>">ดูข้อมูล</a>
                <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">แก้ใข</a>
                <?php }else{ ?>
                <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="view.php?id=<?php echo $value->id;?>">ดูข้อมูล</a>
                <?php } ?>
              </td>
            </tr>
            <?php }}else{ ?>
            <tr class="text-center">
              <td>ไม่มีผู้ใช้งานในขณะนี้ !</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>
<?php
  include 'inc/footer.php';
?>