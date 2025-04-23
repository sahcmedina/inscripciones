<?php

class Formularios {
	         
	function gets_all_formularios(){
		include('conexion_pdo.php');
		$query_= "  SELECT * FROM formularios  ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function get_estado_actual($id){
		include('conexion_pdo.php');
		$query_= "  SELECT estado_act FROM formularios WHERE id = :id  ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetch();
			return $res['estado_act'];
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM formularios ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function upd_estado($id, $estado_act, $estado_fut, $f_cambio, $f_ultima_mdf, $proceso_realizado, $usuario){
		include('conexion_pdo.php');
		$query_= " UPDATE formularios SET estado_act = :estado_act, estado_fut = :estado_fut, 
		f_cambio = :f_cambio, f_ultima_mdf = :f_ultima_mdf, proceso_realizado = :proceso_realizado, usuario= :usuario WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  	     $id);
			$sql->bindParam(':estado_act',   $estado_act);
			$sql->bindParam(':estado_fut',   $estado_fut);
			$sql->bindParam(':f_cambio',     $f_cambio);
			$sql->bindParam(':f_ultima_mdf', $f_ultima_mdf);
			$sql->bindParam(':proceso_realizado', $proceso_realizado);
			$sql->bindParam(':usuario',      $usuario);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
			catch (Exception $e){	echo $e->getMessage();		}
			finally{				$sql = null;				}
		return $return;
	}
	function upd_estado_retrasado($id, $estado_fut){
		include('conexion_pdo.php');
		$f_ultima_mdf = date("Y-m-d H:i:s");
		$proceso_realizado = 1;
		$query_= " UPDATE formularios SET estado_act = :estado_fut, f_ultima_mdf = :f_ultima_mdf, proceso_realizado = :proceso_realizado WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  	     $id);
			$sql->bindParam(':estado_fut',   $estado_fut);
			$sql->bindParam(':f_ultima_mdf', $f_ultima_mdf);
			$sql->bindParam(':proceso_realizado', $proceso_realizado);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
			catch (Exception $e){	echo $e->getMessage();		}
			finally{				$sql = null;				}
		return $return;
	}
	
	
}
?>