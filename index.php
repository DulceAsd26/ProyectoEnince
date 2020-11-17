<?php 
	
$alert = '';
session_start();
if(!empty($_SESSION['active']))
{
	header('location: sistema/');
}else{

	if(!empty($_POST))
	{
		if(empty($_POST['usuario']) || empty($_POST['clave']))
		{
			$alert = 'Ingrese su usuario y su calve';
		}else{

			require_once "conexion.php";

			$user = mysqli_real_escape_string($conection,$_POST['usuario']);
			$pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

			$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario= '$user' AND clave = '$pass'");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);

			if($result > 0)
			{
				$data = mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['idUser'] = $data['idusuario'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['email']  = $data['email'];
				$_SESSION['user']   = $data['usuario'];
				$_SESSION['rol']    = $data['rol'];

				header('location: sistema/');
			}else{
				$alert = 'El usuario o la clave son incorrectos';
				session_destroy();
			}


		}

	}
}
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Login | Sistema Facturación</title>
    <meta name="viewport" content="width-device-width, user-scaleble=no, initial-scale=1.0, maximum-scale=1.0, minimum-sacle=1.0">
    <link rel="stylesheet" href="icon/style.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<section id="container">
        <div class="sec">
            <div class="title">
                <img id="logo" src="sistema/img/logo.png">
                <h1>EMBALAJES INDUSTRIALES ENINCE</h1>
            </div>
            <div class="nosotros">
                    <h3>Nosotros</h3>
                        <p>La empresa Enince surge en el año 2008 dedicandose a la industrialización de madera realizando embalajes para diversas instituciones con el fin de satisfacer necesidades específicas, con altos estándares de calidad y manufacturación.</p> 

                        <p>La rama de moldeables (plásticos) integra al mercado nuevos productos, calidad y precios competitivos. Para la satisfacción de necesidades esenciales.</p>
            
                        <p>Así mismo la trayectoria empresarial es calificada y reconocida entre las mejores opciones regionales e internacionales.</p>
                </div>
        </div>
        <div class="formulario">
		<form action="" method="post">
            
			<h3>Iniciar Sesión</h3>
            <i class="lnr lnr-user"></i>

			<input type="text" name="usuario" placeholder="Usuario">
			<input type="password" name="clave" placeholder="Contraseña">
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <button  type="submit" >INGRESAR</button>

		</form>
        </div>
	</section>
</body>
</html>