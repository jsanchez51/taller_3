<?php
try{
    $pdo=new PDO('mysql:host=localhost;dbname=id7342699_factura','id7342699_jsanchez51','24569851');
 //  echo 'Conectado';
//    foreach($pdo->query('SELECT * FROM `hola`') as $fila)
//    {
//     print_r($fila);
//    }
}catch(PDOException $e){
    print "ERROR: " .$e->getMessege(). "<br/>";
    die();
}
?>
