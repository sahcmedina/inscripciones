<?php
date_default_timezone_set('America/Argentina/San_Juan');
class Productos {	         

	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT r.* FROM eventos_ronda_neg_productos r ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function tf_existe_nombre($nombre){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM eventos_ronda_neg_productos WHERE nombre = :nombre "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':nombre', $nombre);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}

	function add($user, $nombre){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$nada = '0000-00-00 00:00:00';
		$query= "INSERT INTO eventos_ronda_neg_productos (nombre, f_create, f_update, fk_user) 
		         VALUES (:nombre, :f_create, :f_update, :fk_user)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':nombre', 	    $nombre);
			$sql->bindParam(':f_create', 	$hoy);
			$sql->bindParam(':f_update',    $nada);
			$sql->bindParam(':fk_user',     $user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM eventos_ronda_neg_productos WHERE id= :id "; 
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

	function upd($id, $user, $nombre){
		include('conexion_pdo.php');		
		$hoy     = Date('Y-m-d H:i:s');		
		$query_  = " UPDATE eventos_ronda_neg_productos SET nombre = :nombre, f_update= :f_update, fk_user= :fk_user
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',      $id);			
			$sql->bindParam(':fk_user', $user);			
			$sql->bindParam(':f_update',$hoy);			
			$sql->bindParam(':nombre',  $nombre);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
}
?>