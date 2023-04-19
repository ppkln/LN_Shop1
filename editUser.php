<?php
        require_once "config.php";
        session_start();
        //แสดงข้อมูลผู้ใช้ที่ผ่านการกดปุ่ม แก้ไข 
        if(isset($_GET['editUser'])){
            $dataEdit = trim($_GET['editUser']);
            $dataEdit = htmlspecialchars($_GET['editUser']);
            $dataEdit = strip_tags($_GET['editUser']);

            $sqlshow = $conn->query("select * from users where userID=$dataEdit");
            $sqlshow->execute();
            $dataUser = $sqlshow->fetch();
        } elseif($_POST['comp_userId']) {
            $dataemail = $_POST['email'];
            $datauserID = $_POST['comp_userId'];
            $datauserFname = $_POST['comp_userFname'];
            $datauserLname = $_POST['comp_userLname'];
            $datauserAddress = $_POST['comp_userAddress'];
            $datauserBirthdate = $_POST['comp_userBirthdate'];
            $datausersex = $_POST['sex'];
            $datauserPhone= $_POST['comp_userPhone'];

            $datauserImg = $_FILES['comp_userImg'];
            $datauserImg2 = $_POST['comp_userImg2'];
            $upload = $_FILES['comp_userImg']['name'];

            if($upload !=''){// กรณีมีการอัพเดตรูปโปรไฟล์ใหม่
                $checkExt = array('jpg','jpeg','png','gif');
                $extension = explode('.',$datauserImg['name']);//คำสั่งแยกข้อความออกเป็นส่วนๆ โดยใช้เครื่องหมายจุด(.)เป็นเงื่อนไขการแบ่งส่วน
                $fileExt = strtolower(end($extension));//คำสั่งนำข้อความใน array ตัวสุดท้าย มาทำการปรับเป็นอักษรตัวพิมพ์เล็ก
                if(in_array($fileExt,$checkExt)){
                    $newFileupload = mktime(date('H'),date('i'),date('s'),date('d'),date('m'),date('Y'))."ppk.".$fileExt; // ตั้งชื่อใหม่ให้ไฟล์ภาพที่เราอัพโหลด ด้วยการประยุกต์ใช้รูปแบบของวันเวลาปัจจุบันมากำหนดเป็นชื่อ
                    $filePath = "uploads/userProfile/".$newFileupload;
                    if($datauserImg['size'] > 0 && $datauserImg['error'] == 0){
                        if(move_uploaded_file($datauserImg['tmp_name'],$filePath)){
                            //เมื่อไฟล์ถูกอัพโหลดไปเก็บไว้ที่ server สำเร็จ จึงทำการ update ข้อมูลลงตารางฐานข้อมูลได้ หากอัพโหลดไม่สำเร็จก็จะไม่ update ลงตารางฐานข้อมูล
                            $sql = $conn->prepare("UPDATE users SET email=:email,userID=:userID,userFname=:userFname,userLname=:userLname,userAddress=:userAddress,userBirthdate=:userBirthdate,sex=:sex,userPhone=:userPhone,userImg=:userImg WHERE userID=$datauserID");
                            $sql->bindParam(":email",$dataemail);
                            $sql->bindParam(":userID",$datauserID);
                            $sql->bindParam(":userFname",$datauserFname);
                            $sql->bindParam(":userLname",$datauserLname);
                            $sql->bindParam(":userAddress",$datauserAddress);
                            $sql->bindParam(":userBirthdate",$datauserBirthdate);
                            $sql->bindParam(":sex",$datausersex);
                            $sql->bindParam(":userPhone",$datauserPhone);
                            $sql->bindParam(":userImg",$newFileupload);
                            $sql->execute();
                            if($sql){
                                echo "<script>;";
                                echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
                                echo "window.location='index.php';";
                                echo "</script>;";
                            } else{
                                echo "<script>;";
                                echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
                                echo "window.location='index.php';";
                                echo "</script>;";
                            };
                        };
                    }
                } 
            } else{ // กรณีไม่มีการอัพเดตรูปโปรไฟล์
                $sql = $conn->prepare("UPDATE users SET email=:email,userID=:userID,userFname=:userFname,userLname=:userLname,userAddress=:userAddress,userBirthdate=:userBirthdate,sex=:sex,userPhone=:userPhone,userImg=:userImg WHERE userID=$datauserID");
                $sql->bindParam(":email",$dataemail);
                $sql->bindParam(":userID",$datauserID);
                $sql->bindParam(":userFname",$datauserFname);
                $sql->bindParam(":userLname",$datauserLname);
                $sql->bindParam(":userAddress",$datauserAddress);
                $sql->bindParam(":userBirthdate",$datauserBirthdate);
                $sql->bindParam(":sex",$datausersex);
                $sql->bindParam(":userPhone",$datauserPhone);
                $sql->bindParam(":userImg",$datauserImg2);
                $sql->execute();
                if($sql){
                    echo "<script>;";
                    echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
                    echo "window.location='index.php';";
                    echo "</script>;";
                } else{
                    echo "<script>;";
                    echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
                    echo "window.location='index.php';";
                    echo "</script>;";
                };
            };
            

        }else{
            header("location:http://localhost/LNshop1/index.php");
            exit(0);
        }
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
   
    <!-- คำสั่ง Jquery สำหรับ date type ของ textbox ข้อมูลวันเกิด 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#comp_userBirthdate" ).datepicker();
        } );
    </script>
     สิ้นสุดคำสั่ง Jquery สำหรับ date type ของ textbox ข้อมูลวันเกิด -->
    
    <title>LN Shop1</title>
    <style>
        .container{
            max-width: 1328px;
        }

        textarea:invalid { /* หากไม่ตรงตามเงื่อนไข minlenght และ required จะแสดงเส้นกรอบปะสีแดง */
            border: 2px dashed red;
        }
        .border1{
            border:1px solid #00008B;
            padding:5px 20px; 
            background: #ffffff;
            border-radius:15px;
            max-width: 1328px;
        }
    </style>
</head>
<body>
<div class="container mt-3 mb-3 border1">
    <div class="row mt-4">
        <div class="col-sm"><a href="http://localhost/LNshop1/index.php"><img src="http://localhost/LNshop1/imgGI/logoMKZ.jpg" class="rounded" width="50px" height="50px" ></a></div>
        <div class="col-lg-12">
            <div class="text-center">
                <h1>ยินดีต้อนรับสู่ระบบ LN Shop1</h1>
            </div>
        </div>
        <div class="mt-2 mb-2">
            <?php 
                echo "วันที่ : ";
                $date = new DateTime("now", new DateTimeZone('Asia/Bangkok'));
                echo $date->format("d-m-Y H:i:s") . " ตามเวลาประเทศไทย <br>";
            ?>
        </div>
    </div>
    <hr>
    <div class="text-center">
        <font color="blue"><h2>แก้ไขข้อมูลส่วนตัวผู้ใช้</h2></font>
    </div>
    <form id="editUserfrm" action="editUser.php" method="post" enctype="multipart/form-data" >
        <div class="mb-3">
            <h5><label for="email" class="col-form-label"> E-mail ผู้ใช้ : <?= $dataUser['email']; ?></label></h5>
            <input type="hidden" readonly value="<?= $dataUser['email']; ?>"  class="form-control" name="email">
            <input type="hidden" value="<?= $dataUser['userImg']; ?>"  class="form-control" name="comp_userImg2">
        </div>
        <div class="mb-3">
            <h5><label for="userId" class="col-form-label"> เลขบัตรประชาชนผู้ใช้ : <?= $dataUser['userID']; ?></label></h5>
            <input type="hidden" readonly id="comp_userId" name="comp_userId" value="<?= $dataUser['userID']; ?>">
        </div>
        <div class="mb-3">
            <label>ชื่อ: (ต้องระบุ) </label>
            <input type="text" id="comp_userFname" name="comp_userFname" value="<?= $dataUser['userFname']; ?>" style="width:400px;" class="form-control form-control-lg" maxlength="50" pattern="^[ก-๏a-zA-Z]{2,}$" title="โปรดตรวจสอบความถูกต้องของชื่อ" placeholder="Enter First Name" required>
        </div>
        <div class="mb-3">
            <label>นามสกุล: (ต้องระบุ) </label>
            <input type="text" id="comp_userLname" name="comp_userLname" value="<?= $dataUser['userLname']; ?>" style="width:400px;" class="form-control form-control-lg" maxlength="50" pattern="^[ก-๏a-zA-Z]{2,}$" title="โปรดตรวจสอบความถูกต้องของนามสกุล" placeholder="Enter Last Name" required>
        </div>
        <div class="mb-3">
            <label>ที่อยู่: (ต้องระบุ) </label>
            <textarea cols="5" rows="3" id="comp_userAddress" name="comp_userAddress" style="width:600px;" class="form-control" minlength="5" placeholder="Enter Address" required><?= $dataUser['userAddress']; ?></textarea>
        </div>
        <div class="mb-3">
            <label>วันเกิด: (ต้องระบุ) </label>
            <input type="date" id="comp_userBirthdate" name="comp_userBirthdate" value="<?= $dataUser['userBirthdate']; ?>">
        </div>
        <div class="mb-3">
            <label>เพศ: (ต้องระบุ) </label>
            <select name="sex" id="sex" required>
                <option value="Female" <?php if($dataUser['sex'] == "Female"){ echo "selected";}?> >Female</option>
                <option value="Male" <?php if($dataUser['sex'] == "Male"){echo "selected";} ?>>Male</option>
            </select>
        </div>
        <div class="mb-3">
            <label>หมายเลขมือถือ: </label>
            <input type="text" id="comp_userPhone" name="comp_userPhone" value="<?= $dataUser['userPhone']; ?>" style="width:200px;" class="form-control form-control-lg" pattern="^0([6|8|9])([0-9]){8}$" title="โปรดตรวจสอบรูปแบบของหมายเลขมือถือ" placeholder="Enter Mobile Phone" maxlength="10">
        </div>
        <div>
            <label>รูปภาพ: (เฉพาะไฟล์นามสกุล jpg,jpeg,png,gif เท่านั้น)</label>
            <input type="file" id="comp_userImg" name="comp_userImg" class="form-control" accept="image/jpeg,image/jpg,image/png,image/gif">
            <img width="30%" src="uploads/userProfile/<?= $dataUser['userImg']; ?>" id="previewImg" alt="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" onclick="window.location.href='http://localhost/LNshop1/index.php'">ยกเลิก</button>
            <button type="submit" name="submit" id="submit" value="submit" class="btn btn-success" >ตกลง</button>
        </div>
    </form>                       
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