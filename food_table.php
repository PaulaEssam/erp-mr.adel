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

    $food_id = $_POST['food_id'];
    $food = $conn->prepare("DELETE FROM `food` WHERE id= ?");
    $food->execute([$food_id]);
}
if (isset($_GET['u_name'])) {
    $u_name = $_GET['u_name'];
}
else{
    $u_name = '';
    header("Location: show_food.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>العلف</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        
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
<section class="comments">
    <?php
        $select_baqy = $conn->prepare("SELECT * FROM `food` WHERE name = ? ORDER BY id DESC ");
        $select_baqy->execute([$u_name]);
        $fetch_baqy = $select_baqy->fetch(PDO::FETCH_ASSOC);
        if($select_baqy->rowCount() >0){
            if($fetch_baqy['rest'] <=0 ){
                $color = '#09580a';
                $background = '#07fa07';
            }
            else{
                $color = '#650505';
                $background = '#ff00009c';
            }
        }
    ?>
    <?php 
        if($select_baqy->rowCount() >0){
    ?>
        <span style="width:auto; height:50px; border-radius: 10px; padding: 5px;
        font-size: 20px; color: <?=$color?>; float:left; text-align: center; background-color: <?=$background?>;">
        اجمالي الباقي: 
        (<?= $fetch_baqy['rest']?>)
        </span>
        <?php
            }
        ?>
    <h1 class="heading">العلف</h1>
    <p style="color: red; font-size: 20px; font-weight: bold; padding: 10px;">السالب معناه انك ليك فلوس</p> 

    <div class="box-container">
        
        <div class="box">
            <table id="studentTable" class="studentsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>عدد الاطنان</th>
                        <th> السعر</th>
                        <th > المدفوع</th>
                        <th >الباقي</th>
                        <th >التاريخ</th>
                        <th >حذف</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php
                    $i=1;
                        $select_food = $conn->prepare("SELECT * FROM `food` WHERE name=?");
                        $select_food->execute([$u_name]);
                        while( $fetch_food = $select_food->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <tr>
                        <td ><?=$i?></td>
                        <td ><?=$fetch_food['name']?></td>
                        <td ><?=$fetch_food['num']?></td>
                        <td ><?=$fetch_food['price']?></td>
                        <td ><?=$fetch_food['pay']?></td>
                        <td ><?=$fetch_food['rest'];?></td>
                        <td ><?=date('Y-m-d',strtotime($fetch_food['created_at']))?></td>
                        <td style="font-size: 12px;">
                            <form action="" method="post">
                                    <input type="hidden" name="food_id" value="<?=$fetch_food['id']?>">
                                    <input type="submit" class="delete-btn" value="حذف" name="delete" onclick="return confirm('هل انت متاكد من الحذف ?');">
                            </form>
                        </td>
                    </tr>
                    <?php 
                        $i++;
                        $baqy = $fetch_food['rest'];
                    }
                    ?>
                
                </tbody>
            </table>
            
        </div>
        
    </div>

</section>


<!-- footer section  -->
<?php
include 'components/footer.php';
?>
<script src="js/admin_script.js"></script>

</body>
</html>