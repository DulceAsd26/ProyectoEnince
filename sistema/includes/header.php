<?php 

	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}
 ?>
	<header>
		<div class="header">
			
			<h1>Sistema Facturación</h1>
			<div class="optionsBar">
				<p>México, <?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['user'].' -'.$_SESSION['rol']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
        
	</header>

    <div class="modal">
        <div class="bodyModal">
            <form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">
                <h1>Agregar Producto</h1>
                <h2 class="nameProducto">Monitor</h2>
                <input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del producto" required><br>
                <input type="text" name="precio" id="txtPrecio" placeholder="Precio del producto" required>
                <input type="hidden" name="producto_id" id="producto_id" required>
                <input type="hidden" name="action" value="addProduct" required>
                <div class="alert alertAddProduct"></div>
                <button type="submit" class="btn_new">Agregar</button>
                <a href="#" class="btn_ok closeModal" onclick="coloseModal();">Cerrar</a>
            </form>
        </div>
    </div>