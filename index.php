<?php 
    session_start();
    require_once "config.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="http://localhost/LNshop1/imgGI/logoMKZ.jpg"><!-- ใส่ icon ที่หัวเว็บไซต์ -->
    <!-- คำสั่งที่ทำให้ใช้งาน bootstrap ได้ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- คำสั่งที่ทำให้ใช้งาน modal ได้ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>LN Shop1</title>
    <style>
        .container{
            max-width: 1328px;
        }

        textarea:invalid { /* หากไม่ตรงตามเงื่อนไข minlenght และ required จะแสดงเส้นกรอบปะสีแดง */
            border: 2px dashed red;
        }

    </style>
</head>
<body>
    <!-- Add New User Modal Start -->
    <div>
        <div class="modal" id="addUsermodal" tabindex="-1" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >เพิ่มผู้ใช้ใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserfrm" action="insertUser.php" method="post" enctype="multipart/form-data" >
                            <div class="mb-3">
                                <label>E-mail: (ต้องระบุ) </label>
                                <input type="email" id="email" class="form-control form-control-lg" title="โปรดตรวจสอบความถูกต้องของ E-mail" placeholder="Enter E-mail" required>
                            </div>
                            <div class="mb-3">
                                <label>เลขประจำตัวประชาชน 13 หลัก: (ต้องระบุ) </label>
                                <input type="text" id="comp_userId" class="form-control form-control-lg" pattern="^[0-9,-]{13,}$" title="โปรดตรวจสอบความถูกต้องของหมายเลขประจำตัวประชาชน" placeholder="Enter CitizenID" maxlength="13" minlength="13" required>
                            </div>
                            <div class="mb-3">
                                <label>ชื่อ: (ต้องระบุ) </label>
                                <input type="text" id="comp_userFname" class="form-control form-control-lg" pattern="^[ก-๏a-zA-Z]{2,}$" title="โปรดตรวจสอบความถูกต้องของชื่อ" placeholder="Enter First Name" required>
                            </div>
                            <div class="mb-3">
                                <label>นามสกุล: (ต้องระบุ) </label>
                                <input type="text" id="comp_userLname" class="form-control form-control-lg" pattern="^[ก-๏a-zA-Z]{2,}$" title="โปรดตรวจสอบความถูกต้องของนามสกุล" placeholder="Enter Last Name" required>
                            </div>
                            <div class="mb-3">
                                <label>ที่อยู่: (ต้องระบุ) </label>
                                <textarea cols="10" rows="3" id="comp_userAddress" class="form-control" minlength="5" placeholder="Enter Address" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>วันเกิด: (ต้องระบุ) </label>
                                <input type="date" id="comp_userBirthdate">
                            </div>
                            <div class="mb-3">
                                <label>เพศ: (ต้องระบุ) </label>
                                <select name="sex" id="sex" required>
                                    <option value="Female">หญิง</option>
                                    <option value="Male">ชาย</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>หมายเลขมือถือ: </label>
                                <input type="text" id="comp_userPhone" class="form-control form-control-lg" pattern="^0([6|8|9])([0-9]){8}$" title="โปรดตรวจสอบรูปแบบของหมายเลขมือถือ" placeholder="Enter Mobile Phone" maxlength="10">
                            </div>
                            <div>
                                <label>รูปภาพ: </label>
                                <input type="file" id="comp_userImg" name="comp_userImg" class="form-control" accept="image/jpeg,image/jpg,image/png,image/gif">
                                <img width="100%" id="previewImg" alt="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-second" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" name="submit" id="submit" value="submit" class="btn btn-success" >ตกลง</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>   
    <!-- Add New User Modal End -->

    <!-- Edit User Modal start -->

    
    <!-- Edit User Modal End -->

    <div class="container mt-3  ">
        <div class="row mt-4">
            <div class="col-lg-12 ">
                <h1>Welcome to LN Shop1</h1>
            </div>
            <div class="col-md-6 d-flex justify-center-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addUsermodal">เพิ่มผู้ใช้ใหม่</button>
            </div>
        </div>
        <hr>
   <!--  -->
    </div>
</body>
<!-- ชุดคำสั่งสำหรับ preview ภาพที่ผู้ใช้ได้เลือก และเปลี่ยนรูปภาพที่เลือกใหม่ -->
<script>
    let imageInput = document.getElementById('comp_userImg');
    let previewImg = document.getElementById('previewImg');
    imageInput.onchange = evt =>{
        const [file] = imageInput.files;
        if(file){
            previewImg.src = URL.createObjectURL(file);
        }
    }
</script>
</html>