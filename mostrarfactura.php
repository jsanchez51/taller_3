<?php

include_once 'conexion.php';



// echo $idFactura;
// echo $resultado[0];
// var_dump($resultado);
//agregar
if($_POST){
    
    $idFactura= $_POST['id'];
//echo 'archivo index';
$leer = "SELECT a.id as id_compra,a.id_cliente,b.id,a.fecha, b.nombre as nombre_cliente,b.apellido,b.cedula FROM compra as a inner join cliente as b where a.id_cliente=b.id and  a.id='$idFactura' ";

$mostrar = $pdo->prepare($leer);
$mostrar->execute();
$dato =$mostrar->fetch();
   // echo $idFactura;
    // $hola2=$_POST['hola2'];
    // $sqlagregar='insert into hola(hola1,hola2) values (?,?)';
    // $sentenciaAgregar= $pdo->prepare($sqlagregar);
   // $sentenciaAgregar->execute(array($hola1,$hola2));
   
 //   header('location:index.php');
 //   echo 'Agregar';
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

$acu=0;
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
				   <li><a href="index.php"><span>Facturas</span></a></li>
				   <li><a href="crearfactura.php"><span>Nueva Factura</span></a></li>
				  <div class="limpiar"></div>
			   </ul> 
	       </div>
	  </div>
   </div>


  <div class="Principal">
	 <div class="envolver">
		<div class="contenido-boton">
			 
		    <div class="seccion group">

          <div class="factura">
               <div class="lista_factura"  id="accfact" >
			   		<form method="POST" action="modificarfactura.php">
                       <h3><a id="TituloFactura" href="Vista/MGIFactura.html"</a>Factura Nro. <?php echo $idFactura?></a></h3><br>                       
                        <hr class="hr">
                         </br>
						 
							 <div id="fac" >
							<label >Fecha: <?php echo $dato['fecha']?> </label></br>
							
							<label>Nombre: <?php echo $dato['nombre_cliente']?> </label></br>
							<label>Cedula: <?php echo $dato['cedula']?> </label></br>
							
							</br><h3><a id="Productos" href="Vista/Productos.html"</a>Produto(s)</a></h3>
						
                      <?php 
                        $leer2="SELECT  DISTINCT (e.id_servicio),  e.iva,e.cantidad,f.nombre,f.precio,e.id_servicio,f.id,e.id_compra from items as e inner join servicio as f inner join compra as g where e.id_servicio=f.id and e.id_compra={$dato['id_compra']} group by e.id_servicio" ;
                        $mostrar2 = $pdo->prepare($leer2);
                    	 $mostrar2->execute(); 
                         $resultado2 =$mostrar2->fetchALL(); ?>
                        
                        <?php foreach($resultado2 as $dato2):?>
                       
                          <label></label>
						  
							<label >Nombre: <?php echo $dato2['nombre']?> &nbsp;Precio: <?php echo $dato2['precio']?> &nbsp;IVA: <?php echo $dato2['iva']?> &nbsp;Cantidad: <?php echo $dato2['cantidad']?>  </label> </br>
							
						
					        
							<?php $acu=$acu+ (($dato2['iva']+$dato2['precio'])*$dato2['cantidad']);?>
							
						<?php endforeach ?>  

							</br><label>TOTAL: <?php echo $acu?> </label></br>
							
                            </div>
                            <input type="hidden" name= "id" value="<?php echo $idFactura?>">
                             <input type="hidden" name= "idmodificar" value="0">
							<button class="btn btn-primary mt-3">MODIFICAR</button>
							</form> 
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
