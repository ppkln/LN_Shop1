<?php
session_start();
require_once "config.php";

if(isset($_POST['submit'])){
    $email = strtolower(trim($_POST['email'])); //เปลี่ยนชื่อ e-mail เป็นตัวพิมพ์เล็ก
    $data = "";
    $sql = $conn->query("select * from users where email like '$email'");
    $sql->execute();
    $data = $sql->fetch();

    if($data == ""){
        $userid = trim($_POST['comp_userId']);
        $fname = trim($_POST['comp_userFname']);
        $lname = trim($_POST['comp_userLname']);
        $address = strip_tags($_POST['comp_userAddress']);
        $birthDate = trim($_POST['comp_userBirthdate']);
        $sex = $_POST['sex'];
        $phone = trim($_POST['comp_userPhone']);
        $img = $_FILES['comp_userImg'];

        $date = new DateTime("now", new DateTimeZone('Asia/Bangkok'));//กำหนดโซนเวลาปัจจุบันโดยยึดตามเวลาไทย
        $regisDate = $date->format("Y-m-d H:i:s"); //รูปแบบวันที่ต้องปรับตามรูปแบบการบันทึกวันที่ของเครื่อง server
        //$regisDate = $date->format(DateTime::RFC1123);

        if($_FILES['comp_userImg']==""){
            $img['name'] = "np1.png";
        };
        $extension = explode('.',$img['name']);//คำสั่งแยกข้อความออกเป็นส่วนๆ โดยใช้เครื่องหมายจุด(.)เป็นเงื่อนไขการแบ่งส่วน
        $fileExt = strtolower(end($extension));//คำสั่งนำข้อความใน array ตัวสุดท้าย มาทำการปรับเป็นอักษรตัวพิมพ์เล็ก
        $checkExt = array('jpg','jpeg','png');
        if(in_array($fileExt,$checkExt) && $img !=""){
            $newFileupload = mktime(date('H'),date('i'),date('s'),date('d'),date('m'),date('Y'))."ppk.".$fileExt; // ตั้งชื่อใหม่ให้ไฟล์ภาพที่เราอัพโหลด ด้วยการประยุกต์ใช้รูปแบบของวันเวลาปัจจุบันมากำหนดเป็นชื่อ
            $filePath = "uploads/userProfile/".$newFileupload;// กำหนด path ตำแหน่งที่ไฟล์อัพโหลดจะถูกนำไปจัดเก็บโดยสร้างโฟล์เดอร์ตามหมายเลขประจำตัวประชาชน
            if($img['size']>0 && $img['error']==0){
                if(move_uploaded_file($img['tmp_name'],$filePath)){//ตรวจสอบว่าได้ทำการ upload ไฟล์รูปภาพไปจัดเก็บที่ server สำเร็จเรียบร้อยแล้วหรือไม่
                    //เมื่อไฟล์ถูกอัพโหลดไปเก็บไว้ที่ server สำเร็จ จึงทำการบันทึกข้อมูลลงตารางฐานข้อมูลได้ หากอัพโหลดไม่สำเร็จก็จะไม่บันทึกลงตารางฐานข้อมูล
                    $sql = $conn->prepare("INSERT INTO users(email,userID,userFname,userLname,userAddress,userBirthdate,sex,userPhone,userImg,regisDate) VALUES(:email,:userID,:userFname,:userLname,:userAddress,:userBirthdate,:sex,:userPhone,:userImg,:regisDate)");
                    $sql->bindParam(":email",$email);
                    $sql->bindParam(":userID",$userid);
                    $sql->bindParam(":userFname",$fname);
                    $sql->bindParam(":userLname",$lname);
                    $sql->bindParam(":userAddress",$address);
                    $sql->bindParam(":userBirthdate",$birthDate);
                    $sql->bindParam(":sex",$sex);
                    $sql->bindParam(":userPhone",$phone);
                    $sql->bindParam(":userImg",$newFileupload);
                    $sql->bindParam(":regisDate",$regisDate);
                    $sql->execute();
                    if($sql){
                        echo "<script>;";
                        echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
                        echo "window.location='index.php';";
                        echo "</script>;";
                    } else{
                        echo "<script>;";
                        echo "alert('บันทึกข้อมูลไม่สำเร็จ');";
                        echo "window.location='index.php';";
                        echo "</script>;";
                    };
                };
            };
        } else{
            $defaullFilename = "ppk1.png";
            $sql = $conn->prepare("INSERT INTO users(email,userID,userFname,userLname,userAddress,userBirthdate,sex,userPhone,userImg,regisDate) VALUES(:email,:userID,:userFname,:userLname,:userAddress,:userBirthdate,:sex,:userPhone,:userImg,:regisDate)");
            $sql->bindParam(":email",$email);
            $sql->bindParam(":userID",$userid);
            $sql->bindParam(":userFname",$fname);
            $sql->bindParam(":userLname",$lname);
            $sql->bindParam(":userAddress",$address);
            $sql->bindParam(":userBirthdate",$birthDate);
            $sql->bindParam(":sex",$sex);
            $sql->bindParam(":userPhone",$phone);
            $sql->bindParam(":userImg",$defaullFilename);
            $sql->bindParam(":regisDate",$regisDate);
            $sql->execute();
            if($sql){
                echo "<script>;";
                echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
                echo "window.location='index.php';";
                echo "</script>;";
            } else{
                echo "<script>;";
                echo "alert('บันทึกข้อมูลไม่สำเร็จ');";
                echo "window.location='index.php';";
                echo "</script>;";
            };        
        };
        

    } else {
        echo "<script>;";
        echo "alert('มีผู้ใช้ท่านนี้ในระบบแล้ว');";
        echo "window.location='index.php';";
        echo "</script>;";
    };
};

?>