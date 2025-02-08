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
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>

</head>

<body>

  <div class="container" style="max-width: 1600px;">
    <div class="card ">
      <center>
        <div class="card-header">
          <h3><i class="fas fa-users mr-2"></i>รายชื่อนักศึกษา</h3>
        </div>
      </center>
      <div class="card-header">
        <h3 class="text-left">
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
              <td><?php echo $value->name; ?></td>
              <td><?php echo $value->university; ?> </td>
              <td><?php echo $value->faculty; ?> </td>
              <td><?php echo $value->branch; ?> </td>
              <td><?php echo $value->mobile; ?></td>
              <td><?php echo $value->room_number; ?> </td>
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

  <script>
  new DataTable('#example', {
    dom: 'Bfrtip',
    buttons: [{
        extend: 'pdfHtml5',
        text: 'ดาวน์โหลด PDF',
        title: 'ระบบจัดเก็บข้อมูลหอพักหญิง', // ชื่อไฟล์ PDF
        filename: 'ระบบจัดเก็บข้อมูลหอพักหญิง', // ชื่อไฟล์ที่ดาวน์โหลด
        className: 'btn-pdf', // ใช้คลาส CSS ที่กำหนด
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'excelHtml5',
        text: 'ดาวน์โหลด Excel',
        title: 'ระบบจัดเก็บข้อมูลหอพักหญิง',
        filename: 'ระบบจัดเก็บข้อมูลหอพักหญิง',
        className: 'btn-excel',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'copyHtml5',
        text: 'คัดลอกข้อมูล',
        className: 'btn-copy',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        text: 'พิมพ์',
        className: 'btn-print',
        exportOptions: {
          columns: ':visible'
        }
      }
    ]
  });
  </script>
</body>

</html>

<nav class=" navbar-expand-md" style="background-color: #5FA7E8; height: 15px;">
  </nav>
  <footer class="footer " style="padding-left: 100px; padding-right: 100px;background-color: #FFD700;">
    <div class="row">
      <!-- หน่วยงานภายใน --->
      <div class="col-md-2">
        <br>
        <h6 style="color: blue; font-weight: bold;">หน่วยงานภายใน</h6>
        <ul class="list-unstyled nav-links">
          <li>
            <a href="http://oweb.cpu.ac.th/presidentoffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักอธิการบดี
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/adminoffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักการเงินการคลัง
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/financeoffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักการเงินการคลัง
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/presidentoffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักทะเบียนและวัดผล
            </a>
          </li>
          <li>
            <a href="https://sites.google.com/cpu.ac.th/cwie/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              ศูนย์สหกิจศึกษาและบูรณาการกับการทำงาน
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/web_QA/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักประกันคุณภาพการศึกษา
            </a>
          </li>

        </ul>
      </div>
      <div class="col-md-2">
        <ul class="list-unstyled nav-links">
          <br>
          <br>
          <li>
            <a href="http://elearning.cpu.ac.th/research/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักวิจัย
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/generaloffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักศึกษาทั่วไป
            </a>
          </li>
          <li>
            <a href="http://library.cpu.ac.th/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักวิทยบริการ
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/artcenter/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักแผนและพัฒนา
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/planningoffice" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              ศูนย์ศิลปวัฒนธรรม
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/itc/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              ศูนย์เทคโนโลยีสารสนเทศ
            </a>
          </li>
          <li>
            <a href="https://sites.google.com/cpu.ac.th/to-be-number-one-chaopraya-une" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              To be number one chaopraya
            </a>
          </li>

        </ul>
      </div>
      <div class="col-md-2">
        <ul class="list-unstyled nav-links">
          <br>
          <br>
          <li>
            <a href="http://oweb.cpu.ac.th/s_affair/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักพัฒนานักศึกษา
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/academicoffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักส่งเสริมวิชาการ
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/cpu2010/graduate/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              สำนักบัณฑิตศึกษา
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/researchtestoffice/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              ศูนย์พัฒนาแบบทดสอบและการประเมินผล
            </a>
          </li>

          </li>
        </ul>
      </div>
      <!-- คณะและภาควิชา  -->
      <div class="col-md-2">
        <br>
        <h6 style="color: blue; font-weight: bold;">คณะและภาควิชา</h6>
        <ul class="list-unstyled nav-links">
          <li>
            <a href="http://oweb.cpu.ac.th/bba/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              คณะบริหารและการจัดการ
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/cscm/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              คณะวิทยาศาสตร์และเทคโนโลยี
            </a>
          </li>
          <li>
            <a href="http://oweb.cpu.ac.th/hs/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              คณะมนุษยศาสตร์และสังคมศาสตร์
            </a>
          </li>

        </ul>
      </div>
      <!-- ลิงค์ในเครือ  -->
      <div class="col-md-2">
        <br>
        <h6 style="color: blue; font-weight: bold;">ลิงค์ในเครือ</h6>
        <ul class="list-unstyled nav-links">
          <li>
            <a href="https://www.ktisgroup.com/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              KTIS GROUP
            </a>
          </li>
          <li>
            <a href="http://www.viriyalai.ac.th/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              วิทยาลัยอาชีวศึกษาวิริยาลัยนครสวรรค์ (VCC)
            </a>
          </li>
          <li>
            <a href="https://www.sappraiwan.com/" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'">
              Sappraiwan Elephant Resort & Sanctuary
            </a>
          </li>

        </ul>
      </div>
      <!-- ติดต่อเรา -->
      <div class="col-md-2">
        <br>
        <h6 style="color: blue; font-weight: bold;">Social Networks</h6>
        <ul class="list-unstyled nav-links">
          <li>
            <a href="https://www.facebook.com/ChaoprayaUniversity.NakhonSawan?ref=br_rs" target="_blank"
              style="font-size: 12px; color: black; text-decoration: none;" onmouseover="this.style.color='white'"
              onmouseout="this.style.color='black'" class="social-icon">
              <i class="fab fa-facebook-f"></i> Facebook
            </a>
          </li>
          <li>
            <a href="#" style="font-size: 12px; color: black; text-decoration: none;"
              onmouseover="this.style.color='white'" onmouseout="this.style.color='black'" class="social-icon">
              <i class="fab fa-instagram"></i> Instagram
            </a>
          </li>
          <li>
            <a href="#" style="font-size: 12px; color: black; text-decoration: none;"
              onmouseover="this.style.color='white'" onmouseout="this.style.color='black'" class="social-icon">
              <i class="fab fa-twitter"></i> Twitter
            </a>
          </li>
          <li>
            <a href="#" style="font-size: 12px; color: black; text-decoration: none;"
              onmouseover="this.style.color='white'" onmouseout="this.style.color='black'" class="social-icon">
              <i class="fab fa-youtube"></i> YouTube
            </a>
          </li>
        </ul>
      </div>
      <br>
      <div class="copyright" style="display: flex;  font-weight: bold; color: black; height: 50px;">
        © 2017 CHAOPRAYA UNIVERSITY
      </div>
    </div>
  </footer>
  <nav class="navbar navbar-expand-md" style="background-color: #FFA801; height: 30px;">
