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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="css/admin_style.css">
    <title>لوحة التحكم </title>
</head>
<body>
<?php 
    include 'components/admin_header.php';
?>
<section class="dashboard">
    <h1 class="heading">لوحة التحكم</h1>
    <div class="box-container">
            
        <div class="box">
            <h3>مرحبا !</h3>
            <p><?= $fetch_profile['name'];?></p>
            <a href="profile.php" class="btn">تعديل البروفايل</a>
        </div>

        <div class="box">
            <p>كتاكيت</p>
            <a href="showKataket.php" class="btn"> عرض كتاكيت</a>
        </div>

        <div class="box">
            <p>علاج</p>
            <a href="show_medcine.php" class="btn"> عرض علاج</a>
        </div>

        <div class="box">
            <p>علف</p>
            <a href="show_food.php" class="btn"> عرض علف</a>
        </div>

        <div class="box">
            <p>مبيعات</p>
            <a href="sales.php" class="btn"> عرض مبيعات</a>
        </div>
        
        <!-- <div class="box">
            <p>كشف حساب</p>
            <a href="messages.php" class="btn">عرض كشف حساب</a>
        </div> -->
    </div>  

</section>

<!-- footer section start -->
<?php include 'components/footer.php';?>
<!-- footer section end -->
<script src="js/admin_script.js"></script>

</body>
</html>