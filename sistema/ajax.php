<?php
    
    include "../conexion.php";

    //print_r($_POST);exit;
    
    if(!empty($_POST)){
        
        if($_POST['action'] == 'infoProducto')
        {
            $producto_id = $_POST['producto'];
            $query= mysqli_query($conection, "SELECT codproducto, descripcion FROM producto
                                                WHERE coproducto=$producto_id AND estatus = 1");
            
            mysqli_close($conection);
            $result = mysqli_num_rows($query);
            if($result > 0){
                $data = mysqli_fetch_assoc($query);
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }
            echo 'error';
            exit;
        }
    }

    exit;

 /*buscar cliente*/
    if($_POST['action'] == 'searchCliente')
    {
        if(!empty($_POST['cliente'])){ 
            $nit = $_POST['cliente'];

            $query = mysqli_query($connection, "SELECT * FROM cliente WHERE nit LIKE '$nit' and estatus = 1 "
                );
            mysqli_close($connection);
            $result = mysqli_num_rows($query);

            $data ='';
            if($result > 0){
                $data = mysqli_fetch_assoc($query);
            }else{
                $data = 0;
            }
            echo json_encode ($data, JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    /*Registrar cliente - ventas*/

    if($_POST['action'] == 'addCliente')
    {
        $nit = $_POST['nit_cliente'];
        $nombre = $_POST[ 'nom_cliente'];
        $telefono = $_POST['tel_cliente'];
        $direccion = $_POST['dir_cliente'];
        $usuario_id = $_SESSION( 'idUser'];

        $query_insert = mysqli_query($conection, "INSERT INTO cliente(
                                                    nit, nombre, telefono, direccion, usuario_id) 
                                                VALUES ('$nit', '$nombre', '$telefono', '$direccion', '$ 
                                                usuario_id')");
        if($query_insert){
            $codCliente = mysqli_insert_id($conection);
            $msg = $codCliente;
        }else{
            $msg='error';
        } 
        mysqli_close($conection);
        echo $msg;
        exit;
    }

    //agregar producto al detalle temporal
    if($_POST['action'] == 'addProductoDetalle')    {
        if(empty($_POST['producto']) || empty($_POST['cantidad'])){
            echo 'error';
        }
        else{
            $codproducto = $_POST['producto'];
            $cantidad = $_POST['cantidad'];
            $token = md5($_SESSION[ 'id User']);

            $query Iva = mysqli_query($conection, "SELECT iva FROM configuracion");
            $result iva = mysqli_num_rows ($query_iva);

            $query_detalle_temp = mysqli_query ($connection, "CALL add_detalle_temp($codproducto, $cantidad, 'Stoken')");
            $result mysqli_num_rows ($query detalle_temp);

            $detalleTabla = '';
            $sub_total = 0;
            $iva = 0;
            $total = 0;
            $array Data = array();

            if($result > 0){
                if($result_iva > 0){
                $info_va = mysqli_fetch_assoc($query_iva);
                $iva = $info_va[ 'iva'];
               }
               while ($data mysqli_fetch_assoc($query detalle temp)){               
               $precioTotal = round($data['cantidad'] * $data['precio venta'], 2);               
               $sub_total = round($sub_total + $precioTotal, 2);              
               $total = round($total + $precioTotal, 2);
               
               $detalleTabla = '<tr>     
                                    <td>' .$data['codproducto'].'</td> 
                                    <td colspan="2">' .$data['descripcion'].'</td>               
                                    <td class="textcenter">' .$data['cantidad'].'</td>                                    
                                    <td class="textright">' .$data['precio_venta'].'</td>                            
                                    <td class="text right">'.$precioTotal.'</td>    
                                    <td class="">
                                        <a class="link_delete" href="#" onclick="event.preventDefault();
                                        del_product_detalle('.$data[ 'codproducto'].');"<i class="far
                                        fa-trash-alt"></i></a>
                                    </td>
                                </tr>';
            }
            $impuesto = round($sub_total * ($iva / 100), 2);
            $tl_sniva = round ($subtotal - Impuesto, 2);
            $total = round ($tl_sniva + Simpuesto, 2);

            $detalleTotales ='<tr>
                                    <td colspan="5" class="textright">SUBTOTAL Q.</td>
                                    <td class="textright">' .$tl_sniva. '</td>

                            </tr>
                            <tr>
                                <td colspan="5" class="textright">IVA (' .$iva. '%)</td> 
                                <td class="textright">' .$impuesto. '</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="textright">TOTAL Q.</td>
                                <td class="textright">' .$total. '</td>
                            </tr>';

                $arrayDatal ['detalle'] = $detalleTabla;
                $arrayDatal ['totales'] - $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
    }
   

?>