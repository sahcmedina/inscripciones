<?php
date_default_timezone_set('America/Argentina/San_Juan');

class Eventos {	         

	function gets_activos(){
		include('conexion_pdo.php');
		$hoy     = Date('Y-m-d');
		$query_  = " SELECT e.*, DAY(e.fecha) dia, MONTH(e.fecha) mes, YEAR(e.fecha) anio
		             FROM eventos e 
		             WHERE :hoy >= e.f_inscrip_dsd AND :hoy <= e.f_inscrip_hst ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':hoy', $hoy);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets($id){
		include('conexion_pdo.php');
		$hoy     = Date('Y-m-d');
		$query_  = " SELECT e.* FROM eventos e WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

}
?>