<?php

include_once 'conexion.php';


//agregar
if($_POST){
    $pdo->beginTransaction();
    try {

    $nombre= $_POST['nombre'];
    $cedula=$_POST['cedula'];

    $iva= $_POST['iva'];
    $cantidad=$_POST['cantidad'];
    $id=$_POST['id'];
    $Band=false;
    $Band2=true;
    
     foreach( $cantidad as $n ) {
        if($n>0){
            $Band=true;
            break;
        }  
    }
     
    if($Band){
       
            $sqlagregar='insert into cliente(nombre,cedula,nacionalidad) values (?,?,?)';
            $sentenciaAgregar= $pdo->prepare($sqlagregar);
                  
                    if($sentenciaAgregar->execute(array($nombre,$cedula,01))){
                        $leercliente='SELECT MAX(id) FROM cliente';
                     }else{
                      
			$leercliente='SELECT id FROM cliente where cedula= '.$cedula.'';
                    } 
                        $mostrarcliente = $pdo->prepare($leercliente);
                        $mostrarcliente->execute();
                        $resultadocliente =$mostrarcliente->fetch();

                    $sqlagregar3='insert into compra(id_cliente,fecha,estatus) values (?,?,?)';
                    $sentenciaAgregar3= $pdo->prepare($sqlagregar3);
                    

                            if($sentenciaAgregar3->execute(array($resultadocliente[0],date('Y-m-d'),1))){
                                $leercompra='SELECT MAX(id) FROM compra';
                                
                           
                            $mostrarcompra = $pdo->prepare($leercompra);
                            $mostrarcompra->execute();
                            $resultadocompra =$mostrarcompra->fetch();
                
                                    foreach( $cantidad as $key => $n ) {
                        
                                        if($n>0){
                                        $sqlagregar2='insert into items(id_servicio,id_compra,iva,cantidad) values (?,?,?,?)';
                                        $sentenciaAgregar2= $pdo->prepare($sqlagregar2);
                                        $sentenciaAgregar2->execute(array($id[$key], $resultadocompra[0],$iva[$key] ,$n));
                                        
                                        } 
                                    }

                            }else{
                               
                                    echo "Error al insertar en la tabla compra.";
                                    $Band2=false;
                                }
                                
    }
    
     $pdo->commit(); 
        if($Band2){
         echo 'Datos insertados';
        }         

    } catch (Exception $e) {
        $pdo->rollback(); 

        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
     
   
 //   header('location:index.php');

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
			 <h1><a href="Vista/productos.html">Servicio y mantenimiento de lanchas</a></h1>
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
				<h2>Nueva Factura:</h2>
				<hr>
				<p></p>
			 </div>
             
		 
		    <div class="seccion group">
                 

          <div class="factura">
               <div class="lista_factura">
             
							 <div id="fac" >
                             <?php 
                        $leer2="SELECT  id,nombre,precio from servicio " ;
                        $mostrar2 = $pdo->prepare($leer2);
                        $mostrar2->execute(); 
                        $resultado2 =$mostrar2->fetchALL();
                            ?>

                             <form method="POST" action="crearfactura.php">
                             <label>Fecha:</label>
                             <input name="fecha" disabled=true  type="text" id="date" value="<?php echo date("m/d/Y"); ?>" size="10"/></br>
							
                         <label>&nbsp;&nbsp;Nombre:</label>
							<input type="text"  required class="form-control" name="nombre" ></br>
                         <label>&nbsp;&nbsp;&nbsp;Cedula:</label>
                            <input type="text"  required class="form-control" name="cedula" ></br>
                            </br><h3><a id="Productos" href="Vista/Productos.html"</a>Produto(s)</a></h3>
                            <?php foreach($resultado2 as $dato2):?>

                            <label>&nbsp;&nbsp;Nombre:</label>
							<input type="text" placeholder=<?php echo $dato2['nombre']?>  required class="form-control" disabled=true  ></br>
                            
                            <label>&nbsp;&nbsp;&nbsp;Precio:&nbsp;</label>
                            <input type="text" placeholder=<?php echo $dato2['precio']?>   required class="form-control" disabled=true  ></br>

                            <label>&nbsp;&nbsp;Iva:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<input type="text" value=0 required class="form-control" name= "iva[]" ></br>
                            
                            <label>Cantidad:</label>
                            <input type="text" value=0   required class="form-control" name= "cantidad[]" ></br></br>
                       

                            <input type="hidden" name= "id[]" value="<?php echo $dato2['id'] ?>">
                                                    
                            <?php endforeach ?>  
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

