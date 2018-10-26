<?php

include_once 'conexion.php';


//agregar
if($_POST){
    if($_POST['idmodificar']){
        
            $pdo->beginTransaction();
            try {

                    $nombre= $_POST['nombre'];
                    $cedula=$_POST['cedula'];
                    $cedula= (string) $cedula;
                    $id_cliente= $_POST['id_cliente'];
                    $id_cliente= (string) $id_cliente;
                    $iva= $_POST['iva'];
                    $cantidad=$_POST['cantidad'];
                    $id=$_POST['id'];
                
                    $idfactura=$_POST['idfactura'];
                    

                    $Band=false;
                    $Band2=true;
    
                        foreach( $cantidad as $n ) {
                            if($n>0){
                                $Band=true;
                                break;
                            }  
                        }
     
                    if($Band){
                    
                            $sqlagregar="update cliente set  nombre='".$nombre."',cedula='".$cedula."'  where id= '".$id_cliente."' ";
                            $sentenciaAgregar= $pdo->prepare($sqlagregar);
                                
                                    if($sentenciaAgregar->execute()){
                                        // $leercliente="SELECT id FROM cliente where id= $cedula";
                                   
                                        // $mostrarcliente = $pdo->prepare($leercliente);
                                        // $mostrarcliente->execute();
                                        // $resultadocliente =$mostrarcliente->fetch();
                                        
                                        $sqlagregar3="update compra set  fecha= (?) where id=(?) ";
                                        // $sqlagregar3='insert into compra(fecha,estatus) values (?,?,?)';
                                        $sentenciaAgregar3= $pdo->prepare($sqlagregar3);
                                    

                                            if($sentenciaAgregar3->execute(array(date('Y-m-d'), $idfactura))){
                                
                                                    foreach( $cantidad as $key => $n ) {
                                        
                                                        if($n>0){
                                                            $sqlagregar2="update items set  iva=(?),cantidad = (?) where id_compra=(?) ";
                        
                                                        $sentenciaAgregar2= $pdo->prepare($sqlagregar2);
                                                        $sentenciaAgregar2->execute(array($iva[$key] ,$n,$idfactura));
                                                        
                                                        } 
                                                    }

                                            }else{
                                            
                                                    echo "Error al Actualizar en la tabla compra.";
                                                    $Band2=false;
                                                }
                                   }else{
                                    echo "Error al actualizar.";
                                    $Band2=false;
                                  } 
                                                 
                            }
            
            $pdo->commit(); 
                if($Band2){
                echo 'Datos insertados';
                echo "<script language='javascript'>window.location='index.php'</script>;";
           // echo header("Location: index.php");
                }         

            } catch (Exception $e) {
                $pdo->rollback(); 

                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }
            
   
              

        }else{
             //echo "entroo";
            $idFactura= $_POST['id'];
            //  echo $idFactura;
            //echo 'archivo index';
            $leer = "SELECT a.id as id_compra,a.id_cliente,b.id as id_cliente,a.fecha, b.nombre as nombre_cliente,b.apellido,b.cedula FROM compra as a inner join cliente as b where a.id_cliente=b.id and  a.id=(?) ";
            
            $mostrar = $pdo->prepare($leer);
            $mostrar->execute(array($idFactura));
            $dato =$mostrar->fetchALL();
            //  echo $dato['nombre_cliente'];
            //   var_dump($dato);
        }

}

if($_GET){
// $id=$_GET['id'];
// $sqlUnico = 'SELECT * FROM hola where id=?';
// $mostrar_unico = $pdo->prepare($sqlUnico);
// $mostrar_unico->execute(array($id));
// $resultado_unico =$mostrar_unico->fetch();

//var_dump()
}
//var_dump($resultado);
?>



<!doctype html>
<html lang="en">

	<head>
<title>Servicio y mantenimiento de lanchas</title>
<link href="style.css" rel="stylesheet" type="text/css" media="all">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>

<body>
<div class="Cabecera">
  <div class="envolver"> 
	<div class="encabezado">
		 <div class="logo">
			 <h1><a href="index.html">Servicio y mantenimiento de lanchas</a></h1>
			 <p>Version 1.0</p>
		 </div>
		 <div class="limpiar"></div> 
	   </div>
   </div>	
</div>
 
   <div class="sobre-banner">
      <div class="envolver">
		   <div class="cssmenu">
				<ul>
				 
				   <li><a href="Vista/Productos.html"><span>Productos</span></a></li>
				   <li><a href="index.php"><span>Facturacion</span></a></li>
				
				  <div class="limpiar"></div>
			   </ul> 
	       </div>
	  </div>
   </div>


  <div class="Principal">
	 <div class="envolver">
		<div class="contenido-boton">
			 <div class="caja-superior">
				<h2>Modificar Factura:</h2>
				<hr>
				<p></p>
			 </div>
             
		 
		    <div class="seccion group">
                 

          <div class="factura">
               <div class="lista_factura">
             
							 <div id="fac" >
                             <?php 
                            //  echo $idFactura;
                            //  echo $_POST['id'];
                         $leer2="SELECT  s.id,s.nombre,s.precio,i.iva,i.cantidad from servicio as s inner join items as i where  i.id_servicio=s.id and i.id_compra=(?)" ;
                        // $leer2="SELECT  id,nombre,precio from servicio " ;
                       
                        $mostrar2 = $pdo->prepare($leer2);
                        $mostrar2->execute(array($idFactura)); 
                        $resultado2 =$mostrar2->fetchALL();
                        // var_dump($resultado2);
                            ?>

                             <form method="POST" action="modificarfactura.php">
                             <label>Fecha:</label>
                             <input name="fecha" disabled=true  type="text" id="date" value="<?php echo date("m/d/Y"); ?>" size="10"/></br>
							
                         <label>&nbsp;&nbsp;Nombre:</label>
							<input type="text"  required class="form-control" value= <?php echo $dato[0]['nombre_cliente']; ?>  name="nombre" ></br>
                         <label>&nbsp;&nbsp;&nbsp;Cedula:</label>
                            <input type="text"  required class="form-control"  value=<?php echo $dato[0]['cedula']; ?> name="cedula" ></br>
                            </br><h3><a id="Productos" href="Vista/Productos.html"</a>Produto(s)</a></h3>
                            <?php foreach($resultado2 as $dato2):?>

                            <label>&nbsp;&nbsp;Nombre:</label>
							<input type="text" placeholder=<?php echo $dato2['nombre']?>  required class="form-control" disabled=true  ></br>
                            
                            <label>&nbsp;&nbsp;&nbsp;Precio:&nbsp;</label>
                            <input type="text" placeholder=<?php echo $dato2['precio']?>   required class="form-control" disabled=true  ></br>

                            <label>&nbsp;&nbsp;Iva:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<input type="text" value=<?php echo $dato2['iva'] ?> required class="form-control" name= "iva[]" ></br>
                            
                            <label>Cantidad:</label>
                            <input type="text" value=<?php echo $dato2['cantidad'] ?>   required class="form-control" name= "cantidad[]" ></br></br>
                       

                            <input type="hidden" name= "id[]" value="<?php echo $dato2['id'] ?>">
                                                    
                            <?php endforeach ?>  
                            <input type="hidden" name= "idmodificar" value="1">
                            <input type="hidden" name= "idfactura" value="<?php echo $idFactura ?>">
                    <input type="hidden" name= "id_cliente" value="<?php echo $dato[0]['id_cliente'] ?> ">
                            <button class="btn btn-primary mt-3">GUARDAR</button>
                            </form>                       
                         
							</div>
						  
                </div>
            </div>                       
			
					


				
	
				
				
				
				<div class="limpiar"></div>
			</div>
		</div>
	  </div>
   </div>
	
	<div class="footer">
		<div class="envolver">
			<div class="texto-pie-pagina">
				<div class="copia">
					<p> &#169; 2018 Todos los derechos reservados</p>
				</div>
			</div>	
		</div>
	</div>

</body>
</html>

