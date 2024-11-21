<?php
include 'components/connect.php';
if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}
else {
    $admin_id = '';
    header("Location: index.php");
    exit();
}

if (isset($_POST['delete'])) {

    $user_id = $_POST['user_id'];
    $user = $conn->prepare("DELETE FROM `users` WHERE id= ?");
    $user->execute([$user_id]);
    
    $userName = $_POST['userName'];
    $delete_kataket = $conn->prepare("DELETE FROM `kataket` WHERE name=?");
    $delete_kataket->execute([$userName]);

}

if (isset($_POST['insertToDataBase'])) {
        $user_name         = $_POST['user_name'];
        $user_name         = filter_var($user_name, FILTER_SANITIZE_STRING);
        
        $category          = $_POST['category'];
        $category          = filter_var($category, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare('SELECT * FROM `users` WHERE user_name=? AND category = ? ');
    $select_user->execute([$user_name, $category]);

    if ($select_user->rowCount() > 0) {
        $message[] = 'المحتوي موجود بالفعل!';
    }
    else{
        
        $add_user = $conn->prepare("INSERT INTO `users` ( user_name, category, created_at)
        VALUES (?,?,?)");
        $add_user -> execute([$user_name, $category, date('Y-m-d')]);            
        
        $message[] =  'تم اضافة مستخدم بنجاح!';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الكتاكيت</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        .boxx{
            width: 50%;
            border-radius: .5rem;
            margin: 1rem 0;
            font-size: 1.8rem;
            color: var(--black);
            padding: 1.4rem;
            background-color: #fff;
        }
        .flex{
            display: flex;
            justify-content: space-between;
        }
        .search input{    
            text-align: right;
            height: 40px;
            width: 250px;
            margin: 5px;
            padding: 15px;
            font-size: 18px;
            border-radius: 5px;
            background: var(--white);
        }
        .search button{
            font-size: 18px;
            color: var(--main-color);
            cursor: pointer;
            background-color: transparent;
        }
        .highlight {
            background-color: var(--orange) !important;
            color: white;
        }
        @media (max-width:450px) {
            button.inline-option-btn.ex{
                width: 65px !important;
                height: 30px;
            }
            th, td{
                font-size: 4px !important;
            }
            td form input ,
            td a,
            td p{
                font-size: 4px !important;
            }
        }
    </style>
</head>
<body>
    <!--header section -->
<?php
include 'components/admin_header.php';
?>
<?php
    if(isset($_POST['add_name'])){
?>
<section class="comment-form">
    <h1 class="heading">اضافة مستخدم</h1>
    <form action="" method="POST">
        <input type="text"  name="user_name" class="boxx" placeholder="اكتب اسم المستخدم">
        <select name="category" class="boxx">
            <option value="كتاكيت">كتاكيت</option>
            <option value="علاج">علاج</option>
            <option value="علف">علف</option>
        </select>
        <br>
        <input type="submit" value="اضافة" name="insertToDataBase" class="inline-btn">
    </form>
</section>
<?php
}
?>
<section class="comments">
    <h1 class="heading">الكتاكيت</h1>
    <!-- <p style="color: red; font-size: 20px; font-weight: bold; padding: 10px;">السالب معناه انك ليك فلوس</p> -->

    <!-- <div class="box-container">
        
        <div class="box">
            <table id="studentTable" class="studentsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>العدد</th>
                        <th> السعر</th>
                        <th > المدفوع</th>
                        <th >الباقي</th>
                        <th >التاريخ</th>
                        <th >تعديل</th>
                        <th >حذف</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php
                    $i=1;
                        $select_katkot = $conn->prepare("SELECT * FROM `kataket`");
                        $select_katkot->execute();
                        while( $fetch_katkot = $select_katkot->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <tr>
                        <td ><?=$i?></td>
                        <td ><?=$fetch_katkot['name']?></td>
                        <td ><?=$fetch_katkot['num']?></td>
                        <td ><?=$fetch_katkot['price']?></td>
                        <td ><?=$fetch_katkot['pay']?></td>
                        <td ><?=$fetch_katkot['rest'];?></td>
                        <td ><?=date('Y-m-d',strtotime($fetch_katkot['created_at']))?></td>
                        <td ><a href="edit_katkot.php?k_id=<?=$fetch_katkot['id']?>" class="option-btn">تعديل</a></td>
                        <td style="font-size: 12px;">
                            <form action="" method="post">
                                    <input type="hidden" name="katkot_id" value="<?=$fetch_katkot['id']?>">
                                    <input type="submit" class="delete-btn" value="حذف" name="delete" onclick="return confirm('هل انت متاكد من الحذف ?');">
                            </form>
                        </td>
                    </tr>
                    <?php 
                        $i++;
                    }
                    ?>
                
                </tbody>
            </table>
        </div>
        
    </div> -->

    <form action="" method="post">
        <input type="submit" name="add_name" value="اضافة مستخدم + " class="inline-btn">
    </form>
</section>

<section class="dashboard">
    <h1 class="heading"> المستخدمين</h1>
    <div class="box-container">
        <?php
            $select_user = $conn->prepare('SELECT * FROM `users` WHERE  category = ? ');
            $select_user->execute(['كتاكيت']);
            if($select_user->rowCount() > 0){
                while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <h3>مرحبا !</h3>
            <p><?= $fetch_user['user_name'];?></p>
            <div class="flex">
                <a href="kataket.php?u_name=<?=$fetch_user['user_name'];?>" class="btn" style="width: 30%;">اضافة</a>
                <a href="kataket_table.php?u_name=<?=$fetch_user['user_name'];?>" class="option-btn" style="width: 30%;">عرض</a>
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?=$fetch_user['id']?>">
                    <input type="hidden" name="userName" value="<?=$fetch_user['user_name']?>">
                    <input type="submit" class="delete-btn" value="حذف" name="delete" onclick="return confirm('هل انت متاكد من حذف <?=$fetch_user['user_name']?> ؟');">
                </form>            
            </div>
        </div>
        <?php
                }
        }
        ?>
    </div>
</section>
<!-- footer section -->
<?php
include 'components/footer.php';
?>
<script src="js/admin_script.js"></script>
</body>
</html>