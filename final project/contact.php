<?php
include 'inc/header.php';

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
      <div class="card-header text-center">
        <h3>ติดต่อเรา</h3>
      </div>
      <div class="card-body text-center">
        <p>13/1 หมู่ 6 ตำบลหนองกรด อำเภอเมืองนครสวรรค์ จังหวัดนครสวรรค์ 60240</p>
        <img src="assets/images/mapcpu.jpg" alt="map" class="img-fluid mb-4">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3840.5297084626377!2d100.05022747582495!3d15.723092784907394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e0511bd6a49537%3A0x3e27f168729c39f2!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiI4LmJ4Liy4Lie4Lij4Liw4Lii4Liy!5e0!3m2!1sth!2sth!4v1730100150894!5m2!1sth!2sth"
          width="1400" height="500" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="container" style="max-width: 1600px;">
        <div class="card">
          <div class="card-body" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
            <!-- คอลัมซ้าย - แถวที่ 1 -->
            <div style="width: 48%; padding: 10px; text-align: center;">
              <h3>การรับ-ส่งธนาณัติและจดหมาย</h3>
            </div>

            <!-- คอลัมขวา - แถวที่ 1 -->
            <div style="width: 48%; padding: 10px; text-align: center;">
              <h3>การติดต่อสอบถาม</h3>
            </div>

            <!-- คอลัมซ้าย - แถวที่ 2 -->
            <div style="width: 48%; padding: 10px;">
              <p>มหาวิทยาลัย ได้จัดบริการ รับ-ส่งธนาณัติและจดหมายลงทะเบียนต่าง ๆ ให้กับนักศึกษาทุกคน
                กรณีที่ผู้ปกครองจะส่งธนาณัติมาให้นักศึกษา
                มหาวิทยาลัยจะรับธนาณัติมาให้กับนักศึกษาโดยที่นักศึกษาไม่ต้องไปติดต่อรับด้วยตนเองที่ไปรษณีย์
                แต่ขอให้ผู้ปกครองส่งธนาณัติในนามนักศึกษา และใช้ที่อยู่มหาวิทยาลัยเจ้าพระยา ตู้ ปณ.42 ปณจ. นครสวรรค์
                60240</p>
            </div>

            <!-- คอลัมขวา - แถวที่ 2 -->
            <div style="width: 48%; padding: 10px;">
              <p>ในกรณีที่ท่านผู้ปกครองมีปัญหาหรือข้อเสนอแนะหรือต้องการความช่วยเหลือจากมหาวิทยาลัย
                ให้ติดต่อได้ที่สำนักงานบริหาร ในเวลา 08.30 - 17.00 น. ทุกวัน (ไม่เว้นวันหยุดราชการ และวันนักขัตฤกษ์)
              </p>
            </div>
          </div>
        </div>
      </div>

      <br>
      <div class="text-center">
        <img src="assets/images/img03.jpg" alt="contact" class="img-fluid" style="max-width: 90%; height: auto;">
      </div>
      <br><br>
    </div>
  </div>

  <br><br>
</body>



</html>
<?php
  include 'inc/footer.php';
?>