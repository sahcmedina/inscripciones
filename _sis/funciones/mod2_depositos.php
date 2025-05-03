<?php

class Depositos {
	
	function gets(){
		include('conexion_pdo.php');		
		$query_  = " SELECT d.*, p.nombre as prov 
		             FROM depositos d INNER JOIN provincia p ON d.fk_provincia = p.id "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	
	function get_nombre($id){
		include('conexion_pdo.php');		
		$query_  = " SELECT codigo FROM depositos WHERE id= :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['codigo'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}

	function del_deposito($id){ 
		include('conexion_pdo.php');				
		$query_  = "DELETE FROM depositos WHERE id= :id ";	
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
	
	function add_deposito($codigo, $prov, $dir, $tel, $fk_user){
		include('conexion_pdo.php');
		$f       = Date('Y-m-d H:i:s');
		$f_      = '0000-00-00 00:00:00';
		$query_  = " INSERT INTO depositos (codigo, fk_provincia, tel, domicilio, f_create, f_update, fk_usuario)
		             VALUE (:codigo, :fk_prov, :tel, :dom, :f_cre, :f_upd, :fk_user)";	
		try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':codigo',    	$codigo);			
			$sql->bindParam(':fk_prov',     $prov);			
			$sql->bindParam(':tel', 		$tel);			
			$sql->bindParam(':dom',     	$dir);
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

	function upd_deposito($id, $cod, $prov, $dir, $tel, $user){
		include('conexion_pdo.php');				
		$query_  = " UPDATE depositos 
		             SET codigo = :cod, fk_provincia= :pro, domicilio= :dom, tel= :tel, fk_usuario= :user
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',   $id);
			$sql->bindParam(':cod',  $cod);			
			$sql->bindParam(':pro',  $prov);			
			$sql->bindParam(':tel',  $tel);			
			$sql->bindParam(':dom',  $dir);			
			$sql->bindParam(':user', $user);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function tf_existe_dep($codigo){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM depositos WHERE codigo= :codigo "; 
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

}
?>