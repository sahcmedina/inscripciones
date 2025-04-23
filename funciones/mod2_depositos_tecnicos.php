<?php
// Para que esta funcion "funcione" el perfil TECNICO debe mantenerse en 6

class Depositos_tecnicos {	

	function aux_upd(){
		// 1 - recorro tabla depositos_tecnicos cambiando estados a 0
		$upd = $this->upd_estadosEnCero();

		// 2 - buscar tecnicos actualizados en arr_nuevos
		$arr_new = array();
		$arr_new = $this->gets_usuariosTecnicos();

		// 3 - para c/reg de arr_nuevos: (a) esta en tabla: estado a 1 (b) no esta: lo agrego
		for($i=0 ; $i<count($arr_new) ; $i++){
			$user = $arr_new[$i]['fk_usuario'];
			$esta = $this->tf_existe($user);
			if($esta){
				$upd = $this->upd_estado($user, '1');
			}else{
				$add = $this->add($user);
			}
		}
	}

	function add($user){		
		include('conexion_pdo.php');
		$f_null = '0000-00-00 00:00:00';	 
		$f_hoy  = Date('Y-m-d H:i:s');
		$uno    = 1;   	
		$cero   = 0;   	
		$query  = "INSERT INTO depositos_tecnicos (fk_usuario, fk_deposito, estado, f_create, f_update) 
		           VALUES (:fk_usuario, :fk_deposito, :estado, :f_create, :f_update)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_usuario',  $user);
			$sql->bindParam(':fk_deposito', $cero);
			$sql->bindParam(':estado',      $uno);
			$sql->bindParam(':f_create',    $f_hoy);
			$sql->bindParam(':f_update',    $f_null);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;									
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	
	function upd($id, $dep, $user, $usu_log){
		include('conexion_pdo.php');	
		$f_upd   = Date('Y-m-d H:i:s');			
		$query_  = " UPDATE depositos_tecnicos SET fk_deposito = :depo, fk_usuario= :user, f_update= :upd WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':id',      $id);
			$sql->bindParam(':depo',    $dep);
			$sql->bindParam(':user',    $user);
			$sql->bindParam(':upd',     $f_upd);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_estadosEnCero(){
		include('conexion_pdo.php');				
		$query_  = " UPDATE depositos_tecnicos SET estado = 0  "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_estado($user, $estado){		
		include('conexion_pdo.php');
		$query_ = " UPDATE depositos_tecnicos SET estado= :estado WHERE fk_usuario= :fk_usuario "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':estado',       $estado);
			$sql->bindParam(':fk_usuario',   $user);			
			if($sql->execute())	$return= true;	else  $return= false;
			return $return;
		}		
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function gets_usuariosTecnicos(){
		include('conexion_pdo.php');		
		$query_  = " SELECT fk_usuario FROM usuario_perfil_asociado WHERE fk_perfil = 6  "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets(){
		include('conexion_pdo.php');		
		$query_  = " SELECT dt.*, d.codigo as nbre_dep, p.nombre, p.apellido, prov.nombre as provi
					FROM depositos_tecnicos dt 
					LEFT JOIN depositos d         ON d.id = dt.fk_deposito
					INNER JOIN usuario_ u         ON dt.fk_usuario = u.id
					INNER JOIN usuario_persona p  ON u.fk_personal = p.dni
					LEFT JOIN provincia prov      ON d.fk_provincia = prov.id
					WHERE dt.estado = 1 "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function get_cantEnDepo($dep){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM depositos_tecnicos WHERE fk_deposito = :dep "; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':dep',  $dep);	
			$sql->execute();
			$res = $sql->fetch();
			return $res['cant'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function get_depoUser($user){
		include('conexion_pdo.php');		
		$query_  = " SELECT fk_deposito FROM depositos_tecnicos WHERE fk_usuario = :user "; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':user',  $user);	
			$sql->execute();
			$res = $sql->fetch();
			return $res['fk_deposito'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function tf_existe($user){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM depositos_tecnicos WHERE fk_usuario= :fk_usuario "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_usuario',   $user);
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