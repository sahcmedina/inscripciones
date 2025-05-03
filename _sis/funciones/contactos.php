<?php

class Contacto {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_contacto order by id DESC ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_mostrar_en($donde){
		include('conexion_pdo.php');
		switch($donde){
			case 'argo':		$col= 'mostrar_argoliva'; 		break;
			case 'con_int':		$col= 'mostrar_concurso'; 		break;
			case 'con_nac':		$col= 'mostrar_concurso_nac'; 	break;
			case 'ronda':		$col= 'mostrar_rondas'; 		break;
			case 'jornada':		$col= 'mostrar_jornadas'; 		break;
			case 'chef':		$col= 'mostrar_chefs'; 			break;
			case 'expo':		$col= 'mostrar_expo'; 			break;
		}		
		$query_  = " SELECT * FROM web_contacto WHERE $col = 'Si' order by id DESC ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function get($id){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_contacto WHERE id= :id ";
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

	function get_ultimo_id_insert(){
		include('conexion_pdo.php');				
		$query_  = " SELECT MAX(id) as id FROM web_contacto "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['id'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function add($nombre, $apellido, $correo, $telefono, $horarios, $img_temp, $m_argoliva, $m_concurso, $m_concurso_nac, $m_rondas, $m_jornadas, $m_chefs, $m_expo){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO web_contacto (nombre, apellido, correo, telefono, horarios, foto, mostrar_argoliva, mostrar_concurso, mostrar_concurso_nac, mostrar_rondas, mostrar_jornadas, mostrar_chefs, mostrar_expo) 
		         VALUES (:nombre, :apellido, :correo, :telefono, :horarios, :foto, :m_argoliva, :m_concurso, :m_concurso_nac, :m_rondas, :m_jornadas, :m_chefs, :m_expo)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':nombre',         $nombre);
			$sql->bindParam(':apellido',       $apellido);
			$sql->bindParam(':correo',         $correo);
			$sql->bindParam(':telefono',       $telefono);
			$sql->bindParam(':horarios',       $horarios);
			$sql->bindParam(':foto',           $img_temp);
			$sql->bindParam(':m_argoliva',     $m_argoliva);
			$sql->bindParam(':m_concurso',     $m_concurso);
			$sql->bindParam(':m_concurso_nac', $m_concurso_nac);
			$sql->bindParam(':m_rondas',       $m_rondas);
			$sql->bindParam(':m_jornadas',     $m_jornadas);
			$sql->bindParam(':m_chefs',        $m_chefs);
			$sql->bindParam(':m_expo',         $m_expo);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_imagen($ult_id, $str_nombre){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_contacto SET foto = :foto WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $ult_id);
			$sql->bindParam(':foto', $str_nombre);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del_contacto($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM web_contacto WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function get_foto_del_contacto($id){
		include('conexion_pdo.php');
		$query_= " SELECT foto FROM web_contacto WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['foto'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_contacto($id, $nombre, $apellido, $correo, $telefono, $horarios, $str_nombre, $m_argoliva, $m_concurso, $m_concurso_nac, $m_rondas, $m_jornadas, $m_chefs, $m_expo){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_contacto SET nombre= :nombre, apellido= :apellido, foto= :foto, correo= :correo, telefono= :telefono, horarios= :horarios,  
		             mostrar_argoliva= :mostrar_argoliva, mostrar_concurso= :mostrar_concurso, mostrar_concurso_nac= :mostrar_concurso_nac, mostrar_rondas= :mostrar_rondas,
					 mostrar_jornadas= :mostrar_jornadas, mostrar_chefs= :mostrar_chefs, mostrar_expo= :mostrar_expo
					 WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':nombre', $nombre);
			$sql->bindParam(':apellido', $apellido);
			$sql->bindParam(':correo', $correo);
			$sql->bindParam(':telefono', $telefono);
			$sql->bindParam(':horarios', $horarios);
			$sql->bindParam(':foto', $str_nombre);
			$sql->bindParam(':mostrar_argoliva', $m_argoliva);
			$sql->bindParam(':mostrar_concurso', $m_concurso);
			$sql->bindParam(':mostrar_concurso_nac', $m_concurso_nac);
			$sql->bindParam(':mostrar_rondas', $m_rondas);
			$sql->bindParam(':mostrar_jornadas', $m_jornadas);
			$sql->bindParam(':mostrar_chefs', $m_chefs);
			$sql->bindParam(':mostrar_expo', $m_expo);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

}
?>