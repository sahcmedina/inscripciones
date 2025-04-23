<?php

class SolicitudMateriales {
	
	function add($cod_mat, $usu, $depo_logueado, $movil, $cant, $dest, $tabla, $fk_arato){
		include('conexion_pdo.php');
		$cero    = 0;
		$f_hoy   = Date('Y-m-d H:i:s');
		$f_vacia = '0000-00-00 00:00:00';
		$query_  = " INSERT INTO solic_materiales (fk_material, fk_deposito, fk_arato, fk_movil, cant, destino, fk_user_crea, fk_user_aprueba, origen, f_create, f_update, estado)
		             VALUE (:fk_material, :fk_deposito, :fk_arato, :fk_movil, :cant, :destino, :fk_user_crea, :fk_user_aprueba, :origen, :f_create, :f_update, :estado)";	
		try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':fk_material',    	$cod_mat);			
			$sql->bindParam(':fk_deposito',    	$depo_logueado);			
			$sql->bindParam(':fk_arato',    	$fk_arato);			
			$sql->bindParam(':fk_movil',    	$movil);			
			$sql->bindParam(':cant',    		$cant);			
			$sql->bindParam(':destino',    		$dest);			
			$sql->bindParam(':fk_user_crea',    $usu);			
			$sql->bindParam(':fk_user_aprueba', $cero);			
			$sql->bindParam(':origen',    		$tabla);			
			$sql->bindParam(':f_create',    	$f_hoy);			
			$sql->bindParam(':f_update',    	$f_vacia);			
			$sql->bindParam(':estado',    		$cero);			
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	    }	
		finally{				$sql = null;				}	
	}

	function gets_solicPorTec_pend($user){
		include('conexion_pdo.php');		
		$query_  = "SELECT sm.*, m.nombre as mat_nbre, m.codigo as mat_codigo,
		                DATE_FORMAT(sm.f_create, '%e ') AS fecha_1,
		                DATE_FORMAT(sm.f_create, '%b') AS mes,
		                DATE_FORMAT(sm.f_create, '%Y - %H:%i hs') AS fecha_2
						FROM solic_materiales sm 
						INNER JOIN material m ON sm.fk_material = m.id
					WHERE sm.fk_user_crea = :user AND sm.estado = 0 "; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':user',  $user);	
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets_solicPendTodas(){
		include('conexion_pdo.php');
		$query_  = " SELECT sm.*, m.nombre as mat_nbre, m.codigo as mat_codigo, m.id as mat_id, 
		                dep.codigo as dep_cod, prov.nombre as dep_prov, dep.id as dep_id,
						DATE_FORMAT(sm.f_create, '%e ') AS fecha_1,
						DATE_FORMAT(sm.f_create, '%b') AS mes,
						DATE_FORMAT(sm.f_create, '%Y - %H:%i hs') AS fecha_2,
						CONCAT(pers.apellido,', ',pers.nombre) AS pers
					FROM solic_materiales sm 
						INNER JOIN material m     		ON sm.fk_material = m.id
						INNER JOIN depositos dep  		ON sm.fk_deposito = dep.id 
						INNER JOIN provincia prov 		ON dep.fk_provincia = prov.id 
						INNER JOIN usuario_ u     		ON sm.fk_user_crea = u.id 
						INNER JOIN usuario_persona pers ON u.fk_personal = pers.dni  
					ORDER BY sm.id ASC "; 
        try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	
	function get_cant_solicPendTodas(){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM solic_materiales WHERE estado = 0 "; 
        try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['cant'];
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
}
?>