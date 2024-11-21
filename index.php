<?php
include 'components/connect.php';
    if (isset($_COOKIE['admin_id'])) {
        $admin_id = $_COOKIE['admin_id'];
    }
    else {
        $admin_id = '';
    }

    if (isset($_POST['submit'])) {
        // Get the data from form    
        $phone          = $_POST['phone'];
        $phone          = filter_var($phone, FILTER_SANITIZE_STRING);
        
        $pass           = sha1($_POST['pass']);
        $pass           = filter_var($pass, FILTER_SANITIZE_STRING);
        
        $verify_admin = $conn->prepare("SELECT * FROM `admins` WHERE number=? AND password =? LIMIT 1");
        $verify_admin->execute([$phone, $pass]);
        $row = $verify_admin->fetch(PDO::FETCH_ASSOC);
        
            if ($verify_admin->rowCount() > 0) {
                    setcookie('admin_id', $row['id'], time() + 60*60*24*30,'/');
                    header("Location: dashboard.php");
            }else{
                $message[] = 'خطأ في رقم الهاتف او كلمة المرور!';
            }         
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body style="padding-left:0;">


<?php
if (isset($message)) {
    foreach($message as $msg){
        echo '
            <div class="message form">
                <span>'.$msg.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        
        ';
    }
}


?>


<!-- login section start -->
<section class="form-container">
    
    <form action="" class="login" method="post" enctype="multipart/form-data">
        <h3>مرحبا </h3>
                <p>رقم الهاتف <span>*</span></p>
                <input type="number" name="phone" min="0" required
                placeholder="رقم الهاتف" class="box">

                <p>كلمة السر <span>*</span></p>
                    <input type="password" name="pass" maxlength="20" required
                    placeholder="كلمة السر" class="box">
                
                <input type="submit" name="submit" value="تسجيل" class="btn">
                <!-- <p class="link">don't have an account? <a href="register.php">register now</a></p> -->
    </form>
</section>
<!-- login section end -->











<script src="js/admin_script.js"></script>
</body>
</html>