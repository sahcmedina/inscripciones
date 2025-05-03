<?php

class Inventario {
	
	function gets($id_depo){
		include('conexion_pdo.php');
		$tabla   = 'vista_inventario_'.$id_depo;
		$query_  = " SELECT * FROM $tabla ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_datos_config($id_depo){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM inv_config_vistas WHERE fk_deposito = :id_depo ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_depo', $id_depo);	
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function aux_upd_deposito($id_depo){
		require_once('mod2_aratos.php');    $Ar  = new Aratos();

		// upd "M"
		$this->del_vista_mp('m', $id_depo);
		$this->upd_vista_mp('m', $id_depo);
		$cant_m = 1;

		// upd "P"
		$this->del_vista_mp('p', $id_depo);
		$this->upd_vista_mp('p', $id_depo);
		$cant_p = 1;
		
		// upd "S"
		$cant_s = 0;

		// upd "A" (variables)		
		$arr_a   = array();
		$arr_a_id= array();
		$arr_a   = $Ar->gets_segun_dep($id_depo);		
		$cant_a  = 0;
		for($i=0 ; $i < count($arr_a); $i++){
			$id_arato= $arr_a[$i]['id'];
			$this->del_vista_a($id_depo, $id_arato);
			$upd     = $this->upd_vista_a($id_depo, $id_arato);
			if($upd){	
				$cant_a++;   
				array_push($arr_a_id, $id_arato); 
			} 
		}

		// upd "Mov" (variables)
		$cant_mov = 0;

		// upd Vista Final
		$del = $this->del_vista_final($id_depo);
		$upd = $this->upd_vista_final($id_depo, $arr_a_id, $cant_mov);

		// upd datos de Vista
		$del = $this->del_config_vista($id_depo);
		$upd = $this->add_config_vista($id_depo, $cant_m, $cant_p, $cant_s, $cant_a, $cant_mov);
	}

	function upd_vista_mp($tipo, $id){
		include('conexion_pdo.php');	
		$tabla   = 'vista_'.$tipo.'_'.$id;	
		$inv_x   = 'inv_'.$tipo;	
		$query_  = " 	CREATE VIEW $tabla AS
						SELECT mat.codigo, m.total
						FROM  material mat LEFT JOIN $inv_x AS m  ON mat.id = m.fk_material
						WHERE m.ult= 1 AND m.fk_deposito = :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',   $id);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_vista_a($id_depo, $id_arato){
		include('conexion_pdo.php');	
		$tabla   = 'vista_a_'.$id_arato.'_depo_'.$id_depo;
		$query_  = " CREATE VIEW $tabla AS
						SELECT mat.codigo, a.total
						FROM  material mat INNER JOIN inv_a AS a  ON mat.id = a.fk_material
						WHERE a.ult= 1 AND a.fk_deposito = :id_depo AND a.fk_arato= :id_arato"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_depo',   $id_depo);			
			$sql->bindParam(':id_arato',  $id_arato);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_vista_final($id_depo, $arr_a_id, $cant_mov){
		include('conexion_pdo.php');	
		$tabla   = 'vista_inventario_'.$id_depo;
		$inv_m   = 'vista_m_'.$id_depo;
		$inv_p   = 'vista_p_'.$id_depo;

		$query_  = " CREATE VIEW $tabla AS
					SELECT mat.codigo, mat.nombre, 
					       vm.total as M, 
						   vp.total as P "; 

		for($j=0 ; $j<count($arr_a_id) ; $j++){
			$query_ .= ', A_'.$arr_a_id[$j].'.total as A_'.$arr_a_id[$j].' ';
		}

		$query_ .= " FROM material mat 
					LEFT JOIN $inv_m vm     ON mat.codigo = vm.codigo
					LEFT JOIN $inv_p vp     ON mat.codigo = vp.codigo "; 

		for($j=0 ; $j<count($arr_a_id) ; $j++){
			$query_ .= ' LEFT JOIN vista_a_'.$arr_a_id[$j].'_depo_'.$id_depo.' A_'.$arr_a_id[$j].'     ON mat.codigo = A_'.$arr_a_id[$j].'.codigo ';
		}

		try{
			$sql = $con->prepare($query_);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del_config_vista($id_depo){
		include('conexion_pdo.php');	
		$query_  = " DELETE FROM inv_config_vistas WHERE fk_deposito = :id_depo ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_depo', $id_depo);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}	
	function del_vista_mp($tipo, $id_depo) {
		include('conexion_pdo.php');	
		$tabla   = 'vista_'.$tipo.'_'.$id_depo;	
		$query_  = " DROP VIEW $tabla ";	
		try{
			$sql = $con->prepare($query_);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
	function del_vista_a($id_depo, $id_arato) {
		include('conexion_pdo.php');	
		$tabla   = 'vista_a_'.$id_arato.'_depo_'.$id_depo;
		$query_  = " DROP VIEW $tabla ";	
		try{
			$sql = $con->prepare($query_);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
	function del_vista_final($id_depo) {
		include('conexion_pdo.php');	
		$tabla   = 'vista_inventario_'.$id_depo;
		$query_  = " DROP VIEW $tabla ";	
		try{
			$sql = $con->prepare($query_);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function add_config_vista($id_depo, $cant_m, $cant_p, $cant_s, $cant_a, $cant_mov){
		include('conexion_pdo.php');				
		$f_update= Date('Y-m-d');
		$query_  = " INSERT INTO inv_config_vistas (fk_deposito, cant_m, cant_p, cant_s, cant_a, cant_mov, f_update)
		             VALUE (:fk_deposito, :cant_m, :cant_p, :cant_s, :cant_a, :cant_mov, :f_update)";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_deposito', $id_depo);			
			$sql->bindParam(':cant_m',  	$cant_m);			
			$sql->bindParam(':cant_p',  	$cant_p);			
			$sql->bindParam(':cant_s',  	$cant_s);			
			$sql->bindParam(':cant_a',  	$cant_a);			
			$sql->bindParam(':cant_mov',  	$cant_mov);			
			$sql->bindParam(':f_update',  	$f_update);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
	
}
?>