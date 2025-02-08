<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
</body>

</html>

<?php

include 'lib/Database.php'; // นำเข้าไฟล์ Database.php
include_once 'lib/Session.php'; // นำเข้าไฟล์ Session.php เพียงครั้งเดียว

class Users
{

  // คุณสมบัติของ Db (Database)
  private $db;

  // เมธอด __construct สำหรับ Db
  public function __construct()
  {
    $this->db = new Database(); // สร้างอินสแตนซ์ของคลาส Database
  }

  // เมธอดสำหรับจัดรูปแบบวันที่
  public function formatDate($date)
  {
    // date_default_timezone_set('Asia/Dhaka'); // กำหนดเขตเวลาเป็น Asia/Dhaka (คอมเม้นไว้)
    $strtime = strtotime($date); // แปลงวันที่เป็น timestamp
    return date('Y-m-d H:i:s', $strtime); // คืนค่ารูปแบบวันที่แบบ Y-m-d H:i:s
  }

  // เมธอดตรวจสอบว่าอีเมลมีอยู่หรือไม่
  public function checkExistEmail($email)
  {
    $sql = "SELECT email from  tbl_users WHERE email = :email"; // สร้างคำสั่ง SQL เพื่อเลือกอีเมลจากตาราง tbl_users
    $stmt = $this->db->pdo->prepare($sql); // เตรียมคำสั่ง SQL
    $stmt->bindValue(':email', $email); // ผูกค่าของพารามิเตอร์ :email กับตัวแปร $email
    $stmt->execute(); // ดำเนินการคำสั่ง SQL
    if ($stmt->rowCount() > 0) { // ตรวจสอบจำนวนแถวที่ได้จากการดำเนินการ
      return true; // คืนค่า true ถ้ามีข้อมูล
    } else {
      return false; // คืนค่า false ถ้าไม่มีข้อมูล
    }
  }


  // วิธีการลงทะเบียนผู้ใช้
  public function userRegistration($data)
  {
    
    $user_id = $data['user_id'];
    $name = $data['name'];
    $username = $data['username'];
    $religion = $data['religion'];
    $birthdate = $data['birthdate'];
    $age = $data['age'];
    $university = isset($data['university']) ? $data['university'] : null;
    $faculty = isset($data['faculty']) ? $data['faculty'] : null;
    $branch = isset($data['branch']) ? $data['branch'] : null;
    $year = isset($data['year']) ? $data['year'] : null;
    $email = $data['email'];
    $mobile = $data['mobile'];
    $address = $data['address'];
    $guardian_name = $data['guardian_name'];
    $guardian_mobile = $data['guardian_mobile'];
    $room_number = $data['room_number'];
    $room_status = isset($data['room_status']) ? $data['room_status'] : null;
    $roleid = $data['roleid'];
    $password = $data['password'];

    // Image upload variables
    $target_dir = "assets/images/upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $checkEmail = $this->checkExistEmail($email);

    if ($user_id == "" || $name == "" || $username == "" || $religion == "" || $birthdate == "" || $age == "" || $university == "" || $faculty == "" || $branch == "" || $year == "" || $email == "" || $address == "" || $guardian_name == "" || $guardian_mobile == ""  || $mobile == ""  || $room_number == "" || $room_status == "" || $password == "") {
      $msg = "
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Please, User Registration field must not be Empty!'
          });
      </script>";
      if (strlen($username) < 3) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "ชื่อผู้ใช้สั้นเกินไป ต้องมีอย่างน้อย 3 ตัวอักษร!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      } elseif (filter_var($mobile, FILTER_SANITIZE_NUMBER_INT) == FALSE) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "กรุณากรอกหมายเลขโทรศัพท์เป็นตัวเลขเท่านั้น!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      } elseif (strlen($password) < 5) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      } elseif (!preg_match("#[0-9]+#", $password)) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "รหัสผ่านต้องมีอย่างน้อย 1 ตัวเลข!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      } elseif (!preg_match("#[a-z]+#", $password)) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "รหัสผ่านต้องมีอย่างน้อย 1 ตัวอักษร!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "ที่อยู่อีเมลไม่ถูกต้อง!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      } elseif ($checkEmail == TRUE) {
        $msg = '<script>
            Swal.fire({
                title: "เกิดข้อผิดพลาด!",
                text: "อีเมลนี้มีอยู่แล้ว กรุณาลองใช้อีเมลอื่น!",
                icon: "error",
                confirmButtonText: "ตกลง"
            });
        </script>';
        return $msg;
      }
    } else {
      // Image validation
      if (isset($_FILES["fileToUpload"])) {
          $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
          if ($check === false) {
              $_SESSION['error'] = 'ไฟล์ที่อัพโหลดไม่ใช่รูปภาพ';
              header("location: register.php");
              exit();
          }
          
          // Check file size (5MB maximum)
          if ($_FILES["fileToUpload"]["size"] > 5000000) {
              $_SESSION['error'] = 'ขนาดไฟล์เกินขีดจำกัด (5MB)';
              header("location: register.php");
              exit();
          }

          // Allow certain file formats
          $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
          if (!in_array($imageFileType, $allowedTypes)) {
              $_SESSION['error'] = 'ขออภัย, เพียงแค่ไฟล์รูปภาพ JPG, JPEG, PNG & GIF เท่านั้นที่สามารถอัพโหลดได้';
              header("location: register.php");
              exit();
          }

          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
              $_SESSION['error'] = 'ขออภัย, ไม่สามารถอัพโหลดไฟล์ของคุณได้';
              header("location: register.php");
              exit();
          } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              } else {
                  $_SESSION['error'] = 'ขออภัย, เกิดข้อผิดพลาดในการอัพโหลดไฟล์ของคุณ';
                  header("location: register.php");
                  exit();
              }
          }
      }


      $sql = "INSERT INTO tbl_users(img_profile,user_id, name, username, religion, birthdate, age, university, faculty, branch, year, email, password, mobile, address, guardian_name, guardian_mobile, room_number, room_status, roleid) 
      VALUES(:img_profile,:user_id, :name, :username, :religion, :birthdate, :age, :university, :faculty, :branch, :year, :email, :password, :mobile, :address, :guardian_name, :guardian_mobile, :room_number, :room_status, :roleid)";
      
      $stmt = $this->db->pdo->prepare($sql);
      
      // Bind values to each placeholder
      $stmt->bindParam(":img_profile", $_FILES["fileToUpload"]["name"] );
      $stmt->bindValue(':user_id', $user_id);  
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':religion', $religion); 
      $stmt->bindValue(':birthdate', $birthdate); 
      $stmt->bindValue(':age', $age); 
      $stmt->bindValue(':university', $university); 
      $stmt->bindValue(':faculty', $faculty); 
      $stmt->bindValue(':branch', $branch); 
      $stmt->bindValue(':year', $year); 
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':guardian_name', $guardian_name);
      $stmt->bindValue(':guardian_mobile', $guardian_mobile);
      $stmt->bindValue(':room_number', $room_number);
      $stmt->bindValue(':room_status', $room_status);
      $stmt->bindValue(':password', SHA1($password)); 
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      
      $result = $stmt->execute();
      
      

if ($result) {
  $msg = '<script>
      Swal.fire({
          title: "สำเร็จ!",
          text: "ว้าว, คุณได้ลงทะเบียนสำเร็จแล้ว!",
          icon: "success",
          confirmButtonText: "ตกลง"
      });
  </script>';
  return $msg;
} else {
  $msg = '<script>
      Swal.fire({
          title: "เกิดข้อผิดพลาด!",
          text: "บางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง!",
          icon: "error",
          confirmButtonText: "ตกลง"
      });
  </script>';
  return $msg;
}


    }
  }

  // เพิ่มผู้ใช้ใหม่โดยผู้ดูแลระบบ
  public function addNewUserByAdmin($data)
  {
    $user_id = $data['user_id'];
    $name = $data['name'];
    $username = $data['username'];
    $religion = $data['religion'];
    $birthdate = $data['birthdate'];
    $age = $data['age'];
    $university = isset($data['university']) ? $data['university'] : null;
    $faculty = isset($data['faculty']) ? $data['faculty'] : null;
    $branch = isset($data['branch']) ? $data['branch'] : null;
    $year = isset($data['year']) ? $data['year'] : null;
    $email = $data['email'];
    $mobile = $data['mobile'];
    $address = $data['address'];
    $guardian_name = $data['guardian_name'];
    $guardian_mobile = $data['guardian_mobile'];
    $room_number = $data['room_number'];
    $room_status = isset($data['room_status']) ? $data['room_status'] : null;
    $roleid = $data['roleid'];
    $password = $data['password'];

    // Image upload variables
    $target_dir = "assets/images/upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $checkEmail = $this->checkExistEmail($email);

    if ($user_id == "" || $name == "" || $username == "" || $religion == "" || $birthdate == "" || $age == "" || $university == "" || $faculty == "" || $branch == "" || $year == "" || $email == "" || $address == "" || $guardian_name == "" || $guardian_mobile == ""  || $mobile == ""  || $room_number == "" || $room_status == "" || $password == "") {
      $msg = '
      <script>
        Swal.fire({
          icon: "error",
          title: "เกิดข้อผิดพลาด!",
          text: "ฟิลด์ข้อมูลไม่สามารถเว้นว่างได้!",
          confirmButtonText: "ตกลง"
        });
      </script>
      ';
      echo $msg;
      if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'ช่องข้อมูลต้องไม่เป็นค่าว่าง!'
  });
  </script>";
        return $msg;
      } elseif (strlen($username) < 3) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'ชื่อผู้ใช้สั้นเกินไป ต้องมีอย่างน้อย 3 ตัวอักษร!'
  });
  </script>";
        return $msg;
      } elseif (filter_var($mobile, FILTER_SANITIZE_NUMBER_INT) == FALSE) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'กรุณากรอกหมายเลขโทรศัพท์เป็นตัวเลขเท่านั้น!'
  });
  </script>";
        return $msg;
      } elseif (strlen($password) < 5) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร!'
  });
  </script>";
        return $msg;
      } elseif (!preg_match('#[0-9]+#', $password)) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'รหัสผ่านต้องมีอย่างน้อย 1 ตัวเลข!'
  });
  </script>";
        return $msg;
      } elseif (!preg_match('#[a-z]+#', $password)) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'รหัสผ่านต้องมีอย่างน้อย 1 ตัวอักษรภาษาอังกฤษ!'
  });
  </script>";
        return $msg;
      } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'อีเมลไม่ถูกต้อง!'
  });
  </script>";
        return $msg;
      } elseif ($checkEmail == TRUE) {
        $msg = "<script>
  Swal.fire({
      icon: 'error',
      title: 'ข้อผิดพลาด!',
      text: 'อีเมลนี้มีอยู่แล้ว กรุณาลองใช้อีเมลอื่น!'
  });
  </script>";
        return $msg;
      }
    } else {
      // Image validation
      if (isset($_FILES["fileToUpload"])) {
          $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
          if ($check === false) {
              $_SESSION['error'] = 'ไฟล์ที่อัพโหลดไม่ใช่รูปภาพ';
              header("location: register.php");
              exit();
          }
          
          // Check file size (5MB maximum)
          if ($_FILES["fileToUpload"]["size"] > 5000000) {
              $_SESSION['error'] = 'ขนาดไฟล์เกินขีดจำกัด (5MB)';
              header("location: register.php");
              exit();
          }

          // Allow certain file formats
          $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
          if (!in_array($imageFileType, $allowedTypes)) {
              $_SESSION['error'] = 'ขออภัย, เพียงแค่ไฟล์รูปภาพ JPG, JPEG, PNG & GIF เท่านั้นที่สามารถอัพโหลดได้';
              header("location: register.php");
              exit();
          }

          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
              $_SESSION['error'] = 'ขออภัย, ไม่สามารถอัพโหลดไฟล์ของคุณได้';
              header("location: register.php");
              exit();
          } else {
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              } else {
                  $_SESSION['error'] = 'ขออภัย, เกิดข้อผิดพลาดในการอัพโหลดไฟล์ของคุณ';
                  header("location: register.php");
                  exit();
              }
          }
      }


      $sql = "INSERT INTO tbl_users(img_profile,user_id, name, username, religion, birthdate, age, university, faculty, branch, year, email, password, mobile, address, guardian_name, guardian_mobile, room_number, room_status, roleid) 
      VALUES(:img_profile,:user_id, :name, :username, :religion, :birthdate, :age, :university, :faculty, :branch, :year, :email, :password, :mobile, :address, :guardian_name, :guardian_mobile, :room_number, :room_status, :roleid)";
      
      $stmt = $this->db->pdo->prepare($sql);
      
      // Bind values to each placeholder
      $stmt->bindParam(":img_profile", $_FILES["fileToUpload"]["name"] );
      $stmt->bindValue(':user_id', $user_id);  
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':religion', $religion); 
      $stmt->bindValue(':birthdate', $birthdate); 
      $stmt->bindValue(':age', $age); 
      $stmt->bindValue(':university', $university); 
      $stmt->bindValue(':faculty', $faculty); 
      $stmt->bindValue(':branch', $branch); 
      $stmt->bindValue(':year', $year); 
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':guardian_name', $guardian_name);
      $stmt->bindValue(':guardian_mobile', $guardian_mobile);
      $stmt->bindValue(':room_number', $room_number);
      $stmt->bindValue(':room_status', $room_status);
      $stmt->bindValue(':password', SHA1($password)); 
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      
      $result = $stmt->execute();
      
      $result = $stmt->execute();
      if ($result) {
        // ถ้าการลงทะเบียนสำเร็จ
        $msg = "<script>
Swal.fire({
    icon: 'success',
    title: 'สำเร็จ!',
    text: 'เยี่ยมมาก, คุณลงทะเบียนสำเร็จแล้ว!'
});
</script>";
        return $msg;

        // ถ้ามีข้อผิดพลาด
        $msg = "<script>
Swal.fire({
    icon: 'error',
    title: 'ข้อผิดพลาด!',
    text: 'เกิดข้อผิดพลาดบางประการ กรุณาลองใหม่!'
});
</script>";
        return $msg;
      }
    }
  }
  // เพิ่มผู้ใช้ใหม่โดยผู้ดูแลระบบ

  // Select All User Method
  public function selectAllUserData()
  {
    $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // User login Autho Method
  public function userLoginAutho($email, $password)
  {
    $password = SHA1($password);
    $sql = "SELECT * FROM tbl_users WHERE email = :email and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  // Check User Account Satatus
  public function CheckActiveUser($email)
  {
    $sql = "SELECT * FROM tbl_users WHERE email = :email and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }




  // User Login Authotication Method
  public function userLoginAuthotication($data)
  {
    $email = $data['email'];
    $password = $data['password'];


    $checkEmail = $this->checkExistEmail($email);

    if ($email == "" || $password == "") {
      // ถ้าอีเมลหรือรหัสผ่านว่าง
      $msg = "<script>
Swal.fire({
    icon: 'error',
    title: 'ข้อผิดพลาด!',
    text: 'อีเมลหรือรหัสผ่านห้ามว่าง!'
});
</script>";
      return $msg;

      // ถ้าอีเมลไม่ถูกต้อง
      $msg = "<script>
Swal.fire({
    icon: 'error',
    title: 'ข้อผิดพลาด!',
    text: 'อีเมลไม่ถูกต้อง!'
});
</script>";
      return $msg;

      // ถ้าอีเมลไม่พบ
      $msg = "<script>
Swal.fire({
    icon: 'error',
    title: 'ข้อผิดพลาด!',
    text: 'ไม่พบอีเมลนี้, กรุณาลงทะเบียนใหม่หรือใช้รหัสผ่านที่ถูกต้อง!'
});
</script>";
      return $msg;
    } else {


      $logResult = $this->userLoginAutho($email, $password);
      $chkActive = $this->CheckActiveUser($email);

      if ($chkActive == TRUE) {
        $msg = '
        <script>
          Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาด!",
            text: "ขออภัย, บัญชีของคุณถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ!",
            confirmButtonText: "ตกลง"
          });
        </script>
        ';
        echo $msg;
        return $msg;
      } elseif ($logResult) {

        Session::init();
        Session::set('login', TRUE);
        Session::set('id', $logResult->id);
        Session::set('roleid', $logResult->roleid);
        Session::set('name', $logResult->name);
        Session::set('email', $logResult->email);
        Session::set('username', $logResult->username);
        Session::set('logMsg', '
        <script>
          Swal.fire({
            icon: "success",
            title: "สำเร็จ!",
            text: "คุณได้เข้าสู่ระบบสำเร็จ!",
            confirmButtonText: "ตกลง"
          }).then(function() {
            window.location.href = "index.php";
          });
        </script>
        ');
        echo "<script>location.href='index.php';</script>";
      } else {
        $msg = '
        <script>
          Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาด!",
            text: "อีเมลหรือรหัสผ่านไม่ตรงกัน!",
            confirmButtonText: "ตกลง"
          });
        </script>
        ';
        return $msg;
      }
    }
  }



  // Get Single User Information By Id Method
  public function getUserInfoById($userid)
  {
    $sql = "SELECT * FROM tbl_users WHERE id = :id LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $userid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result;
    } else {
      return false;
    }
  }



  //
  // รับข้อมูลผู้ใช้คนเดียวโดยวิธีอัปเดต
  public function updateUserByIdInfo($userid, $data)
  {
    $user_id = $data['user_id'];
    $name = $data['name'];
    $username = $data['username'];
    $religion = $data['religion'];
    $birthdate = $data['birthdate'];
    $age = $data['age'];
    $university = isset($data['university']) ? $data['university'] : null;
    $faculty = isset($data['faculty']) ? $data['faculty'] : null;
    $branch = isset($data['branch']) ? $data['branch'] : null;
    $year = isset($data['year']) ? $data['year'] : null;
    $email = $data['email'];
    $mobile = $data['mobile'];
    $address = $data['address'];
    $guardian_name = $data['guardian_name'];
    $guardian_mobile = $data['guardian_mobile'];
    $room_number = $data['room_number'];
    $room_status = isset($data['room_status']) ? $data['room_status'] : null;
    $roleid = $data['roleid'];

    $target_dir = "assets/images/upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $checkEmail = $this->checkExistEmail($email);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $religion == "" || $birthdate == "" || $age == "" || 
    $university == "" || $faculty == "" || $branch == "" || $year == "" || $address == "" || $guardian_name == "" || 
    $guardian_mobile == "" || $room_number == "" || $roleid == "") {
      echo "<script>
          Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด!',
              text: 'กรุณากรอกข้อมูลให้ครบทุกช่อง',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return;
  } elseif (strlen($username) < 3) {
      echo "<script>
          Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด!',
              text: 'ชื่อผู้ใช้งานต้องมีความยาวอย่างน้อย 3 ตัวอักษร',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return;
  } elseif (filter_var($mobile, FILTER_SANITIZE_NUMBER_INT) === false) {
      echo "<script>
          Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด!',
              text: 'กรุณากรอกเบอร์โทรศัพท์เป็นตัวเลขเท่านั้น',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return;
  } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      echo "<script>
          Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด!',
              text: 'ที่อยู่อีเมลไม่ถูกต้อง',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return;
  } else {
          // Image validation
          if (isset($_FILES["fileToUpload"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check === false) {
                $_SESSION['error'] = 'ไฟล์ที่อัพโหลดไม่ใช่รูปภาพ';
                header("location: profile.php");
                exit();
            }
            
            // Check file size (5MB maximum)
            if ($_FILES["fileToUpload"]["size"] > 50000000) {
                $_SESSION['error'] = 'ขนาดไฟล์เกินขีดจำกัด (10MB)';
                header("location: profile.php");
                exit();
            }
  
            // Allow certain file formats
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $_SESSION['error'] = 'ขออภัย, เพียงแค่ไฟล์รูปภาพ JPG, JPEG, PNG & GIF เท่านั้นที่สามารถอัพโหลดได้';
                header("location: profile.php");
                exit();
            }
  
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['error'] = 'ขออภัย, ไม่สามารถอัพโหลดไฟล์ของคุณได้';
                header("location: profile.php");
                exit();
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                } else {
                    $_SESSION['error'] = 'ขออภัย, เกิดข้อผิดพลาดในการอัพโหลดไฟล์ของคุณ';
                    header("location: profile.php");
                    exit();
                }
            }
        }

    $sql = "UPDATE tbl_users SET
    img_profile = :img_profile,
    user_id = :user_id,
    name = :name,
    username = :username,
    religion = :religion,
    birthdate = :birthdate,
    age = :age,
    university = :university,
    faculty = :faculty,
    branch = :branch,
    year = :year,
    email = :email,
    mobile = :mobile,
    address = :address,
    guardian_name = :guardian_name,
    guardian_mobile = :guardian_mobile,
    room_number = :room_number,
    room_status = :room_status,
    roleid = :roleid
WHERE id = :id";

$stmt = $this->db->pdo->prepare($sql);
$stmt->bindParam(":img_profile", $_FILES["fileToUpload"]["name"] );
$stmt->bindValue(':user_id', $user_id);
$stmt->bindValue(':name', $name);
$stmt->bindValue(':username', $username);
$stmt->bindValue(':religion', $religion);
$stmt->bindValue(':birthdate', $birthdate);
$stmt->bindValue(':age', $age);
$stmt->bindValue(':university', $university);
$stmt->bindValue(':faculty', $faculty);
$stmt->bindValue(':branch', $branch);
$stmt->bindValue(':year', $year);
$stmt->bindValue(':email', $email);
$stmt->bindValue(':mobile', $mobile);
$stmt->bindValue(':address', $address);
$stmt->bindValue(':guardian_name', $guardian_name);  // Corrected line
$stmt->bindValue(':guardian_mobile', $guardian_mobile);
$stmt->bindValue(':room_number', $room_number);
$stmt->bindValue(':room_status', $room_status);
$stmt->bindValue(':roleid', $roleid);
$stmt->bindValue(':id', $userid);

$result = $stmt->execute();


      if ($result) {
        Session::set('msg', '
        <script>
          Swal.fire({
            icon: "success",
            title: "สำเร็จ!",
            text: "ข้อมูลของคุณได้รับการอัปเดตสำเร็จ!",
            confirmButtonText: "ตกลง"
          }).then(function() {
            window.location.href = "index.php";
          });
        </script>
        ');
        echo "<script>location.href='index.php';</script>";
      } else {
        echo "<script>location.href='index.php';</script>";

        // กรณีข้อมูลไม่ถูกอัปเดต
        echo "<script>location.href='index.php';</script>";
        Session::set('msg', '
        <script>
          Swal.fire({
            icon: "error",
            title: "เกิดข้อผิดพลาด!",
            text: "ไม่สามารถแทรกข้อมูลได้!",
            confirmButtonText: "ตกลง"
          });
        </script>
        ');
      }
    }
  }

  // ลบผู้ใช้ด้วยวิธี Id //
  public function deleteUserById($remove)
  {
    $sql = "DELETE FROM tbl_users WHERE id = :id ";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $remove);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<script>
      Swal.fire({
          title: "สำเร็จ!",
          text: "บัญชีผู้ใช้ถูกลบเรียบร้อยแล้ว!",
          icon: "success",
          confirmButtonText: "ตกลง"
      }).then(() => {
          // สามารถใส่การเปลี่ยนเส้นทางหรือการกระทำอื่นๆ ที่ต้องการหลังจากแสดง SweetAlert
          window.location.href = "index.php"; // เปลี่ยนเส้นทางไปหน้า index.php
      });
  </script>';
      return $msg;
    } else {
      $msg = '<script>
      Swal.fire({
          title: "เกิดข้อผิดพลาด!",
          text: "ไม่สามารถลบข้อมูลได้!",
          icon: "error",
          confirmButtonText: "ตกลง"
      }).then(() => {
          // สามารถใส่การเปลี่ยนเส้นทางหรือการกระทำอื่นๆ ที่ต้องการหลังจากแสดง SweetAlert
          window.location.href = "index.php"; // เปลี่ยนเส้นทางไปหน้า index.php
      });
  </script>';
      return $msg;
    }
  }
  // ลบผู้ใช้ด้วยวิธี Id //ฃ

  // User Deactivated By Admin
  public function userDeactiveByAdmin($deactive)
  {
    $sql = "UPDATE tbl_users SET

       isActive=:isActive
       WHERE id = :id";

    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':isActive', 1);
    $stmt->bindValue(':id', $deactive);
    $result =   $stmt->execute();
if ($result) {
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'บัญชีผู้ใช้ถูกยกเลิกการใช้งานสำเร็จ !',
                confirmButtonText: 'ตกลง'
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>สำเร็จ !</strong> บัญชีผู้ใช้ถูกยกเลิกการใช้งานสำเร็จ !</div>');
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด!',
                text: 'ข้อมูลไม่สามารถยกเลิกการใช้งานได้ !',
                confirmButtonText: 'ตกลง'
            }).then(function() {
                window.location.href = 'index.php';
            });
          </script>";
    Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>ข้อผิดพลาด !</strong> ข้อมูลไม่สามารถยกเลิกการใช้งานได้ !</div>');
    return $msg;
}

  }


  // User Deactivated By Admin
  public function userActiveByAdmin($active)
  {
    $sql = "UPDATE tbl_users SET
       isActive=:isActive
       WHERE id = :id";

    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':isActive', 0);
    $stmt->bindValue(':id', $active);
    $result =   $stmt->execute();
    if ($result) {
      echo "<script>
              Swal.fire({
                  icon: 'success',
                  title: 'สำเร็จ!',
                  text: 'การเปิดใช้งานบัญชีผู้ใช้สำเร็จ !',
                  confirmButtonText: 'ตกลง'
              }).then(function() {
                  window.location.href = 'index.php';
              });
            </script>";
  } else {
      echo "<script>
              Swal.fire({
                  icon: 'error',
                  title: 'ข้อผิดพลาด!',
                  text: 'ข้อมูลไม่สามารถเปิดใช้งานได้ !',
                  confirmButtonText: 'ตกลง'
              }).then(function() {
                  window.location.href = 'index.php';
              });
            </script>";
  }
  
  }




  // ตรวจสอบวิธีรหัสผ่านเก่า
  public function CheckOldPassword($userid, $old_pass)
  {
    $old_pass = SHA1($old_pass);
    $sql = "SELECT password FROM tbl_users WHERE password = :password AND id =:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':password', $old_pass);
    $stmt->bindValue(':id', $userid);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
  // ตรวจสอบวิธีรหัสผ่านเก่า

  // เปลี่ยน User pass By Id
  public  function changePasswordBysingelUserId($userid, $data)
  {

    $old_pass = $data['old_password'];
    $new_pass = $data['new_password'];

    if ($old_pass == "" || $new_pass == "") {
      $msg = "
      <script>
          Swal.fire({
              icon: 'error',
              title: 'ข้อผิดพลาด!',
              text: 'ช่องรหัสผ่านต้องไม่เว้นว่าง!',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return $msg;
    } elseif (strlen($new_pass) < 6) {
      $msg = "
      <script>
          Swal.fire({
              icon: 'error',
              title: 'ข้อผิดพลาด!',
              text: 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 6 ตัวอักษร!',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return $msg;
    }
    $oldPass = $this->CheckOldPassword($userid, $old_pass);
    if ($oldPass == FALSE) {
      $msg = "
      <script>
          Swal.fire({
              icon: 'error',
              title: 'ข้อผิดพลาด!',
              text: 'รหัสผ่านเดิมไม่ตรงกัน!',
              confirmButtonText: 'ตกลง'
          });
      </script>";
      return $msg;
    } else {
      $new_pass = SHA1($new_pass);
      $sql = "UPDATE tbl_users SET

            password=:password
            WHERE id = :id";

      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $new_pass);
      $stmt->bindValue(':id', $userid);
      $result =   $stmt->execute();

      if ($result) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'รหัสผ่านถูกเปลี่ยนแปลงเรียบร้อยแล้ว!',
                confirmButtonText: 'ตกลง'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
        </script>";
      } else {
        $msg = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด!',
                text: 'รหัสผ่านไม่ได้รับการเปลี่ยนแปลง!'
            });
        </script>";
        return $msg;
      }
    }
  }
}
  //เปลี่ยน User pass By Id