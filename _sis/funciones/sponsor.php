<?php

class Sponsor {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_sponsor order by id DESC ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}	

	function get_ultimo_id_insert(){
		include('conexion_pdo.php');				
		$query_  = " SELECT MAX(id) as id FROM web_sponsor "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['id'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function add($empresa, $url, $img_temp, $categoria, $comentario, $mostrar_web, $titulo_es, $titulo_in, $subtitulo_es, $subtitulo_in){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO web_sponsor (nombre, imagen, url, categoria, comentario, mostrar_web, titulo_es, titulo_in, subtitulo_es, subtitulo_in) 
		         VALUES (:nombre, :imagen, :url, :categoria, :comentario, :mostrar_web, :titulo_es, :titulo_in, :subtitulo_es, :subtitulo_in)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':nombre', $empresa);
			$sql->bindParam(':imagen', $img_temp);
			$sql->bindParam(':url',    $url);
			$sql->bindParam(':categoria', $categoria);
			$sql->bindParam(':comentario',    $comentario);
			$sql->bindParam(':mostrar_web',    $mostrar_web);
			$sql->bindParam(':titulo_es',    $titulo_es);
			$sql->bindParam(':titulo_in', $titulo_in);
			$sql->bindParam(':subtitulo_es',    $subtitulo_es);
			$sql->bindParam(':subtitulo_in',    $subtitulo_in);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_imagen($ult_id, $str_nombre){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_sponsor SET imagen = :imagen WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $ult_id);
			$sql->bindParam(':imagen', $str_nombre);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function get_logo_de_una_empresa($id){
		include('conexion_pdo.php');
		$query_= " SELECT imagen FROM web_sponsor WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['imagen'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_sponsor($id, $nombre, $url, $str_nombre, $categoria, $comentario, $titulo_es, $titulo_in, $subtitulo_es, $subtitulo_in){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_sponsor SET nombre=:nombre, url=:url, imagen = :imagen, categoria= :categoria, comentario= :comentario,  
											titulo_es= :titulo_es, titulo_in= :titulo_in, subtitulo_es= :subtitulo_es, subtitulo_in= :subtitulo_in
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':nombre', $nombre);
			$sql->bindParam(':url', $url);
			$sql->bindParam(':imagen', $str_nombre);
			$sql->bindParam(':categoria', $categoria);
			$sql->bindParam(':comentario', $comentario);
			$sql->bindParam(':titulo_es',    $titulo_es);
			$sql->bindParam(':titulo_in', $titulo_in);
			$sql->bindParam(':subtitulo_es',    $subtitulo_es);
			$sql->bindParam(':subtitulo_in',    $subtitulo_in);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del_sponsor($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM web_sponsor WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function view_sponsor_en_la_web($id, $mostrar_web){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_sponsor SET mostrar_web=:mostrar_web WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':mostrar_web', $mostrar_web);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

}
?>