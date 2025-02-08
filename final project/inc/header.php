<?php

  $filepath = realpath(dirname(__FILE__));
  include_once $filepath."/../lib/Session.php";
  Session::init();

  spl_autoload_register(function($classes){

  include 'classes/'.$classes.".php";

  });

  $users = new Users();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบจัดเก็บข้อมูลหอพักหญิง</title>
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/style.css">
  <link rel="icon" type="image" href="assets/images/Logocpu.png">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

  <?php
  if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  // Session::set('logout', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  // <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  // <strong>Success !</strong> You are Logged Out Successfully !</div>');
  Session::destroy();
  }
  ?>

  <style>
  body {
    padding-top: 130px;
    /* ปรับตามความสูงของ header */
  }
  </style>
  <nav class="navbar navbar-expand-md" style="background-color: #FFD700; height: 50px;">
    <div class="container">
      <div class="top-number" style="position: absolute; top: 10px; right: 0; margin-right: 10px; text-align: right;">
        <p style="margin-right: 5px; display: inline-block;"><i class="fa fa-phone-square"></i> +056-245-501 /
          +056-245-502</p>
        <a href="#" style="margin-right: 3px;"><img src="https://www.cpu.ac.th/piccpu/united_kingdom.png" alt="UK Flag"
            width="" height=""></a>
        <a href="#" style="margin-right: 3px;"><img src="https://www.cpu.ac.th/piccpu/china.png" alt="China Flag"
            width="" height=""></a>
        <a href="#"><img src="https://www.cpu.ac.th/piccpu/vietnam.png" alt="Vietnam Flag" width="30" height=""></a>
      </div>
  </nav>
  <nav class="navbar navbar-expand-md" style="background-color: white;">
    <a class="navbar-brand" href="index.php" style="display: flex; align-items: center; text-decoration: none;">
      <img src="assets/images/CPuLo.png" alt="Logo" style="height: 80px; margin-right: 20px;">
      <span>ระบบจัดเก็บข้อมูลหอพักหญิง</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
      aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav ml-auto">
        <?php if (Session::get('id') == TRUE) { ?>
        <?php if (Session::get('roleid') == '1') { ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="fas fa-users mr-2"></i>ข้อมูลนักศึกษา</span></a>
        </li>
        <li class="nav-item
              <?php
                          $path = $_SERVER['SCRIPT_FILENAME'];
                          $current = basename($path, '.php');
                          if ($current == 'addUser') {
                            echo " active ";
                          }
              ?>">
          <a class="nav-link" href="addUser.php"><i class="fas fa-user-plus mr-2"></i>เพิ่มผู้สมาชิก</span></a>
        </li>
        <li class="nav-item
              <?php
                          $path = $_SERVER['SCRIPT_FILENAME'];
                          $current = basename($path, '.php');
                          if ($current == 'addUser') {
                            echo " active ";
                          }
              ?>">
          <a class="nav-link" href="print.php"><i class="fas fa-print mr-2"></i>พิมพ์ข้อมูล</span></a>
        </li>
        <?php  } ?>
        <a class="nav-link" href="https://www.cpu.ac.th" target="_blank"><i
            class="fas fa-university mr-2"></i>มหาวิทยาลัยเจ้าพระยา<span class="sr-only">(current)</span></a>
        </li>
        <a class="nav-link" href="document.php?id=<?php echo Session::get("id"); ?>"><i
            class="fa fa-file mr-2"></i>เอกสาร<span class="sr-only">(current)</span></a>
        </li>
        <a class="nav-link" href="contact.php?id=<?php echo Session::get("id"); ?>"><i
            class="fas fa-comments mr-2"></i>ติดต่อเรา<span class="sr-only">(current)</span></a>
        </li>

        <!-- Dropdown for name -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <strong>
              <span class="badge badge-lg badge-primary text-white">
                <?php 
          $name = Session::get('name'); 
          if (isset($name)) {
            echo $name; 
          } 
        ?>
              </span>
            </strong>
          </a>
          <div class="dropdown-menu" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="view.php?id=<?php echo Session::get("id"); ?>">ข้อมูลส่วนตัว</a>
            <a class="dropdown-item" href="profile.php?id=<?php echo Session::get("id"); ?>">แก้ไขข้อมูลส่วนตัว</a>
            <a class="dropdown-item" href="?action=logout">ออกจากระบบ</a>
          </div>
        </li>

        <?php }else{ ?>
        <a class="nav-link" href="home.php"><i class="fa fa-home mr-2"></i>หน้าหลัก</a>
        <a class="nav-link" href="https://www.cpu.ac.th" target="_blank"><i
            class="fas fa-university mr-2"></i>มหาวิทยาลัยเจ้าพระยา</a>
        <a class="nav-link" href="about_us.php"><i class="fa fa-address-card mr-2"></i>เกียวกับเรา</a>

        <a class="nav-link" href="contact.php"><i class="fas fa-comments mr-2"></i>ติดต่อเรา</a>

        <li class="nav-item
              <?php
                          $path = $_SERVER['SCRIPT_FILENAME'];
                          $current = basename($path, '.php');
                          if ($current == 'register') {
                            echo " active ";
                          }
              ?>">
          <a class="nav-link" href="register.php"><i class="fas fa-user-plus mr-2"></i>ลงทะเบียน</a>
        </li>
        <li class="nav-item
                <?php
                    $path = $_SERVER['SCRIPT_FILENAME'];
                    $current = basename($path, '.php');
                    if ($current == 'login') {
                    echo " active ";
                    }
                  ?>">
          <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt mr-2"></i>เข้าสู่ระบบ</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>

  </body>

  </html>