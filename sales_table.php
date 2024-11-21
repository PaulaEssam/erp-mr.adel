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

    $sale_id = $_POST['sale_id'];
    $sale = $conn->prepare("DELETE FROM `sales` WHERE id= ?");
    $sale->execute([$sale_id]);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المبيعات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        .flex-info{
            display: flex;
            justify-content: space-between;
            
            
        }
        .flex-info span{
            width: auto; 
            height:50px; 
            border-radius: 10px; 
            padding: 5px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!--header section -->
<?php
include 'components/admin_header.php';
?>
<section class="comments">
<div class="flex-info">
    <!--------------------------- عليا------------------------- -->
    <?php
        $select_alia_k = $conn->prepare('SELECT rest  FROM kataket WHERE id IN ( SELECT MAX(id) FROM kataket GROUP BY name )');
        $select_alia_k->execute();
        $sum_alia_k = 0;
        if($select_alia_k->rowCount() >0){
            while($alia_k = $select_alia_k->fetch(PDO::FETCH_ASSOC)){
                if ($alia_k['rest'] > 0) {
                    $sum_alia_k += $alia_k['rest'];
                }
            }
            
        }
        
        $select_alia_m = $conn->prepare('SELECT rest  FROM medcine WHERE id IN ( SELECT MAX(id) FROM medcine GROUP BY name )');
        $select_alia_m->execute();
        $sum_alia_m = 0;
        if($select_alia_m->rowCount() >0){
            while($alia_m = $select_alia_m->fetch(PDO::FETCH_ASSOC)){
                if ($alia_m['rest'] > 0) {
                    $sum_alia_m += $alia_m['rest'];
                }
            }
            
        }

        $select_alia_f = $conn->prepare('SELECT rest  FROM food WHERE id IN ( SELECT MAX(id) FROM food GROUP BY name )');
        $select_alia_f->execute();
        $sum_alia_f = 0;
        if($select_alia_f->rowCount() >0){
            while($alia_f = $select_alia_f->fetch(PDO::FETCH_ASSOC)){
                if ($alia_f['rest'] > 0) {
                    $sum_alia_f += $alia_f['rest'];
                }
            }
        
        }
        $color = '#0d0058eb';
        $background = '#2200ff4a';
    ?>
    
        <span style=" color: <?=$color?>;  background-color: <?=$background?>;">
        عليا : 
        (<?= $sum_alia_k + $sum_alia_m + $sum_alia_f?>)
        </span>
    <!------------------------------------------------------------>
    <?php
        $select_sales = $conn->prepare("SELECT SUM(sale) AS total_sales FROM `sales`");
        $select_sales->execute();
        $fetch_sales = $select_sales->fetch(PDO::FETCH_ASSOC);
        if($select_sales->rowCount() >0){
                $color = '#650505';
                $background = '#cab2b29c';            
        }
    ?>
    <?php 
        if($select_sales->rowCount() >0){
    ?>
        <span style= "color: <?=$color?>;  background-color: <?=$background?>;">
        اجمالي المبيعات: 
        (<?= $fetch_sales['total_sales']?>)
        </span>
        <?php
            }
        ?> 
    <!--------------------------- الرصيد------------------------- -->
        <?php
            $select_pay_k = $conn->prepare("SELECT SUM(pay) AS total_pays_k FROM `kataket`");
            $select_pay_k->execute();
            $fetch_pay_k = $select_pay_k->fetch(PDO::FETCH_ASSOC);

            $select_pay_m = $conn->prepare("SELECT SUM(pay) AS total_pays_m FROM `medcine`");
            $select_pay_m->execute();
            $fetch_pay_m = $select_pay_m->fetch(PDO::FETCH_ASSOC);

            $select_pay_f = $conn->prepare("SELECT SUM(pay) AS total_pays_f FROM `food`");
            $select_pay_f->execute();
            $fetch_pay_f = $select_pay_f->fetch(PDO::FETCH_ASSOC);
            
        ?>
        <?php 
            if($select_pay_k->rowCount() >0 || $select_pay_m->rowCount() >0 || $select_pay_f->rowCount() >0 ){
                $rased = $fetch_sales['total_sales'] - ($fetch_pay_k['total_pays_k'] + $fetch_pay_m['total_pays_m'] + $fetch_pay_f['total_pays_f'] );
                if($rased >= 0 ){
                    $color = '#09580a';
                    $background = '#07fa07';
                }
                else{
                    $color = '#650505';
                    $background = '#ff00009c';
                }
        ?>
            <span style=" color: <?=$color?>;  background-color: <?=$background?>;">
            الرصيد : 
            (<?= $rased?>)
            </span>
            <?php
                }
            ?> 
    <!------------------------------------------------------------>
</div>
        <br>
    <h1 class="heading">المبيعات</h1>
    <!-- <p style="color: red; font-size: 20px; font-weight: bold; padding: 10px;">السالب معناه انك ليك فلوس</p>  -->

    <div class="box-container">
        
        <div class="box">
            <table id="studentTable" class="studentsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th >المبيعات</th>
                        <!-- <th >الرصيد</th> -->
                        <th >التاريخ</th>
                        <th >حذف</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php
                    $i=1;
                        $select_sale = $conn->prepare("SELECT * FROM `sales`");
                        $select_sale->execute();
                        if($select_sale->rowCount() > 0){
                        while( $fetch_sale = $select_sale->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <tr>
                        <td ><?=$i?></td>
                        <td ><?=$fetch_sale['name']?></td>
                        <td ><?=$fetch_sale['sale']?></td>
                        <!-- <td ></td> -->
                        <td ><?=date('Y-m-d',strtotime($fetch_sale['created_at']))?></td>
                        <td style="font-size: 12px;">
                            <form action="" method="post">
                                    <input type="hidden" name="sale_id" value="<?=$fetch_sale['id']?>">
                                    <input type="submit" class="delete-btn" value="حذف" name="delete" onclick="return confirm('هل انت متاكد من الحذف ?');">
                            </form>
                        </td>
                    </tr>
                    <?php 
                        
                        $i++;
                        // $baqy = $fetch_sale['rest'];
                        }
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