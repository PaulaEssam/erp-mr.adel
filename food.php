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
    if (isset($_GET['u_name'])) {
        $u_name = $_GET['u_name'];
    }
    else{
        $u_name = '';
        header("Location: show_food.php");
    }

    if (isset($_POST['submit'])) {    
        // $name         = $_POST['name'];
        // $name         = filter_var($name, FILTER_SANITIZE_STRING);
        
        $num          = $_POST['num'];
        $num          = filter_var($num, FILTER_SANITIZE_STRING);

        $price          = $_POST['price'];
        $price          = filter_var($price, FILTER_SANITIZE_STRING);

        $pay          = $_POST['pay'];
        $pay          = filter_var($pay, FILTER_SANITIZE_STRING);

        $total_pay = $pay ;
        if (!empty($price)) {
            $total_price = $price ;
        }
        // else{
        //     $total_price = 0 ;
        // }
        $rest = 0;
        $select_food = $conn->prepare("SELECT * FROM `food` WHERE name=? ORDER BY id DESC");
        $select_food->execute([$u_name]);
        $fetch_food = $select_food->fetch(PDO::FETCH_ASSOC);

        if ($select_food->rowCount() > 0) {
            
            $total_pay = $pay + $fetch_food['total_pay'];
            if (!empty($price)) {
                $total_price = $price + $fetch_food['total_price'];
            }
            else {
                $total_price = $fetch_food['total_price'];
            }
        }
            $rest = $total_price - $total_pay ;
            $add_content = $conn->prepare("INSERT INTO `food` ( name, num, price, total_price, pay, total_pay, rest, created_at)
            VALUES (?,?,?,?,?,?,?,?)");
            $add_content -> execute([$u_name, $num, $price, $total_price, $pay, $total_pay, $rest, date('Y-m-d H:i:m')]);            
            
            $message[] =  'تم اضافة المحتوي بنجاح!';
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اضافة علف</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<!--header section -->
<?php 
    include 'components/admin_header.php';
?>
<!-- add contensection start-->
<section class="crud-form">
    <h1 class="heading">اضافة علف</h1>
    <form action="" method="post" >
        
        <!-- <p> الاسم <span>*</span></p>
        <input type="text" name="name" placeholder="اكتب الاسم" class="box" maxlength="100" required> -->
        
        <p> عدد الاطنان </p>
        <input type="text" name="num" placeholder="اكتب العدد" class="box" maxlength="100" >
        
        <p> السعر </p>
        <input type="text" name="price" placeholder="اكتب السعر" class="box" maxlength="100" >
        
        <p> المدفوع </p>
        <input type="text" name="pay" placeholder="اكتب المدفوع" class="box" maxlength="100" >
        
        <input type="submit" name="submit"  value="اضافة" class="btn">
    
    </form>

</section>



<!-- footer section -->
<?php 
        include 'components/footer.php';
?>
<script src="js/admin_script.js"></script>
</body>
</html>