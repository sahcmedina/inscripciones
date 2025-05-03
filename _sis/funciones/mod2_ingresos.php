<?php

class Ingresos {
	
	function add($tabla, $cod_mat, $fk_dep, $fk_arato, $ant, $aho, $tot, $fk_tipo, $or_movi, $or_prov, $o_pase, $fk_user, $orden){
		include('conexion_pdo.php');
		$uno     = 1;
		$f       = Date('Y-m-d H:i:s');
		switch($tabla){
			case 'M': $tabla_= 'inv_m'; break;			case 'P': $tabla_= 'inv_p'; break;
			case 'A': $tabla_= 'inv_a'; break;			default : break;
		}
		$query_  = " INSERT INTO $tabla_ (fk_material, fk_deposito, fk_arato, antes, ahora, total, fk_tipo_movim, origen_movil, origen_prov, origen_pase, fk_user, orden, ult, f_create)
		             VALUE (:fk_material, :fk_deposito, :fk_arato, :antes, :ahora, :total, :fk_tipo_movim, :origen_movil, :origen_prov, :origen_pase, :fk_user, :orden, :ult, :f_create)";	
		try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':fk_material',    	$cod_mat);			
			$sql->bindParam(':fk_deposito',     $fk_dep);			
			$sql->bindParam(':fk_arato',        $fk_arato);			
			$sql->bindParam(':antes', 			$ant);	
			$sql->bindParam(':ahora',     		$aho);
			$sql->bindParam(':total',     		$tot);
			$sql->bindParam(':fk_tipo_movim',   $fk_tipo);
			$sql->bindParam(':origen_movil',    $or_movi);
			$sql->bindParam(':origen_prov',     $or_prov);
			$sql->bindParam(':origen_pase',     $o_pase);
			$sql->bindParam(':fk_user',      	$fk_user);
			$sql->bindParam(':orden',      		$orden);
			$sql->bindParam(':ult',      		$uno);
			$sql->bindParam(':f_create',      	$f);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	    }	
		finally{				$sql = null;				}	
	}

	function gets_ult_orden($tabla, $codigo, $id_dep){
		include('conexion_pdo.php');		
		switch($tabla){
			case 'M': $tabla_= 'inv_m'; break;			case 'P': $tabla_= 'inv_p'; break;
			case 'A': $tabla_= 'inv_a'; break;			default : break;
		}
		$query_  = " SELECT * FROM $tabla_ WHERE fk_material= :codigo AND fk_deposito= :id_dep ORDER BY orden DESC LIMIT 1 "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_dep', $id_dep);					
			$sql->bindParam(':codigo', $codigo);					
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets($tabla, $id_dep){
		include('conexion_pdo.php');		
		switch($tabla){
			case 'M': $tabla_= 'inv_m'; break;			case 'P': $tabla_= 'inv_p'; break;
			case 'A': $tabla_= 'inv_a'; break;			default : break;
		}
		$query_  = " SELECT t.*, m.codigo, m.nombre, tm.nombre as movim, pro.nombre as o_prov
		             FROM $tabla_ as t
		             INNER JOIN material as m             ON t.fk_material   = m.id
		             INNER JOIN inv_tipo_movimiento as tm ON t.fk_tipo_movim = tm.id
		             LEFT JOIN proveedores as pro         ON t.origen_prov   = pro.id
					 WHERE t.fk_deposito= :id_dep
				     ORDER BY orden DESC"; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':id_dep', $id_dep);			
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	
	function gets_materialEnDepo($cod_mat, $depo_log){
		include('conexion_pdo.php');
		$query_  = "SELECT inv_m.total, concat('M') as tabla, concat('M') as dep, d.codigo as nbre_depo, p.nombre as nbre_prov, inv_m.id
					FROM inv_m INNER JOIN depositos d ON inv_m.fk_deposito  = d.id
					INNER JOIN provincia p ON d.fk_provincia = p.id 
					WHERE inv_m.fk_material= :fk_material AND inv_m.fk_deposito= :fk_deposito AND inv_m.ult = 1

					UNION 

					SELECT inv_p.total, concat('P') as tabla, concat('P 170') as dep, d.codigo as nbre_depo, p.nombre as nbre_prov, inv_p.id
					FROM inv_p INNER JOIN depositos d ON inv_p.fk_deposito = d.id
					INNER JOIN provincia p ON d.fk_provincia = p.id 
					WHERE inv_p.fk_material= :fk_material AND inv_p.fk_deposito= :fk_deposito AND inv_p.ult = 1

					UNION 

					SELECT inv_a.total, concat('A') as tabla, concat('Arato ',a.codigo) as dep,d.codigo as nbre_depo, p.nombre as nbre_prov, inv_a.id
					FROM inv_a INNER JOIN depositos d ON inv_a.fk_deposito = d.id
					INNER JOIN provincia p ON d.fk_provincia = p.id 
					INNER JOIN aratos a    ON inv_a.fk_arato = a.id 
					WHERE inv_a.fk_material= :fk_material AND inv_a.fk_deposito= :fk_deposito AND inv_a.ult = 1"; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':fk_material', $cod_mat);			
			$sql->bindParam(':fk_deposito', $depo_log);			
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets_segun_id($tabla, $id){
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM $tabla WHERE id= :id "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);					
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function get_cantActual_materialASacar($tabla, $id_material, $id_depo, $id_arato){
		include('conexion_pdo.php');		
		switch($tabla){
			case 'M': 	$tabla_= 'inv_m'; 	$sql2= '';  $sql4= '';    									
						break;			

			case 'P': 	$tabla_= 'inv_p'; 	$sql2= '';  $sql4= ''; 										
						break;
						
			case 'A': 	$tabla_= 'inv_a'; 
						$sql2  = " LEFT JOIN aratos as a ON t.fk_arato = a.id "; 	
						$sql4  = " AND t.fk_arato = :id_arato "; 	
						break;			

			default : 	break;
		}
		$sql1  = " SELECT t.total
						FROM $tabla_ as t
						INNER JOIN material as m  ON t.fk_material = m.id ";
		$sql3  = " WHERE t.fk_deposito= :id_depo AND t.fk_material= :id_material AND t.ult = 1 ";
		$query_= $sql1.$sql2.$sql3.$sql4; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':id_depo',     $id_depo);			
			$sql->bindParam(':id_material', $id_material);	
			if($tabla =='A')	$sql->bindParam(':id_arato', $id_arato);			
			$sql->execute();
			$res = $sql->fetch();
			return $res['total'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function mdf_marca_ult($tabla, $id_reg, $estado){
		include('conexion_pdo.php');
		switch($tabla){
			case 'M': $tabla_= 'inv_m'; break;			case 'P': $tabla_= 'inv_p'; break;
			case 'A': $tabla_= 'inv_a'; break;			default : break;
		}				
		$query_  = " UPDATE $tabla_ SET ult = :ult WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id_reg);
			$sql->bindParam(':ult',    $estado);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

}
?>