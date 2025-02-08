<?php
include 'inc/header.php';
Session::CheckSession();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
  $register = $users->userRegistration($_POST);
}
  if (isset($register)) {
  echo $register;
}
 ?>


<div class="card ">
  <form class="" action="" method="post" method="POST" enctype="multipart/form-data">
    <div class="card-header">
      <h3 class='text-center'>สมัครสมาชิกหอพักนักศึกษาหญิง</h3>
    </div>
    <div class="cad-body">
      <div style="width:800px; margin:0px auto">
        <br>
        <div class="form-group">
          <center>
            <label for="imageUpload">รูปนักศึกษาของคุณ</label>
            <img id="imagePreview" src="" alt="Image Preview"
              style="width: 300px; height: 300px; object-fit: cover; border-radius: 10px; display: none;">
          </center>
        </div>
        <div class="form-group">
          <label for="imageUpload" class="btn btn-primary"
            style="display: inline-block; margin-right: 10px;">อัปโหลดรูปภาพของคุณ</label>
          <input type="file" name="fileToUpload" class="form-control" accept="image/*" id="imageUpload"
            style="display: none;" onchange="displayImage(event)">
          <p id="fileName" style="display: inline-block; margin-top: 10px; color: #555;">ยังไม่ได้เลือกไฟล์</p>
        </div>

        <script>
        function displayImage(event) {
          var fileName = event.target.files[0].name;
          document.getElementById("fileName").innerText = fileName;

          var reader = new FileReader();
          reader.onload = function(e) {
            var img = document.getElementById("imagePreview");
            img.src = e.target.result;
            img.style.display = 'block'; // แสดงภาพ
          };
          reader.readAsDataURL(event.target.files[0]);
        }
        </script>
        <!--  -->
        <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; margin: 0 auto;">
          <div class="form-group" style="width: 48%;">
            <label for="user_id">รหัสนักศึกษาของคุณ</label>
            <input type="text" id="user_id" name="user_id" class="form-control" maxlength="6" pattern="\d{1,6}"
              title="กรุณาใส่ตัวเลขเท่านั้น และต้องไม่เกิน 6 หลัก" required>
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
          <div class="form-group" style="width: 48%;">
            <label for="name">ชื่อจริง-นามสกุลของคุณ</label>
            <input type="text" name="name" class="form-control">
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; margin: 0 auto;">
          <div class="form-group" style="width: 48%;">
            <label for="username">ชื่อเล่นของคุณ</label>
            <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group" style="width: 48%;">
            <label for="religion">ศาสนาของคุณ</label>
            <select name="religion" id="religion" class="form-control">
              <option value="พุทธ">พุทธ</option>
              <option value="คริส">คริส</option>
              <option value="อิสลาม">อิสลาม</option>
            </select>
          </div>
        </div>
        <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; margin: 0 auto;">
          <div class="form-group" style="width: 48%;">
            <label for="birthdate">วันเกิดของคุณ</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control">
          </div>

          <div class="form-group" style="width: 48%;">
            <label for="age">อายุของคุณ</label>
            <input type="text" name="age" id="age" class="form-control" required oninput="validateAge()">
          </div>
        </div>
        <script>
        function validateAge() {
          const ageInput = document.getElementById('age');

          // ลบตัวอักษรที่ไม่ใช่ตัวเลข
          ageInput.value = ageInput.value.replace(/[^0-9]/g, '');

          // ตรวจสอบให้อายุอยู่ระหว่าง 1 ถึง 99
          if (ageInput.value !== '' && (ageInput.value < 1 || ageInput.value > 99)) {
            alert('กรุณากรอกอายุระหว่าง 1 ถึง 99');
            ageInput.value = '';
          }
        }
        </script>

        <div class="form-group">
          <label for="university">เลือกมหาวิทยาลัย</label>
          <select id="university" name="university" class="form-control" onchange="updateDropdowns()">
            <option value="">เลือกมหาวิทยาลัย</option>
            <option value="มหาวิทยาลัยเจ้าพระยา">มหาวิทยาลัยเจ้าพระยา</option>
            <option value="อาชีวศึกษาวิริยาลัยนครสวรรค์">วิทยาลัยอาชีวศึกษาวิริยาลัยนครสวรรค์</option>
          </select>
        </div>
        <div style="width: 800px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
          <div class="form-group" style="width: 32%; margin-right: 2%;">
            <label for="faculty">คณะ</label>
            <select id="faculty" name="faculty" class="form-control" onchange="updateBranch()">
              <option value="">เลือกคณะ</option>
            </select>
          </div>
          <div class="form-group" style="width: 32%; margin-right: 2%;">
            <label for="branch">สาขา</label>
            <select id="branch" name="branch" class="form-control">
              <option value="">เลือกสาขา</option>
            </select>
          </div>
          <div class="form-group" style="width: 32%;">
            <label for="year">ชั้นปี</label>
            <select id="year" name="year" class="form-control">
              <option value="">เลือกชั้นปี</option>
            </select>
          </div>
        </div>
        <script>
        function updateDropdowns() {
          const university = document.getElementById("university").value;
          const facultyDropdown = document.getElementById("faculty");
          const branchDropdown = document.getElementById("branch");
          const yearDropdown = document.getElementById("year");
          if (university === "มหาวิทยาลัยเจ้าพระยา") {
            // Update Faculty Options for มหาวิทยาลัยเจ้าพระยา
            facultyDropdown.innerHTML = `
      <option value="บริหารและการจัดการ">บริหารและการจัดการ</option>
      <option value="มนุษยศาสตร์และสังคมศาสตร์">มนุษยศาสตร์และสังคมศาสตร์</option>
      <option value="วิทยาศาสตร์และเทคโนโลยี">วิทยาศาสตร์และเทคโนโลยี</option>
    `;
            // Update Year Options for มหาวิทยาลัยเจ้าพระยา
            yearDropdown.innerHTML = `
      <option value="ปีที่ 1">ปีที่ 1</option>
      <option value="ปีที่ 2">ปีที่ 2</option>
      <option value="ปีที่ 3">ปีที่ 3</option>
      <option value="ปีที่ 4">ปีที่ 4</option>
    `;
          } else if (university === "อาชีวศึกษาวิริยาลัยนครสวรรค์") {
            // Update Faculty Options for วิทยาลัยอาชีวศึกษาวิริยาลัยนครสวรรค์
            facultyDropdown.innerHTML = `
      <option value="ประกาศนียบัตรวิชาชีพ">ประกาศนียบัตรวิชาชีพ</option>
      <option value="ประกาศนียบัตรวิชาชีพชั้นสูง">ประกาศนียบัตรวิชาชีพชั้นสูง</option>
    `;
            // Clear Branch and Year options
            branchDropdown.innerHTML = `<option value="">สาขา</option>`;
            yearDropdown.innerHTML = `<option value="">ชั้นปี</option>`;
          } else {
            // Reset all dropdowns if no university selected
            facultyDropdown.innerHTML = `<option value="">เลือกคณะ</option>`;
            branchDropdown.innerHTML = `<option value="">เลือกสาขา</option>`;
            yearDropdown.innerHTML = `<option value="">เลือกชั้นปี</option>`;
          }
        }

        function updateBranch() {
          const faculty = document.getElementById("faculty").value;
          const branchDropdown = document.getElementById("branch");
          const yearDropdown = document.getElementById("year");
          // Update Branch and Year based on Faculty selection
          if (faculty === "บริหารและการจัดการ") {
            branchDropdown.innerHTML = `
      <option value="สาขาวิชาการจัดการ">สาขาวิชาการจัดการ</option>
      <option value="สาขาวิชาการบัญชี">สาขาวิชาการบัญชี</option>
      <option value="สาขาวิชาคอมพิวเตอร์ธุรกิจ">สาขาวิชาคอมพิวเตอร์ธุรกิจ</option>
      <option value="สาขาวิชาการจัดการโรงแรมและการท่องเที่ยว">สาขาวิชาการจัดการโรงแรมและการท่องเที่ยว</option>
    `;
          } else if (faculty === "วิทยาศาสตร์และเทคโนโลยี") {
            branchDropdown.innerHTML = `
      <option value="สาขาวิชาวิทยาการคอมพิวเตอร์">สาขาวิชาวิทยาการคอมพิวเตอร์</option>
      <option value="สาขาวิชาคอมพิวเตอร์มัลติมีเดียและแอนิเมชั่น">สาขาวิชาคอมพิวเตอร์มัลติมีเดียและแอนิเมชั่น</option>
    `;
          } else if (faculty === "มนุษยศาสตร์และสังคมศาสตร์") {
            branchDropdown.innerHTML = `
      <option value="สาขาวิชานิติศาสตร์">สาขาวิชานิติศาสตร์</option>
      <option value="สาขาวิชารัฐประศาสนศาสตร์">สาขาวิชารัฐประศาสนศาสตร์</option>
    `;
          } else if (faculty === "ประกาศนียบัตรวิชาชีพ") {
            branchDropdown.innerHTML = `
      <option value="สาขาวิชาการบัญชี">สาขาวิชาการบัญชี</option>
      <option value="สาขาวิชาการตลาด">สาขาวิชาการตลาด</option>
      <option value="สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล">สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล</option>
    `;
            yearDropdown.innerHTML = `
      <option value="ปวช 1">ปวช 1</option>
      <option value="ปวช 2">ปวช 2</option>
      <option value="ปวช 3">ปวช 3</option>
    `;
          } else if (faculty === "ประกาศนียบัตรวิชาชีพชั้นสูง") {
            branchDropdown.innerHTML = `
      <option value="สาขาวิชาการบัญชี">สาขาวิชาการบัญชี</option>
      <option value="สาขาวิชาการตลาด">สาขาวิชาการตลาด</option>
      <option value="สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล">สาขาวิชาเทคโนโลยีธุรกิจดิจิทัล</option>
      <option value="สาขาวิชาการจัดการธุรกิจ">สาขาวิชาการจัดการธุรกิจ</option>
      <option value="สาขาวิชาการจัดการธุรกิจค้าปลีกสมัยใหม่">สาขาวิชาการจัดการธุรกิจค้าปลีกสมัยใหม่</option>
    `;
            yearDropdown.innerHTML = `
      <option value="ปวส 1">ปวส 1</option>
      <option value="ปวส 2">ปวส 2</option>
    `;
          } else {
            branchDropdown.innerHTML = `<option value="">เลือกสาขา</option>`;
            yearDropdown.innerHTML = `<option value="">เลือกชั้นปี</option>`;
          }
        }
        </script>
        <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; margin: 0 auto;">
          <div class="form-group" style="width: 48%;">
            <label for="email">อีเมลของคุณ</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group" style="width: 48%;">
            <label for="mobile">เบอร์โทรศัพท์ของคุณ</label>
            <input type="text" id="mobile" name="mobile" class="form-control" oninput="validateMobile()">
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
          <textarea name="address" class="form-control" rows="3"></textarea>
        </div>
        <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; margin: 0 auto;">
          <div class="form-group" style="width: 48%;">
            <label for="guardian_name">ชื่อผู้ปกครอง</label>
            <input type="text" name="guardian_name" class="form-control">
          </div>
          <div class="form-group" style="width: 48%;">
            <label for="guardian_mobile">เบอร์โทรศัพท์ผู้ปกครอง</label>
            <input type="text" id="guardian_mobile" name="guardian_mobile" class="form-control"
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
        <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; margin: 0 auto;">
          <div class="form-group" style="width: 48%;">
            <label for="room_number">หมายเลขห้อง</label>
            <input type="text" name="room_number" class="form-control" id="room_number" maxlength="3" required
              oninput="this.value = this.value.replace(/[^0-9]/g, '')">
          </div>
          <div class="form-group" style="width: 48%;">
            <label for="room_status">สถานะห้อง</label>
            <select name="room_status" id="room_status" class="form-control">
              <option value="อยู่คนเดียว">อยู่คนเดียว</option>
              <option value="อยู่กับเพื่อน">อยู่กับเพื่อน</option>
            </select>
          </div>
        </div>
        <script>
        document.getElementById('room_number').addEventListener('input', function() {
          // ลบอักษรและตัวอักขระที่ไม่ใช่ตัวเลข
          this.value = this.value.replace(/[^0-9]/g, '');
        });
        </script>
        <div class="form-group">
          <label for="password">รหัสผ่าน</label>
          <input type="password" name="password" class="form-control">
          <input type="hidden" name="roleid" value="3" class="form-control">
        </div>
        <br>
        <div class="form-group">
          <center>
            <button type="submit" name="register" class="btn btn-primary">สมัครสมาชิก</button>
          </center>
        </div>

      </div>
    </div>
    <br><br>
</div>
</form>

  <?php
  include 'inc/footer.php';

  ?>
