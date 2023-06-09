<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}



if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Teljesítendő rendelések</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">


   <style>

body{

background: linear-gradient(120deg, #CA8B5E 50%, #DAA71C 50%);

}


</style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">Teljesítendő rendelés(ek)</h1>

<div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Létrehozva : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Név : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Telefonszám : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Szállítási cím : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Össztermék : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Összár : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> Fizetési mód : <span><?= $fetch_orders['method']; ?></span> </p>
      
   

        <div class="flex-btn">
         
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Törli ezt a rendelést?');">Törlés</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Nincs még leadott rendelés!</p>';
      }
   ?>

</div>

</section>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>
