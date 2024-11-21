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
        header("Location: showKataket.php");
    }

    if (isset($_POST['submit'])) {    
        // $name         = $_POST['name'];
        // $name         = filter_var($name, FILTER_SANITIZE_STRING);
        
        $fatora          = $_POST['fatora'];
        $fatora          = filter_var($fatora, FILTER_SANITIZE_STRING);

        $pay          = $_POST['pay'];
        $pay          = filter_var($pay, FILTER_SANITIZE_STRING);

        $total_pay = $pay ;
        if (!empty($fatora)) {
            $total_price = $fatora ;
        }

        $rest = 0;
        
        $select_medcine = $conn->prepare("SELECT * FROM `medcine` WHERE name =? ORDER BY id DESC");
        $select_medcine -> execute([$u_name]);
        $fetch_medcine = $select_medcine->fetch(PDO::FETCH_ASSOC);

        if ($select_medcine->rowCount() > 0) {
            $total_pay = $pay + $fetch_medcine['total_pay'];
            if (!empty($fatora)) {
                $total_price = $fatora + $fetch_medcine['total_price'];
            }
            else {
                $total_price = $fetch_medcine['total_price'];
            }
        }
        
            $rest =  $total_price - $total_pay ;
            $add_content = $conn->prepare("INSERT INTO `medcine` ( name,fatora, total_price, pay, total_pay, rest, created_at) VALUES (?,?,?,?,?,?,?)");
            $add_content->execute([$u_name, $fatora, $total_price, $pay, $total_pay, $rest, date('Y-m-d')]);
            $message[] = 'تم إضافة المحتوي بنجاح!';
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اضافة علاج</title>
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
    <h1 class="heading">اضافة علاج</h1>
    <form action="" method="post" >
<!--         
        <p> الاسم <span>*</span></p>
        <input type="text" name="name" placeholder="اكتب الاسم" class="box" maxlength="100" required> -->
        
        <p> قيمة الفاتورة <span>*</span></p>
        <input type="text" name="fatora" placeholder="اكتب قيمة الفاتورة" class="box" maxlength="100" >
        
        <p> المدفوع <span>*</span></p>
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