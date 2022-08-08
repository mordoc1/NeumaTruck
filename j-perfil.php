<?php
///////////////////////////////////////////////////////////////////////////////////////////////////
///    DESARROLLADO POR WWW.RBWEB.CL / FRANCISCO RIVAS R.                                       ///
///////////////////////////////////////////////////////////////////////////////////////////////////
session_start();
require('funciones/conexion.php');
require('funciones/funciones.php');

$secc = trim($_POST['sec']);	 
	   
$buscador_modelo		= $mysqli->query("
SELECT * FROM (
    SELECT DISTINCT n_perfil FROM productos WHERE n_ancho='".$secc."' AND activo=1 AND stock=1 
    UNION ALL
    SELECT DISTINCT n_perfil FROM productos2 WHERE n_ancho='".$secc."' AND activo=1 AND stock=1 
    ) AS tablaperfil

ORDER BY n_perfil ASC");
$buscador_modeloT		= $buscador_modelo->num_rows;
							  
if($buscador_modeloT >0){
								  
	echo '<select id="busca_perfil" name="form_perfil" class="form-control" required >';
	echo '<option value="">PERFIL</option>';
								  
	while($buscador_modeloR = $buscador_modelo->fetch_assoc()){									  
		echo '<option value="'.$buscador_modeloR['n_perfil'].'">'.$buscador_modeloR['n_perfil'].'</option>';
	}
								  
	echo '</select>';
								  
}
	 
?>