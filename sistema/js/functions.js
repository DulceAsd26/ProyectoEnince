$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

    });
    
    //Modal form add product
   $('.add_product').click(function(e){
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';
         $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: {action:action,producto:producto},
        success: function(response){
            if(response != 'error'){
                var info = JSON.parse(response);
                //var info = JSON.parse(JSON.stringify(response));
                $('#producto_id').val(info.codproducto);
                $('.nameProducto').html(info.descripcion);
            }
        },
        error: function(error){
            console.log(error);
        }
        });
    $('.modal').fadeIn();        
    }); 
    
    
    
    $('search_proveedor').change(function(e){
        e.preventDefault();
        var sistema = getUrl();
        location.href = sistema+'buscar_producto.php?proveedor='+$(this).val();
    })
    
    
    $('nit_cliente').keyup(function(e){
    e.preventDefault();
    
    var cl = $(this).val();
    var action = 'searchCliente'

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,cliente:cl},

        seccess: function(response)
        {
            console.log(response);
        },
        error: function(error) {

        }
    });

     /*Crear Cliente - Ventas*/
    $('#form_new_cliente_venta').submit(function(e){
        e.preventDefault();

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async : true,
                data: $('#form_new_cliente_venta').serialize(),

                success: function(response)
                {
                    if(response != 'error'){
                        //Agregar id input hidden 
                        $('#idcliente').val(response);                    
                        //Bloque campos                       
                        $('#nom_cliente').attr('disabled','disabled');                        
                        $('#tel_cliente').attr('disabled','disabled');
                        $('#dir_cliente').attr('disabled', 'disabled');
                        //culta boton agregar
                        $('.btn_new_cliente').slideUp();
                        
                        //Oculta boton guardar 
                        $('#div_registro_cliente').slideUp();
                        
                     }
                },
                error: function(error) {
                {
                }}

    
});
 
// Buscar Producto
$('#txt_cod_producto').keyup(function(e){ 
    e.preventDefault();

    var producto = $(this).val();
    var action = 'infoProducto';
    
    if(producto != ''){
        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action, producto:producto},
        
            success: function(response)
            {

                if(response != 'error')
                {
                    var info = JSON.parse(response);
                    $('#txt_descripcion').html(info.descripcion);
                    $('#txt_existencia').html(info.existencia);
                    $('#txt_cant_producto').val('1'); 
                    $('#txt_precio').html(info.precio);
                    $('#txt_precio_total').html(info.precio);

                    //Activar Cantidad
                    $('#txt_cant_producto').removeAttr('disabled');

                    //Mostrar botón agregar
                    $('#add_product_venta').slideDown ();
                }else{
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').val('0');
                    $('#txt_precio').html('0.00'); 
                    $('#txt_precio total').html('0.00');
                    //Bloquear Cantidad
                    $('#txt_cant_producto').attr('disabled', 'disabled');
                   
                    //Ocultar boton agregar
                    $('#add_product_venta').slideUp();
                    }
                     
        },
        error: function(error){
        }
    });

    }
     // Validar Cantidad del producto antes de agregar
    $('#txt_cant_producto').keyup(function(e) {
         e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_exitencia').html()); 
        $('#txt_precio_total').html(precio_total);
    
    //Oculta-el- boton agregar si la cantidad es menor que 1
        if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia) ){ 
            $('#add_product_venta').slideUp();
        }else{
            $('#add_product_venta').slideDown ();
        }
});

    //Agregar producto al detalle
    $('#add product_venta').click(function(e) {
    e.preventDefault();
        if($('#txt_cant_producto').val() > 0) 
        {
        var codproducto = $('#txt_cod_producto').val(); 
        var cantidad = $('#txt_cant_producto').val();
        var action = 'add Product Detail';

        $.ajax({

        url : 'ajax.php',
        type: "POST",
        async : true,
        data: {action:action, producto:codproducto, cantidad:cantidad},

        success: function(response)
        {
            if(response != 'error'){
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);
                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');
                //Bloquear Cantidad
                $('#txt_cant_producto').attr('disabled', 'disabled');
                //Ocultar boton agregar
                $('#add_product_venta').slideUp(); 
            }
            else{
                console.log('no data');
            }
        },
        error: function(error) {
        }
        });
        }

    });
    
    
    
}); 


function getUrl(){
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/')+ 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}


function sendDataProduct(){
    $('.alertAddProduct').html(''); 
    $.ajax({
            url:'ajax.php',
            type:'POST',
            async: true,
            data: $('#form_add_product').serialize(),
        success: function(response){
            console.log(response);
        },
        error: function(error){
            console.log(error);
        }
        });
}   
function coloseModal(){
    $('.alertAddProduct').html('');
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('.modal').fadeOut();
}

        
function del_product_detalle(correlativo){ 
    var action = 'delProductoDetalle';
    var id_detalle = correlativo;

    $.ajax({
        url : 'ajax.php',
        type: "POST",
        async : true,
        data: {action:action,id_detalle:id_detalle},

        success: function(response){
        console.log(response);
    },

error: function(error) {
}
    });

    function serchForDetalle(id){ 
        var action = 'serchForDetalle';
        var user = id;
    
        $.ajax({
            url : 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action,user:user},
    
            success: function(response){
            if(response != 'error'){
    
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);
            }else{
            console.log('no data');
            }
    
    },
    
    error: function(error) {
    }
        });

        //Mostrar/Ocultar boton procesar
        function viewProcesar(){
            if($('#detalle_venta tr').length > 0) { 
                 $("#btn_facturar_venta").show();
        }else{
            $("#btn_facturar_venta").hide();
         }
        }

    //Activa campos para registrar cliente 
    $('.btn_new_cliente').click(function(e){
        e.preventDefault();
        $('#nom_cliente').removeAttr('disabled');
        $('#tel_cliente').removeAttr('disabled'); 
        $('#dir_cliente').removeAttr('disabled');
        $('#div_registro_cliente').slideDown();

});