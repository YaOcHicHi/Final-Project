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
    <div class="card">
      <div class="card-header">
        <center>
          <h3>ข้อมูลสัญญาเช่าหอพักห้องพัดลม</h3>
        </center>
      </div>
      <div class="card-body">
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 80vh;">
          <h4 style="margin-bottom: 20px;">สัญญาเช่าหอพักนักศึกษาหญิงห้องพัดลม</h4>
          <object class="pdf" data="assets\pdf\สัญญาเช่าหอพักนักศึกษาหญิงห้องพัดลม.pdf" width="1000"
            height="700"></object>
        </div>
      </div>
      <br>
      <div class="card-header">
        <center>
          <h3>ข้อมูลสัญญาเช่าหอพักห้องแอร์</h3>
        </center>
      </div>
      <div class="card-body">
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 80vh;">
          <h4 style="margin-bottom: 20px;">สัญญาเช่าหอพักนักศึกษาหญิงห้องแอร์</h4>
          <object class="pdf" data="assets\pdf\สัญญาเช่าหอพักนักศึกษาหญิงห้องแอร์.pdf" width="1000"
            height="700"></object>
        </div>
      </div>
      <br>
      <div class="card-header">
        <center>
          <h3>ข้อมูลใบคำร้องขอลาออก</h3>
        </center>
      </div>
      <div class="card-body">
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 80vh;">
          <h4 style="margin-bottom: 20px;">ใบคำร้องขอลาออก (นักศึกษาหอพัก)</h4>
          <object class="pdf" data="assets\pdf\ใบคำร้องขอลาออก (นักศึกษาหอพัก).pdf" width="1000" height="700"></object>
        </div>
      </div>
      <br>
      <div class="card-header">
        <center>
          <h3>ข้อมูลแบบสำรวจอุปกรณ์</h3>
        </center>
      </div>
      <div class="card-body">
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 80vh;">
          <h4 style="margin-bottom: 20px;">แบบสำรวจอุปกรณ์</h4>
          <object class="pdf" data="assets\pdf\แบบสำรวจอุปกรณ์.pdf" width="1000" height="700"></object>
        </div>
      </div>
    </div>
  </div>
ิ<br>
</body>


</html>
<?php
  include 'inc/footer.php';
?>