        <div class="content-menu">
            
            <li><a href="index.php"><span class="lnr lnr-home icon1"></span><h4 class="text1">Inicio</h4></a></li>
            
            <li><a href="lista_usuarios.php"><span class="lnr lnr-user icon2"></span><h4 class="text2">Usuarios</h4></a></li>
            <?php 
            if($_SESSION['rol'] == 1){
            ?>
            <li><a href="registro_usuario.php"><span class="lnr lnr-users icon3"></span><h4 class="text3">Agregar Usuario</h4></a></li>
            <?php } ?>
            <li><a href="lista_producto.php "><span class="lnr lnr-store icon4"></span><h4 class="text4">Productos</h4></a></li>
            
            <li><a href="registro_productos.php"><span class="lnr lnr-plus-circle icon5"></span><h4 class="text5">Nuevo Producto</h4></a></li>
            
             <li><a href="ventas.php"><span class="lnr lnr-cart icon6"></span><h4 class="text6">Ventas</h4></a></li>
            
            <li><a href="nueva_venta.php"><span class="lnr lnr-book icon7"></span><h4 class="text7">Nueva Ventas</h4></a></li>
            
            <li><a href="lista_proveedor.php"><span class="lnr lnr-car icon8"></span><h4 class="text8">Proveedor</h4></a></li>
            
            <li><a href="registro_proveedor.php"><span class="lnr lnr-plus-circle icon9"></span><h4 class="text9">Registro Proveedor</h4></a></li>
            
            
            
        </div>
        
       