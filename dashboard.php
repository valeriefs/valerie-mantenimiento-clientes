<?php 
    session_start();
  
    if(!$_SESSION['id']){
        header('location:login.php');
    }
 
?>
 
<h1>Bienvenido <?php echo ucfirst($_SESSION['nombre']); ?></h1>
<a href="logout.php?logout=true">Logout</a>