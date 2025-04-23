<?php

class Comite {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_comite ";
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
		$query_  = " SELECT MAX(id) as id FROM web_comite "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['id'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function add($ape, $nom, $url_tmp, $dnd_part_es, $dnd_part_in, $repres_es, $repres_in, $f_, $usu){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO web_comite (apellido, nombre, dnd_participa_es, dnd_participa_in, representa_es, representa_in, url, update_fecha, update_user) 
		         VALUES (:apellido, :nombre, :dnd_participa_es, :dnd_participa_in, :representa_es, :representa_in, :url, :update_fecha, :update_user)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':apellido', 			$ape);
			$sql->bindParam(':nombre', 				$nom);
			$sql->bindParam(':dnd_participa_es', 	$dnd_part_es);
			$sql->bindParam(':dnd_participa_in', 	$dnd_part_in);
			$sql->bindParam(':representa_es', 		$repres_es);
			$sql->bindParam(':representa_in', 		$repres_in);
			$sql->bindParam(':url', 				$url_tmp);
			$sql->bindParam(':update_fecha', 		$f_);
			$sql->bindParam(':update_user', 		$usu);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_imagen($ult_id, $str_nombre){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_comite SET url = :url WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $ult_id);
			$sql->bindParam(':url', $str_nombre);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function get_imagen_integrante_comite($id){
		include('conexion_pdo.php');
		$query_= " SELECT url FROM web_comite WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['url'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_integrante($id, $apellido, $nombre, $dnd_participa_es, $dnd_participa_in, $representa_es, $representa_in, $str_nombre, $update_fecha, $usuario){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_comite SET 
							apellido =:apellido,
							nombre   =:nombre, 
							dnd_participa_es = :dnd_participa_es,
							dnd_participa_in = :dnd_participa_in,
							representa_es  = :representa_es,
							representa_in  = :representa_in,
							url=:url, 
							update_fecha = :update_fecha,
							update_user = :update_user
					 WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':apellido', $apellido);
			$sql->bindParam(':nombre', $nombre);
			$sql->bindParam(':dnd_participa_es', $dnd_participa_es);
			$sql->bindParam(':dnd_participa_in', $dnd_participa_in);
			$sql->bindParam(':representa_es', $representa_es);
			$sql->bindParam(':representa_in', $representa_in);
			$sql->bindParam(':url', $str_nombre);			
			$sql->bindParam(':update_fecha', $update_fecha);
			$sql->bindParam(':update_user', $usuario);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function del_integrante($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM web_comite WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
}
?>