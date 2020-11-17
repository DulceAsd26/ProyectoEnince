<?php 
	session_start();
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Sistema Enince</title>
</head>
<body>
	<?php include "includes/header.php"; 
            include "../conexion.php";
            
            $query_dash = mysqli_query($conection, "CALL dataDashboard();");
            $result_dash = mysqli_num_rows($query_dash);
            if($result_dash > 0){
                $data_dash = mysqli_fetch_assoc($query_dash);
                mysqli_close($conection);
            }
    ?>
        
    <div class="main">
        <div class="barra_lateral">
             <?php include "includes/nav.php"; ?>
        </div>
	   <section id="container">
		      <section class="panel">
                    <div class="users-total">
                        <a href="lista_usuarios.php">
                            <i class="lnr lnr-users"></i>
                            <span class="text-user">
				    	   </span>
                        <small>Usuarios</small>
                        </a>
                    </div>
                   <div class="products-total">
                        <a href="lista_clientes.php">
                            <i class="lnr lnr-store"></i>
                            <span class="text-user">
				    	   </span>
                        <small>Clientes</small>
                        </a>
                    </div>
                   <div class="products-total">
                        <a href="lista_proveedor.php">
                            <i class="lnr lnr-store"></i>
                            <span class="text-user">
				    	   </span>
                        <small>Proveedores</small>
                        </a>
                    </div>
                    <div class="products-total">
                        <a href="lista_producto.php">
                            <i class="lnr lnr-store"></i>
                            <span class="text-user">
				    	   </span>
                        <small>Productos</small>
                        </a>
                    </div>
                  
                  <div class="ventas-total">
                         <a href="ventas.php">
                            <i class="lnr lnr-cart"></i>
				            <span class="text-user">
				            </span>
                        <small>Ventas</small>
                        </a>
                    </div>
                </section>
                <p class="welcom"> Bienvenido al sistema</p>
                <p><img class="user-img" src="img/user.png" alt="Usuario"></p>
                <p><span class="user-login"><?php echo $_SESSION['user']; ?></span></p>
            
	   </section>
	   <?php include "includes/footer.php"; ?>
        </div>
    
</body>
</html>