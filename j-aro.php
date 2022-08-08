<?php
///////////////////////////////////////////////////////////////////////////////////////////////////
///    DESARROLLADO POR WWW.RBWEB.CL / FRANCISCO RIVAS R.                                       ///
///////////////////////////////////////////////////////////////////////////////////////////////////
session_start();
require('funciones/conexion.php');
require('funciones/funciones.php');


$secc 	= trim($_POST['sec']);
$secc2 	= trim($_POST['sec2']);
	   

$buscador_motor		= $mysqli->query("
SELECT * FROM (
    SELECT DISTINCT aro FROM productos WHERE n_ancho='".$secc."' AND n_perfil='".$secc2."' AND activo=1 AND stock=1 
    UNION ALL
    SELECT DISTINCT aro FROM productos2 WHERE n_ancho='".$secc."' AND n_perfil='".$secc2."' AND activo=1 AND stock=1
    
    ) AS tabla158
ORDER BY aro
");
$buscador_motorT	= $buscador_motor->num_rows;
							  
if($buscador_motorT >0){
								  
	echo '<select name="form_aro" class="form-control" id="busca_aro" required>';
	
	echo '<option value="">ARO</option>';
	
	while($buscador_motorR = $buscador_motor->fetch_assoc()){									  
		echo '<option value="'.$buscador_motorR['aro'].'">'.$buscador_motorR['aro'].'</option>';
	}
								  
	echo '</select>';
								  
}
	 
?>