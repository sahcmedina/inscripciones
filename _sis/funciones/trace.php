<?php
include('/conexion_trace.php');
include('/conexion_trace_pdo.php');
class Trace {

	function gets_next_id(){				
		include('conexion_trace.php');		
		$datos = array();
	    $query_= "SELECT max(id) as id FROM trace ";	
		$result= mysqli_query($conexion, $query_);
		if (!$result) {
		    return 1;
		}else{
			$fila= mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			return ($fila['id'] + 1);
		}
	}
	function add_($accion, $tabla, $funcion, $usuario){
		include('/conexion_trace.php');
		$fecha = Date('Y-m-d');
		$hora  = Date('h:i:s');
		$id    = $this->gets_next_id();
		$query_= " INSERT INTO trace (id, fecha, hs, accion, tabla, fk_funcion, fk_user)
		           VALUES ('$id','$fecha','$hora','$accion','$tabla','$funcion','$usuario')";	
		$result= mysqli_query($conexion, $query_);
		return 1;
	}
	
	function gets_next_id_abm(){				
		include('conexion_trace.php');	
	    $query_= "SELECT max(id) as id FROM trace_abm ";	
		$result= mysqli_query($conexion, $query_);
		if (!$result) {
		    return 1;
		}else{
			$fila= mysqli_fetch_assoc($result);
			return ($fila['id'] + 1);
		}
	}
	function add_abm($accion, $desc, $funcion, $reg, $usuario){
		include('/conexion_trace_pdo.php');
		$fecha = Date('Y-m-d');
		$hora  = Date('h:i:s');
		$query = " INSERT INTO trace_abm (fecha, hs, accion, descrip, fk_funcion, reg, fk_user) 
		           VALUES (:fecha, :hs, :accion, :descrip, :fk_funcion, :reg, :fk_user) ";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fecha'     , $fecha);
			$sql->bindParam(':hs'        , $hora);
			$sql->bindParam(':accion'    , $accion);
			$sql->bindParam(':descrip'   , $desc);
			$sql->bindParam(':fk_funcion', $funcion);
			$sql->bindParam(':reg'       , $reg);
			$sql->bindParam(':fk_user'   , $usuario);
			$res = $sql->execute();
			$sql = null;
			if($res)	return true;
			else		return false;					
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
}
?>