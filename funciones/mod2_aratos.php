<?php

class Aratos {
	
	function gets(){
		include('conexion_pdo.php');		
		$query_  = " SELECT a.*, d.codigo as nom_dep FROM aratos a INNER JOIN depositos d ON d.id=a.fk_deposito WHERE a.estado = 1 "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets_segun_dep($id_dep){
		include('conexion_pdo.php');		
		$query_  = " SELECT a.*, d.codigo as nom_dep FROM aratos a INNER JOIN depositos d ON d.id=a.fk_deposito 
		             WHERE a.fk_deposito= :id_dep AND a.estado = 1 "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_dep', $id_dep);					
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	

	function get_cant_segun_dep($id_dep){
		include('conexion_pdo.php');		
		$query_  = " SELECT COUNT(*) as cant FROM aratos a WHERE a.fk_deposito= :id_dep AND a.estado = 1 "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_dep', $id_dep);					
			$sql->execute();
			$res = $sql->fetch();
			return $res['cant'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function get_nombre($id_arato){
		include('conexion_pdo.php');		
		$query_  = " SELECT a.codigo FROM aratos a WHERE a.id= :id_arato "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_arato', $id_arato);					
			$sql->execute();
			$res = $sql->fetch();
			return $res['codigo'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	
	
	function del($id){ 
		include('conexion_pdo.php');				
		$query_  = "DELETE FROM aratos WHERE id= :id ";	
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
	
	function tf_existe($codigo){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM aratos WHERE codigo= :codigo "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':codigo',   $codigo);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	
	function add($codigo, $fk_deposito, $fk_user, $nom){
		include('conexion_pdo.php');
		$uno     = 1;
		$f       = Date('Y-m-d H:i:s');
		$f_      = '0000-00-00 00:00:00';
		$query_  = " INSERT INTO aratos (codigo, fk_deposito, estado, f_create, f_update, fk_usuario, nombre)
		             VALUE (:codigo, :fk_dep, :est, :f_cre, :f_upd, :fk_user, :nombre)";	
		try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':codigo',    	$codigo);			
			$sql->bindParam(':fk_dep',      $fk_deposito);			
			$sql->bindParam(':est', 		$uno);	
			$sql->bindParam(':f_cre',     	$f);
			$sql->bindParam(':f_upd',     	$f_);
			$sql->bindParam(':fk_user',     $fk_user);
			$sql->bindParam(':nombre',      $nom);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	   }	
		finally{				$sql = null;				}	
	}	

	function upd($id, $cod, $dep, $user, $nombre){
		include('conexion_pdo.php');				
		$query_  = " UPDATE aratos SET codigo = :cod, fk_deposito= :dep, fk_usuario= :user, nombre= :nombre
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->bindParam(':cod',    $cod);			
			$sql->bindParam(':dep',    $dep);			
			$sql->bindParam(':user',   $user);			
			$sql->bindParam(':nombre', $nombre);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_finalizar($id){
		include('conexion_pdo.php');	
		$f       = Date('Y-m-d H:i:s');			
		$query_  = " UPDATE aratos SET estado = 0, f_fin= :f_fin WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);		
			$sql->bindParam(':f_fin',  $f_fin);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

}
?>