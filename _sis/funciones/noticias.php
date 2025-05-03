<?php

class Noticias {
	         
	function gets_ult10(){
		include('conexion_pdo.php');
		$query_= "  SELECT n.* FROM noticia AS n ORDER BY id desc LIMIT 10";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}	
	function gets_all_news(){
		include('conexion_pdo.php');
		$query_= "  SELECT n.* FROM noticia AS n ORDER BY id ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_noticia($id){
		include('conexion_pdo.php');
		$query_= "  SELECT n.* FROM noticia AS n WHERE id= :id";
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
	
	function add_noticia($titulo, $descripcion, $contenido, $url_tmp, $f_subido, $usuario){
		include('conexion_pdo.php');
		$query= "INSERT INTO noticia (titulo, descripcion, contenido, url, f_subido, fk_usuario) VALUES (:titulo, :descripcion, :contenido, :url, :f_subido, :usuario)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':titulo', $titulo);
			$sql->bindParam(':descripcion', $descripcion);
			$sql->bindParam(':contenido', $contenido);
			$sql->bindParam(':url', $url_tmp);
			$sql->bindParam(':f_subido', $f_subido);
			$sql->bindParam(':usuario', $usuario);
			$sql->execute();
			return 1;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function ultimo_id_insertado(){
		include('conexion_pdo.php');				
		$query_ = " SELECT MAX(id) as id FROM noticia "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['id'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_noticia_imagen($ult_id, $str_nombre){
		include('conexion_pdo.php');				
		$query_ = " UPDATE noticia SET url = :url WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $ult_id);
			$sql->bindParam(':url', $str_nombre);
			$sql->execute();
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	                     
	function upd_noticia($id, $titulo, $descripcion, $url, $contenido, $f_subido, $usuario){
		include('conexion_pdo.php');				
		$query_ = " UPDATE noticia SET titulo = :titulo, descripcion = :descripcion, contenido = :contenido, url = :url, f_subido = :f_subido, fk_usuario = :fk_usuario  WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->bindParam(':titulo', $titulo);
			$sql->bindParam(':descripcion', $descripcion);
			$sql->bindParam(':url', $url);
			$sql->bindParam(':contenido', $contenido);
			$sql->bindParam(':f_subido', $f_subido);
			$sql->bindParam(':fk_usuario', $usuario);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

//---------------------------------------------- PRUEBA DE IDIOMA -------------------------
         //idioma_espaniol
function idioma_espaniol(){
	include('conexion_pdo.php');				
	$query_ = "SELECT id, valor FROM idioma_es "; 
	try{
		$sql = $con->prepare($query_);
		$sql->execute();
		$res = $sql->fetchAll();
		return $res;
	}
	catch (Exception $e){ echo $e->getMessage(); 		}
	finally{				$sql = null;				}
}

function idioma_ingles(){
	include('conexion_pdo.php');				
	$query_ = "SELECT id, valor FROM idioma_en "; 
	try{
		$sql = $con->prepare($query_);
		$sql->execute();
		$res = $sql->fetchAll();
		return $res;
	}
	catch (Exception $e){ echo $e->getMessage(); 		}
	finally{				$sql = null;				}
}
//---------------------------------------------- FIN PRUEBA DE IDIOMA -------------------------



}
?>