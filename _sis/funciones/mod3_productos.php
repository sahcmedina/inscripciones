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
	function gets_evento($id_rn){
		include('conexion_pdo.php');
		$query_  = " SELECT p.* 
		             FROM eventos_ronda_neg_productos p INNER JOIN eventos_ronda_neg_productos_select ps ON p.id = ps.id_prod
		             WHERE ps.id_rn= :id_rn ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_rn', $id_rn);
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
		$nada = '1900-01-01 00:00:00';
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

	function del_OLD($id){
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
	function del($id){
		include('conexion_pdo.php');	
		$return  = ['success' => false, 'message' => ''];	

		try {
			$query = "DELETE FROM eventos_ronda_neg_productos WHERE id = :id";
			$sql   = $con->prepare($query);
			$sql->bindParam(':id', $id);
			
			if($sql->execute()) {
				$return['success'] = true;
				$return['message'] = 'ok';
			} else {
				$return['message'] = 'Intente de nuevo.';
			}			
		} 
		catch (PDOException $e) {
			// Código de error para violación de clave foránea (MySQL)
			if($e->errorInfo[1] == 1451) {
				$return['message'] = 'No se puede eliminar el producto porque está siendo utilizado!';
			} else {
				$return['message'] = 'Error inesperado: ' . $e->getMessage();
			}
		} 
		finally {
			$sql = null;
			$con = null;
		}    
    	return $return;
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