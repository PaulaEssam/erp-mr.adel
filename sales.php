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

    if (isset($_POST['submit'])) {    
        $name         = $_POST['name'];
        $name         = filter_var($name, FILTER_SANITIZE_STRING);
        
        $sales          = $_POST['sales'];
        $sales          = filter_var($sales, FILTER_SANITIZE_STRING);

        $add_content = $conn->prepare("INSERT INTO `sales` ( name, sale, created_at)
        VALUES (?,?,?)");
        $add_content -> execute([$name, $sales, date('Y-m-d H:i:m')]);            
        
        $message[] =  'تم اضافة المحتوي بنجاح!';
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مبيعات</title>
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
    <h1 class="heading">المبيعات</h1>
    <form action="" method="post" >
        
        <p> الاسم </p>
        <input type="text" name="name" placeholder="اكتب الاسم" class="box" maxlength="100">
        
        <p> المبيع </p>
        <input type="text" name="sales" placeholder="اكتب السعر" class="box" maxlength="100" >
        
        <input type="submit" name="submit"  value="اضافة" class="btn">
    </form>
    
</section>
<a href="sales_table.php" class="inline-option-btn">عرض المبيعات</a>



<!-- footer section -->
<?php 
        include 'components/footer.php';
?>
<script src="js/admin_script.js"></script>
</body>
</html>