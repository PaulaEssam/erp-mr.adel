<?php
if (isset($message)) {
    foreach($message as $msg){
        echo '
            <div class="message">
                <span>'.$msg.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        
        ';
    }
}


?>
<!-- header section starts -->
<header class="header">
    <section class="flex">
        <a href="dashboard.php" class="logo">المسؤل</a>

        <!-- <form action="search_page.php" method="post" class="search-form">
            <input type="text" name="search_box" placeholder="بحث..." 
                maxlen="100" required/>
            <button type="submit" class="fas fa-search" name="search_btn"> </button>
        </form> -->
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-moon"></div>
        </div>

        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id=?");
                $select_profile->execute([$admin_id]);
                if($select_profile->rowCount() > 0){
                    $fetch_profile =  $select_profile->fetch(PDO::FETCH_ASSOC) ;
                
            ?>
            <h3><?= $fetch_profile['name'];?></h3>
            <a href="profile.php" class="btn">عرض البروفايل</a>
            <!-- <div class="flex-btn">
                <a href="login.php" class="option-btn">login</a>
                <a href="register.php" class="option-btn">register</a>
            </div> -->
            <a href="components/admin_logout.php" onclick="return confirm('logout from this website?')" class="delete-btn">تسجيل خروج</a>

            <?php 
            
                }
            ?>
        </div>
    </section>
</header>
<!-- header section ends -->


<!-- side bar section start -->
<div class="side-bar">
        <div class="close-side-bar">
            <i class="fas fa-times"></i>
        </div>
        <div class="profile">
            <?php
                $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id=?");
                $select_profile->execute([$admin_id]);
                if($select_profile->rowCount() > 0){
                    $fetch_profile =  $select_profile->fetch(PDO::FETCH_ASSOC) ;
                
            ?>
            <h3><?= $fetch_profile['name'];?></h3>
            <a href="profile.php" class="btn">عرض البروفايل</a>
            

            <?php 
            
                }
            ?>    
        </div>
        <nav class="navbar">
            <a href="dashboard.php"><span>الرئيسية</span></a>
            <a href="kataket.php"><span>كتاكيت</span></a>
            <a href="show_medcine.php"><span>علاج</span></a>
            <a href="show_food.php"><span> علف</span></a>
            <a href="sales.php"><span>مبيعات</span></a>
            <!-- <a href="slider.php"><span>كشف الحساب</span></a> -->


            <a href="components/admin_logout.php" onclick="return confirm('logout from this website?')"><i class="fas fa-right-from-bracket"></i><span>تسجيل خروج</span></a>
        </nav>
</div>
<!-- side bar section end -->