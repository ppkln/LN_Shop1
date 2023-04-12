<?php 
require_once 'config.php';
if(isset($_GET['delUser'])){
    $dataDel = $_GET['delUser'];
    $imgDel = $_GET['imgDelUser'];
    $sqlDel = $conn->query("delete from users where userID=$dataDel");
    $sqlDel->execute();
    if($sqlDel){
        if($imgDel){
            $pathDelImg = "uploads/userProfile/".$imgDel;
            unlink($pathDelImg);

            echo "<script>;";
            //echo "alert('ลบข้อมูลผู้ใขช้ดังกล่าวเรียบร้อยแล้ว.');";
            echo "window.location='index.php';";
            echo "</script>;";
        }
    } else{
        echo "<script>;";
        echo "alert('การลบข้อมูลผู้ใขช้ดังกล่าวไม่สำเร็จ.');";
        echo "window.location='index.php';";
        echo "</script>;";
    }
}


?>