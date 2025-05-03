<?php

class Proveedores {
	
	function gets(){
		include('conexion_pdo.php');		
		$query_  = " SELECT p.* FROM proveedores p WHERE p.estado = 1 "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	
	function del($id){ 
		include('conexion_pdo.php');				
		$query_  = "DELETE FROM proveedores WHERE id= :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	    }
		finally{				$sql = null;				}		
	}
	
	function tf_existe_nombre($nombre){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM proveedores WHERE nombre= :nombre "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':nombre',   $nombre);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	
	function add($nombre, $observacion, $fk_user){
		include('conexion_pdo.php');
		$uno     = 1;
		$f       = Date('Y-m-d H:i:s');
		$f_      = '0000-00-00 00:00:00';
		$query_  = " INSERT INTO proveedores (nombre, estado, f_create, f_update, fk_usuario, observacion)
		             VALUE (:nombre, :est, :f_cre, :f_upd, :fk_user, :observacion)";	
		try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':nombre',    	$nombre);			
			$sql->bindParam(':observacion', $observacion);
			$sql->bindParam(':est', 		$uno);	
			$sql->bindParam(':f_cre',     	$f);
			$sql->bindParam(':f_upd',     	$f_);
			$sql->bindParam(':fk_user',     $fk_user);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	   }	
		finally{				$sql = null;				}	
	}	

	function upd($id, $nombre, $observacion, $user){
		include('conexion_pdo.php');			
		$f       = Date('Y-m-d H:i:s');			
		$query_  = " UPDATE proveedores SET nombre = :nombre, observacion = :observacion, fk_usuario= :user, f_update= :f
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',      $id);
			$sql->bindParam(':nombre',  $nombre);
			$sql->bindParam(':observacion',  $observacion);			
			$sql->bindParam(':f',       $f);			
			$sql->bindParam(':user',    $user);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

}
?>