<?php

class RondaNegocios {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_ronda_negocio ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}	
	function gets_segun_id($id){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_ronda_negocio where id = :id ";
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

	function upd_ronda_negocios($id, $titulo_es, $titulo_in, $descripcion_es, $descripcion_in, $contenido_es, $contenido_in, $url){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_ronda_negocio SET titulo_es= :titulo_es, titulo_in= :titulo_in, descripcion_es= :descripcion_es, 
							descripcion_in= :descripcion_in, contenido_es= :contenido_es, contenido_in= :contenido_in, imagen= :imagen WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':titulo_es', $titulo_es);
			$sql->bindParam(':titulo_in', $titulo_in);
			$sql->bindParam(':descripcion_es', $descripcion_es);
			$sql->bindParam(':descripcion_in', $descripcion_in);
			$sql->bindParam(':contenido_es', $contenido_es);
			$sql->bindParam(':contenido_in', $contenido_in);
			$sql->bindParam(':imagen', $url);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_imagen($ult_id, $str_nombre){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_ronda_negocio SET imagen = :imagen WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $ult_id);
			$sql->bindParam(':imagen', $str_nombre);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function add_contenido_ronda_negocios($titulo_es, $titulo_in, $descripcion_es, $descripcion_in, $contenido_es, $contenido_in, $url_tmp){
		include('conexion_pdo.php');
		$query_= "INSERT INTO web_ronda_negocio (titulo_es, titulo_in, descripcion_es, descripcion_in, contenido_es, contenido_in, imagen) 
		         VALUES (:titulo_es, :titulo_in, :descripcion_es, :descripcion_in, :contenido_es, :contenido_in, :imagen)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':titulo_es', $titulo_es);
			$sql->bindParam(':titulo_in', $titulo_in);
			$sql->bindParam(':descripcion_es', $descripcion_es);
			$sql->bindParam(':descripcion_in', $descripcion_in);
			$sql->bindParam(':contenido_es', $contenido_es);
			$sql->bindParam(':contenido_in', $contenido_in);
			$sql->bindParam(':imagen', $url_tmp);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	

	function get_ultimo_id_insert(){
		include('conexion_pdo.php');				
		$query_  = " SELECT MAX(id) as id FROM web_ronda_negocio "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['id'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}


}
?>