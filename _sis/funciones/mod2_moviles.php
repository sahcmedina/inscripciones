<?php

class Moviles {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT m.*, d.codigo as cod_dep, d.id as id_depo, p.nombre as prov
						FROM moviles m
						INNER JOIN depositos d ON d.id = m.fk_deposito
						INNER JOIN provincia p ON p.id = d.fk_provincia ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_segunDepo($dep){
		include('conexion_pdo.php');
		$query_  = " SELECT m.*, d.codigo as cod_dep, d.id as id_depo, p.nombre as prov
						FROM moviles m
						INNER JOIN depositos d ON d.id = m.fk_deposito
						INNER JOIN provincia p ON p.id = d.fk_provincia 
					WHERE m.fk_deposito= :id_dep";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_dep', $dep);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function tf_existe_codigo($codigo){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM moviles WHERE codigo = :codigo "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':codigo', $codigo);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}

	function add_movil($codigo, $descripcion, $patente, $f_create, $f_update, $obs, $dep){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO moviles (codigo, descripcion, patente, f_create, f_update, obs, fk_deposito) 
		         VALUES (:codigo, :descripcion, :patente, :f_create, :f_update, :obs, :fk_deposito)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':codigo', 		   $codigo);
			$sql->bindParam(':descripcion',    $descripcion);
			$sql->bindParam(':patente', 	   $patente);
			$sql->bindParam(':f_create', 	   $f_create);
			$sql->bindParam(':f_update',       $f_update);
			$sql->bindParam(':obs',            $obs);
			$sql->bindParam(':fk_deposito',    $dep);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del_movil($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM moviles WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function upd_movil($id, $codigo, $descripcion, $patente, $f_create, $f_update, $obs, $dep){
		include('conexion_pdo.php');				
		$query_  = " UPDATE moviles SET 
							codigo =:codigo,
							descripcion   =:descripcion, 
							patente = :patente,
							f_create  = :f_create,
							f_update = :f_update,
							obs = :obs,
							fk_deposito = :dep
					 WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', 			$id);
			$sql->bindParam(':codigo', 		$codigo);
			$sql->bindParam(':descripcion', $descripcion);
			$sql->bindParam(':patente', 	$patente);
			$sql->bindParam(':f_create', 	$f_create);
			$sql->bindParam(':f_update', 	$f_update);			
			$sql->bindParam(':obs', 		$obs);			
			$sql->bindParam(':dep', 		$dep);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

}
?>