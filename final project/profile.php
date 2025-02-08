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
?><div class="card-body">
  <?php
$getUinfo = $users->getUserInfoById($userid);
if ($getUinfo) {
?>
  <div class="card ">
    <div class="card-header">
      <center>
        <h3>แก้ใขข้อมูลส่วนตัว<span class="text-center"></h3>
      </center>
    </div>
    <div class="card-body">
      <div style="width:800px; margin:0px auto">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-group" method="POST">
            <center>
              <label for="imageUpload">รูปนักศึกษาของคุณ</label>
              <img id="imagePreview" src="" alt="Image Preview"
                style="width: 300px; height: 300px; object-fit: cover; border-radius: 10px; display: none;">
            </center>
          </div>

          <center>
            <div class="form-group">
              <label for="imageUpload" class="btn btn-primary"
                style="display: inline-block; margin-right: 10px;">อัปโหลดรูปภาพของคุณ</label>
              <input type="file" name="fileToUpload" class="form-control" accept="image/*" id="imageUpload"
                style="display: none;" onchange="displayImage(event)">
              <p id="fileName" style="display: inline-block; margin-top: 10px; color: #555;">ยังไม่ได้เลือกไฟล์</p>
            </div>
          </center>

          <script>
          function displayImage(event) {
            var fileName = event.target.files[0].name;
            document.getElementById("fileName").innerText = fileName;

            var reader = new FileReader();
            reader.onload = function(e) {
              // ซ่อนรูปภาพเดิมถ้ามี
              var existingImage = document.getElementById("existingImage");
              var noImageText = document.getElementById("noImageText");
              if (existingImage) {
                existingImage.style.display = "none"; // ซ่อนภาพเก่า
              }
              if (noImageText) {
                noImageText.style.display = "none"; // ซ่อนข้อความ "ไม่มีรูปภาพ"
              }

              // แสดงภาพใหม่
              var img = document.getElementById("imagePreview");
              img.src = e.target.result;
              img.style.display = 'block'; // แสดงภาพ
            };
            reader.readAsDataURL(event.target.files[0]);
          }
          </script>

          <div class="form-row">
            <div class="form-group" style="display: inline-block; width: 48%;">
              <label for="user_id">รหัสนักศึกษาของคุณ</label>
              <input type="text" id="user_id" name="user_id" value="<?php echo $getUinfo->user_id; ?>"
                class="form-control" maxlength="6" pattern="\d{1,6}"
                title="กรุณาใส่ตัวเลขเท่านั้น และต้องไม่เกิน 6 หลัก" required>
            </div>

            <div class="form-group" style="display: inline-block; width: 48%; margin-left: 4%;">
              <label for="name">ชื่อจริง + นามสกุลของคุณ</label>
              <input type="text" id="name" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control">
            </div>
          </div>

          <script>
          const input = document.getElementById('user_id');
          input.addEventListener('input', function(e) {
            // ลบตัวอักษรที่ไม่ใช่ตัวเลข
            this.value = this.value.replace(/[^0-9]/g, '');
            // จำกัดจำนวนตัวเลขไม่เกิน 6 หลัก
            if (this.value.length > 6) {
              this.value = this.value.slice(0, 6);
            }
          });
          </script>

          <div class="form-row">
            <div class="form-group" style="display: inline-block; width: 48%;">
              <label for="username">ชื่อเล่นของคุณ</label>
              <input type="text" name="username" id="username" value="<?php echo $getUinfo->username; ?>"
                class="form-control">
            </div>

            <div class="form-group" style="display: inline-block; width: 48%; margin-left: 4%;">
              <label for="religion">ศาสนาของคุณ</label>
              <select name="religion" id="religion" class="form-control">
                <option value="พุทธ" <?php echo ($getUinfo->religion == 'พุทธ') ? 'selected' : ''; ?>>พุทธ</option>
                <option value="คริส" <?php echo ($getUinfo->religion == 'คริส') ? 'selected' : ''; ?>>คริส</option>
                <option value="อิสลาม" <?php echo ($getUinfo->religion == 'อิสลาม') ? 'selected' : ''; ?>>อิสลาม
                </option>
              </select>
            </div>
          </div>


          <div class="form-row" style="display: flex; justify-content: space-between;">
            <div class="form-group" style="width: 48%;">
              <label for="birthdate">วันเกิดของคุณ</label>
              <input type="date" id="birthdate" name="birthdate" value="<?php echo $getUinfo->birthdate; ?>"
                class="form-control">
            </div>

            <div class="form-group" style="width: 48%;">
              <label for="age">อายุของคุณ</label>
              <input type="text" id="age" name="age" value="<?php echo $getUinfo->age; ?>" class="form-control"
                required>
            </div>
          </div>

          <script>
          document.getElementById("age").addEventListener("input", function() {
            const ageInput = document.getElementById("age");
            const age = ageInput.value;

            // ตรวจสอบว่าเป็นตัวเลขและอยู่ในช่วง 1-99
            if (isNaN(age) || age < 1 || age > 99) {
              alert("กรุณากรอกตัวเลขระหว่าง 1 ถึง 99 เท่านั้น!");
              ageInput.value = "";
            }
          });
          </script>

          <!-- University selection -->
          <div class="form-group">
            <label for="university">มหาลัยของคุณ</label>
            <select class="form-control" id="university" name="university" onchange="updateFacultyOptions()">
              <option value="มหาวิทยาลัยเจ้าพระยา"
                <?php echo ($getUinfo->university == 'มหาวิทยาลัยเจ้าพระยา') ? 'selected' : ''; ?>>มหาวิทยาลัยเจ้าพระยา
              </option>
              <option value="อาชีวศึกษาวิริยาลัยนครสวรรค์"
                <?php echo ($getUinfo->university == 'อาชีวศึกษาวิริยาลัยนครสวรรค์') ? 'selected' : ''; ?>>
                อาชีวศึกษาวิริยาลัยนครสวรรค์</option>
            </select>
          </div>
          <div style="width: 800px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
            <div class="form-group" style="width: 32%; margin-right: 2%;">
              <label for="faculty">คณะ</label>
              <select id="faculty" name="faculty" class="form-control" onchange="updateBranch()">
                <option value="">เลือกคณะ</option>
                <!-- ตัวเลือกจะถูกอัพเดทตามการเลือกมหาวิทยาลัย -->
              </select>
            </div>

            <div class="form-group" style="width: 32%; margin-right: 2%;">
              <label for="branch">สาขา</label>
              <select id="branch" name="branch" class="form-control">
                <option value="">เลือกสาขา</option>
                <!-- ตัวเลือกจะถูกอัพเดทตามการเลือกคณะ -->
              </select>
            </div>

            <div class="form-group" style="width: 32%;">
              <label for="year">ชั้นปี</label>
              <select id="year" name="year" class="form-control">
                <option value="">เลือกชั้นปี</option>
                <!-- ตัวเลือกจะถูกอัพเดทตามการเลือกสาขา -->
              </select>
            </div>
          </div>




          <script>
const faculties = {
  "มหาวิทยาลัยเจ้าพระยา": [{
      name: "บริหารและการจัดการ",
      branches: ["การจัดการ", "การบัญชี", "คอมพิวเตอร์ธุรกิจ", "การจัดการโรงแรมและการท่องเที่ยว",
        "การจัดการนวัตกรรมการค้า"
      ],
      years: ["ปีที่ 1", "ปีที่ 2", "ปีที่ 3"]
    },
    {
      name: "มนุษยศาสตร์และสังคมศาสตร์",
      branches: ["นิติศาสตร์", "รัฐประศาสนศาสตร์"],
      years: ["ปีที่ 1", "ปีที่ 2", "ปีที่ 3"]
    },
    {
      name: "วิทยาศาสตร์และเทคโนโลยี",
      branches: ["วิทยาการคอมพิวเตอร์", "คอมพิวเตอร์มัลติมีเดียและแอนิเมชั่น"],
      years: ["ปีที่ 1", "ปีที่ 2", "ปีที่ 3"]
    }
  ],
  "อาชีวศึกษาวิริยาลัยนครสวรรค์": [{
      name: "ประกาศนียบัตรวิชาชีพ",
      branches: ["การบัญชี", "การตลาด", "เทคโนโลยีธุรกิจดิจิทัล"],
      years: ["ปวช 1", "ปวช 2", "ปวช 3"]
    },
    {
      name: "ประกาศนียบัตรวิชาชีพชั้นสูง",
      branches: ["การบัญชี", "การตลาด", "เทคโนโลยีธุรกิจดิจิทัล", "การจัดการธุรกิจ",
        "การจัดการธุรกิจค้าปลีกสมัยใหม่"
      ],
      years: ["ปวส 1", "ปวส 2"]
    }
  ]
};

function updateFacultyOptions() {
  const university = document.getElementById("university").value;
  const facultySelect = document.getElementById("faculty");
  const branchSelect = document.getElementById("branch");
  const yearSelect = document.getElementById("year");

  facultySelect.innerHTML = "";
  branchSelect.innerHTML = "";
  yearSelect.innerHTML = "";

  if (faculties[university]) {
    faculties[university].forEach(faculty => {
      const option = document.createElement("option");
      option.value = faculty.name;
      option.text = faculty.name;
      facultySelect.appendChild(option);
    });
    updateBranchOptions();
  }
}

function updateBranchOptions() {
  const university = document.getElementById("university").value;
  const faculty = document.getElementById("faculty").value;
  const branchSelect = document.getElementById("branch");
  const yearSelect = document.getElementById("year");

  branchSelect.innerHTML = "";
  yearSelect.innerHTML = "";

  const selectedFaculty = faculties[university].find(f => f.name === faculty);

  if (selectedFaculty) {
    selectedFaculty.branches.forEach(branch => {
      const option = document.createElement("option");
      option.value = branch;
      option.text = branch;
      branchSelect.appendChild(option);
    });

    selectedFaculty.years.forEach(year => {
      const option = document.createElement("option");
      option.value = year;
      option.text = year;
      yearSelect.appendChild(option);
    });
  }
}

          </script>
          <div class="form-row" style="display: flex; justify-content: space-between;">
            <div class="form-group" style="width: 48%;">
              <label for="email">อีเมลของคุณ</label>
              <input type="email" id="email" name="email" value="<?php echo $getUinfo->email; ?>" class="form-control">
            </div>

            <div class="form-group" style="width: 48%;">
              <label for="mobile">เบอร์โทรศัพท์ของคุณ</label>
              <input type="text" id="mobile" name="mobile" value="<?php echo $getUinfo->mobile; ?>" class="form-control"
                oninput="validateMobile()">
            </div>

            <script>
            function validateMobile() {
              const input = document.getElementById('mobile');
              // จำกัดความยาวไม่เกิน 10 ตัวและให้มีแต่ตัวเลข
              input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
            }
            </script>

          </div>

          <div class="form-group">
            <label for="address">ที่อยู่ของคุณ</label>
            <textarea id="address" name="address" class="form-control"
              rows="3"><?php echo $getUinfo->address; ?></textarea>
          </div>
          <div class="form-row" style="display: flex; justify-content: space-between;">
            <div class="form-group" style="width: 48%;">
              <label for="guardian_name">ชื่อผู้ปกครอง</label>
              <input type="text" id="guardian_name" name="guardian_name" value="<?php echo $getUinfo->guardian_name; ?>"
                class="form-control">
            </div>

            <div class="form-group" style="width: 48%;">
              <label for="guardian_mobile">เบอร์โทรศัพท์ผู้ปกครอง</label>
              <input type="text" id="guardian_mobile" name="guardian_mobile"
                value="<?php echo $getUinfo->guardian_mobile; ?>" class="form-control"
                oninput="validateguardian_mobile()">
            </div>

            <script>
            function validateguardian_mobile() {
              const input = document.getElementById('guardian_mobile');
              // จำกัดความยาวไม่เกิน 10 ตัวและให้มีแต่ตัวเลข
              input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
            }
            </script>

          </div>

          <div class="form-row" style="display: flex; justify-content: space-between;">
            <div class="form-group" style="width: 48%;">
              <label for="room_number">หมายเลขห้อง</label>
              <input type="text" name="room_number" class="form-control" id="room_number"
                value="<?php echo $getUinfo->room_number; ?>" maxlength="3" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>


            <div class="form-group" style="width: 48%;">
              <label for="room_status">สถานะห้อง</label>
              <select name="room_status" id="room_status" class="form-control">
                <option value="อยู่คนเดียว" <?php echo ($getUinfo->room_status == 'อยู่คนเดียว') ? 'selected' : ''; ?>>
                  อยู่คนเดียว</option>
                <option value="อยู่กับเพื่อน"
                  <?php echo ($getUinfo->room_status == 'อยู่กับเพื่อน') ? 'selected' : ''; ?>>
                  อยู่กับเพื่อน</option>
              </select>
            </div>
          </div>

          <?php if (Session::get("roleid") == '1') { ?>
          <div class="form-group
              <?php if (Session::get("roleid") == '1' && Session::get("id") == $getUinfo->id) {
                echo "d-none";
              } ?>
              ">
            <div class="form-group">
              <label for="sel1">เลือกสถานะ</label>
              <select class="form-control" name="roleid" id="roleid">
                <?php
                if($getUinfo->roleid == '1'){?>
                <option value="1" selected='selected'>แอดมิน</option>
                <option value="2">ผู้แก้ใข</option>
                <option value="3">ผู้ใช้งาน</option>
                <?php }elseif($getUinfo->roleid == '2'){?>
                <option value="1">แอดมิน</option>
                <option value="2" selected='selected'>ผู้แก้ใข</option>
                <option value="3">ผู้ใช้งาน</option>
                <?php }elseif($getUinfo->roleid == '3'){?>
                <option value="1">แอดมิน</option>
                <option value="2">ผู้แก้ใข</option>
                <option value="3" selected='selected'>ผู้ใช้งาน</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php }else{?>
          <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
          <?php } ?>
          <?php if (Session::get("id") == $getUinfo->id) {?>
          <div class="form-group d-flex justify-content-between">
            <a class="btn btn-primary" href="index.php" style="margin-right: auto;">โอเค</a>
            <button type="submit" name="update" class="btn btn-success" style="margin: 0 auto;">อัปเดต</button>
            <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>"
              style="margin-left: auto;">เปลี่ยนรหัสผ่าน</a>
          </div>
          <?php } elseif(Session::get("roleid") == '1') {?>
          <div class="form-group d-flex justify-content-between">
            <a class="btn btn-primary" href="index.php" style="margin-right: auto;">โอเค</a>
            <button type="submit" name="update" class="btn btn-success" style="margin: 0 auto;">อัปเดต</button>
            <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>"
              style="margin-left: auto;">เปลี่ยนรหัสผ่าน</a>
          </div>
          <?php } elseif(Session::get("roleid") == '2') {?>
          <div class="form-group d-flex justify-content-between">
            <a class="btn btn-primary" href="index.php" style="margin-right: auto;">โอเค</a>
            <button type="submit" name="update" class="btn btn-success" style="margin: 0 auto;">อัปเดต</button>
            <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>"
              style="margin-left: auto;">เปลี่ยนรหัสผ่าน</a>
          </div>
          <div class="form-group">
            <button type="submit" name="update" class="btn btn-success" style="margin: 0 auto;">อัปเดต</button>
          </div>
          <?php   }else{ ?>
          <div class="form-group">
            <a class="btn btn-primary" href="index.php" style="margin-right: auto;">โอเค</a>
          </div>
          <?php } ?>

        </form>
      </div>
      <?php }else{
      header('Location:index.php');
  } ?>
    </div>
  </div>
</div>
<?php
  include 'inc/footer.php';
?>