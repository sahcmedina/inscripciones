<?php

class Materiales {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM material ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function tf_existe_codigo($codigo){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM material WHERE codigo = :codigo "; 
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

	function add_material($codigo, $nombre, $cant_min, $unidad_medida, $cant_scrap, $f_create, $f_update){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO material (codigo, nombre, cant_min, unidad_medida, cant_min_scrap, f_create, f_update) 
		         VALUES (:codigo, :nombre, :cant_min, :unidad_medida, :cant_min_scrap, :f_create, :f_update)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':codigo', 		   $codigo);
			$sql->bindParam(':nombre', 		   $nombre);
			$sql->bindParam(':cant_min', 	   $cant_min);
			$sql->bindParam(':unidad_medida',  $unidad_medida);
			$sql->bindParam(':cant_min_scrap', $cant_scrap);
			$sql->bindParam(':f_create', 	   $f_create);
			$sql->bindParam(':f_update',       $f_update);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del_material($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM material WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function upd_material($id, $codigo, $nombre, $cant_min, $unidad_medida, $cant_scrap, $f_create, $f_update){
		include('conexion_pdo.php');				
		$query_  = " UPDATE material SET 
							codigo =:codigo,
							nombre   =:nombre, 
							cant_min = :cant_min,
							unidad_medida = :unidad_medida,
							cant_min_scrap  = :cant_min_scrap,
							f_create  = :f_create,
							f_update = :f_update
					 WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':codigo', $codigo);
			$sql->bindParam(':nombre', $nombre);
			$sql->bindParam(':cant_min', $cant_min);
			$sql->bindParam(':unidad_medida', $unidad_medida);
			$sql->bindParam(':cant_min_scrap', $cant_scrap);
			$sql->bindParam(':f_create', $f_create);
			$sql->bindParam(':f_update', $f_update);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

}
?>