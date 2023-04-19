<?php 
    session_start();
    require_once "config.php";
    
    $page = (isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;

    $sql1 = $conn->query("select count(email) as numemail from users")->fetchAll();
    $allRecord = $sql1[0]['numemail']; // จำนวนแถวทั้งหมดที่ query ได้

    $perpage = 4; //กำหนดแสดงข้อมูล หน้าละ 4 รายการ
    $startRow = ($page-1)*$perpage ; //ตำแหน่ง row แรก(จากตารางฐานข้อมูล) ที่จะเริ่มนำข้อมูลมาแสดงที่หน้าจอ
    $totalPage = ceil($allRecord/$perpage); // คำนวณหาจำนวนหน้าทั้งหมดที่จะเกิดขึ้นจากการกำหนด perpage เทียบกับข้อมูลทั้งหมดที่ query ได้

    $data = $conn->query("select * from users ORDER BY regisDate DESC limit {$startRow},{$perpage}")->fetchAll(); // query ข้อมูลแบบมีการระบุตำแหน่ง row เริ่มต้นและต้องการให้แสดงกี่ row

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
                                <input type="email" id="email" name="email" class="form-control form-control-lg" title="โปรดตรวจสอบความถูกต้องของ E-mail" placeholder="Enter E-mail" required>
                            </div>
                            <div class="mb-3">
                                <label>เลขประจำตัวประชาชน 13 หลัก: (ต้องระบุ) </label>
                                <input type="text" id="comp_userId" name="comp_userId" class="form-control form-control-lg" pattern="^[0-9,-]{13,}$" title="โปรดตรวจสอบความถูกต้องของหมายเลขประจำตัวประชาชน" placeholder="Enter CitizenID" maxlength="13" minlength="13" required>
                            </div>
                            <div class="mb-3">
                                <label>ชื่อ: (ต้องระบุ) </label>
                                <input type="text" id="comp_userFname" name="comp_userFname" class="form-control form-control-lg" pattern="^[ก-๏a-zA-Z]{2,}$" title="โปรดตรวจสอบความถูกต้องของชื่อ" placeholder="Enter First Name" required>
                            </div>
                            <div class="mb-3">
                                <label>นามสกุล: (ต้องระบุ) </label>
                                <input type="text" id="comp_userLname" name="comp_userLname" class="form-control form-control-lg" pattern="^[ก-๏a-zA-Z]{2,}$" title="โปรดตรวจสอบความถูกต้องของนามสกุล" placeholder="Enter Last Name" required>
                            </div>
                            <div class="mb-3">
                                <label>ที่อยู่: (ต้องระบุ) </label>
                                <textarea cols="10" rows="3" id="comp_userAddress" name="comp_userAddress" class="form-control" minlength="5" placeholder="Enter Address" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>วันเกิด: (ต้องระบุ) </label>
                                <input type="date" id="comp_userBirthdate" name="comp_userBirthdate">
                            </div>
                            <div class="mb-3">
                                <label>เพศ: (ต้องระบุ) </label>
                                <select name="sex" id="sex" required>
                                    <option value="Female" selected >Female</option>
                                    <option value="Male">Male</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>หมายเลขมือถือ: </label>
                                <input type="text" id="comp_userPhone" name="comp_userPhone" class="form-control form-control-lg" pattern="^0([6|8|9])([0-9]){8}$" title="โปรดตรวจสอบรูปแบบของหมายเลขมือถือ" placeholder="Enter Mobile Phone" maxlength="10">
                            </div>
                            <div>
                                <label>รูปภาพ: (เฉพาะไฟล์นามสกุล jpg,jpeg,png,gif เท่านั้น) </label>
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
    <div class="container mt-3 mb-3 border1  ">
        <div class="row mt-4 ">
            <div class="col-sm"><a href="http://localhost/LNshop1/index.php"><img src="http://localhost/LNshop1/imgGI/logoMKZ.jpg" class="rounded" width="50px" height="50px" ></a></div>
            <div class="col-lg-12">
                <div class=" text-center">
                    <h1>ยินดีต้อนรับสู่ระบบ LN Shop1</h1>
                </div>
            <div class="mt-2 mb-2">
                <?php 
                    echo "วันที่ : ";
                    $date = new DateTime("now", new DateTimeZone('Asia/Bangkok'));
                    echo $date->format("d-m-Y H:i:s") . " ตามเวลาประเทศไทย <br>";
                ?>
            </div>                
            </div>
            <div class="col-md-6 d-flex justify-center-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addUsermodal">เพิ่มผู้ใช้ใหม่</button>
            </div>
        </div>

        <?php if(isset($_session['success'])){?>
        <div class="alert alert-success">
            <?php 
                echo $_session['success'];
                unset($_session['success']);
            ?>
        </div>
        <?php } ?>

        <hr>
        <!-- ส่วนแสดงรายการข้อมูล -->
        <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered mt-3 mb-3">
                <thead class="text-center">
                    <tr class="table-success">
                        <th scope="col">email</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">สกุล</th>
                        <th scope="col">เพศ</th>
                        <th scope="col">รูปภาพ</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(!$data){
                        echo "<tr><td class='text-center'>No data of user.</td></tr>";
                    } else{
                        foreach($data as $rows){
                    ?>
                            <tr>
                                <td class="text-center"><?= $rows['email']; ?></td>
                                <td class="text-center"><?= $rows['userFname']; ?></td>
                                <td class="text-center"><?= $rows['userLname']; ?></td>
                                <td class="text-center"><?= $rows['sex']; ?></td>
                                <td width="100px" class="text-center"><img class="rounded" width="80%" src="uploads/userProfile/<?= $rows['userImg'] ?>"></td>
                                <td class="text-center">
                                    <a href="editUser.php?editUser=<?= $rows['userID'] ?>" class="btn btn-warning">แก้ไข</a>
                                    <a href="deleteUser.php?delUser=<?= $rows['userID'] ?>&imgDelUser=<?= $rows['userImg'] ?>" class="btn btn-danger" onclick="return confirm('ต้องการลบข้อมูลผู้ใช้ท่านนี้จริงหรือไม่ ?');">ลบ</a>
                                </td>
                            </tr>
                        <?php 
                            }
                    } ?>
                </tbody>
            </table>
            <!-- คำสั่งแสดงปุ่ม link ไปหน้าต่างๆ -->
            <div class="col-lg-12">
                <div class="text-center">
                    <nav aria-label="pagination-Linkpage-show">
                        <ul class="pagination justify-content-center">
                            <li>
                                <a class="page-link" href="?page=1">First</a>
                            </li>
                            <li  <?php if($page ==1){
                                    echo "class='page-item disabled'";
                            }  else{
                                    echo "class='page-item'";
                            }?>>
                                <a class="page-link" href="?page=<?=$page-1; ?>" tabindex="-1" aria-label="previous" aria-disabled="true">&laquo;</a>
                            </li>
                            <?php if($page <=5 && $page>0 && $page <=$totalPage){?>
                                <?php for($i=1; $i<=5; $i++){?>
                                    <li <?php if($i==$page){ echo "class='page-item active'";}else{echo "class='page-item'";} ?> ><a class="page-link" href="?page=<?=$i; ?>"><?=$i ?></a></li>
                                <?php }?>
                            <?php }elseif($page>0 && $page <=$totalPage){?>
                                <?php for($i=0; $i<=4; $i++){
                                    $i_page = $page+$i;
                                    if($i_page<=$totalPage){
                                    ?>
                                    <li <?php if($i_page==$page){ echo "class='page-item active'";}else{echo "class='page-item'";} ?> ><a class="page-link" href="?page=<?=$i_page; ?>"><?=$i_page ?></a></li>
                                <?php }
                                }?>
                            <?php }?>
                            <li <?php if($page >=$totalPage){
                                    echo "class='page-item disabled'";
                            }  else{
                                    echo "class='page-item'";
                            }?>>
                                <a class="page-link" href="?page=<?=$page+1; ?>" aria-label="next">&raquo;</a>
                            </li>
                            <li class="page-item">
                                <input type="number" class="form-control" min="1" max="<?= $totalPage?>"
                                        style="width:80px;" onClick="this.select()" onchange="window.location.href = 'index.php?page=' + this.value" value="<?= $page?>" />
                            </li> 
                            <li>
                                <a class="page-link" href="?page=<?= $totalPage ?>">Last</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- สิ้นสุดคำสั่งแสดงปุ่ม link ไปหน้าต่างๆ -->
        </div>
        <div>
            <br><br>
        </div>
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