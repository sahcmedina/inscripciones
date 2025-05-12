<?php
date_default_timezone_set('America/Argentina/San_Juan');
class RondaNegocios {	         

	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT r.* FROM eventos_ronda_neg r ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function get_last_id_rn(){
		include('conexion_pdo.php');
		$query_= " SELECT MAX(id) AS ult_id FROM eventos_ronda_neg LIMIT 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['ult_id'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_prod_en_RN($id_rn){
		include('conexion_pdo.php');
		$query_= " SELECT GROUP_CONCAT(p.nombre SEPARATOR ' - ') AS prod
					FROM eventos_ronda_neg_productos_select sel
					INNER JOIN eventos_ronda_neg_productos p ON p.id = sel.id_prod
					WHERE sel.id_rn = :id_rn ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_rn', $id_rn);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['prod'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}

	function tf_existe_nombre($nombre){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM eventos_ronda_neg WHERE nombre = :nombre "; 
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

	function add($user, $nombre, $lugar, $f1, $f2, $f_insc_dsd, $f_insc_hst, $hora){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$nada = '0000-00-00 00:00:00';
		$query= "INSERT INTO eventos_ronda_neg (nombre, lugar, hora, f_dia_1, f_dia_2, f_inscrip_dsd, f_inscrip_hst, f_create, fk_usuario) 
		         VALUES (:nombre, :lugar, :hora, :f_dia_1, :f_dia_2, :f_inscrip_dsd, :f_inscrip_hst, :f_create, :fk_usuario)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':nombre', 	        $nombre);
			$sql->bindParam(':lugar', 	        $lugar);
			$sql->bindParam(':hora', 	        $hora);
			$sql->bindParam(':f_dia_1', 	    $f1);
			$sql->bindParam(':f_dia_2', 	    $f2);
			$sql->bindParam(':f_inscrip_dsd', 	$f_insc_dsd);
			$sql->bindParam(':f_inscrip_hst', 	$f_insc_hst);
			$sql->bindParam(':f_create', 	    $hoy);
			$sql->bindParam(':fk_usuario',      $user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function add_evento($tipo, $fk_evento, $titulo, $fecha, $hora, $lugar, $f_insc_dsd, $f_insc_hst, $user){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos (tipo, fk_evento, titulo, fecha, hora, lugar, f_inscrip_dsd, f_inscrip_hst, f_create, fk_usuario) 
		         VALUES (:tipo, :fk_evento, :titulo, :fecha, :hora, :lugar, :f_inscrip_dsd, :f_inscrip_hst, :f_create, :fk_usuario)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':nombre', 	        $nombre);
			$sql->bindParam(':lugar', 	        $lugar);
			$sql->bindParam(':f_dia_1', 	    $f1);
			$sql->bindParam(':f_dia_2', 	    $f2);
			$sql->bindParam(':f_inscrip_dsd', 	$f_insc_dsd);
			$sql->bindParam(':f_inscrip_hst', 	$f_insc_hst);
			$sql->bindParam(':f_create', 	    $hoy);
			$sql->bindParam(':fk_usuario',      $user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	
	function add_prod($id_rn, $id_prod, $user){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_neg_productos_select (id_rn, id_prod, f_update, fk_user) 
		         VALUES (:id_rn, :id_prod, :f_update, :fk_user)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id_rn', 	     $id_rn);
			$sql->bindParam(':id_prod', 	 $id_prod);
			$sql->bindParam(':f_update',     $hoy);
			$sql->bindParam(':fk_user',      $user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM eventos_ronda_neg WHERE id= :id "; 
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
		$query_  = " UPDATE eventos_ronda_neg SET nombre = :nombre, f_update= :f_update, fk_user= :fk_user
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