<?php
date_default_timezone_set('America/Argentina/San_Juan');
class RondaInversiones {

	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT r.* FROM eventos_ronda_inv r ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
		 
	function add_evento($tipo, $fk_evento, $titulo, $fecha, $hora, $lugar, $f_insc_dsd, $f_insc_hst, $user){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos (tipo, fk_evento, titulo, fecha, hora, lugar, f_inscrip_dsd, f_inscrip_hst, f_create, fk_usuario) 
		         VALUES (:tipo, :fk_evento, :titulo, :fecha, :hora, :lugar, :f_inscrip_dsd, :f_inscrip_hst, :f_create, :fk_usuario)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':tipo', 	        $tipo);
			$sql->bindParam(':fk_evento', 	    $fk_evento);
			$sql->bindParam(':titulo', 	    	$titulo);
			$sql->bindParam(':fecha', 	    	$fecha);
			$sql->bindParam(':hora', 	    	$hora);
			$sql->bindParam(':lugar', 	    	$lugar);
			$sql->bindParam(':f_inscrip_dsd', 	$f_insc_dsd);
			$sql->bindParam(':f_inscrip_hst', 	$f_insc_hst);
			$sql->bindParam(':f_create', 	    $hoy);
			$sql->bindParam(':fk_usuario',      $user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	        
	function add($user, $nombre, $lugar, $f1, $f2, $f_insc_dsd, $f_insc_hst, $hora){
		include('conexion_pdo.php');
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_inv (nombre, lugar, hora, f_dia_1, f_dia_2, f_inscrip_dsd, f_inscrip_hst, f_create, fk_usuario) 
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
	
	function tf_existe_nombre($nombre){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM eventos_ronda_inv WHERE nombre = :nombre "; 
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

	function add_sect($id_ri, $id_sect, $user){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_inv_sectores_select (id_ri, id_sect, f_update, fk_user) 
		         VALUES (:id_ri, :id_sect, :f_update, :fk_user)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id_ri', 	     $id_ri);
			$sql->bindParam(':id_sect', 	 $id_sect);
			$sql->bindParam(':f_update',     $hoy);
			$sql->bindParam(':fk_user',      $user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	         
	function get_sect_en_RI($id_ri){
		include('conexion_pdo.php');
		$query_= " SELECT GROUP_CONCAT(s.nombre SEPARATOR ' - ') AS sect
					FROM eventos_ronda_inv_sectores_select AS sel
		        	INNER JOIN eventos_ronda_inv_sectores AS s ON s.id = sel.id_sect
					WHERE sel.id_ri = :id_ri ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_ri', $id_ri);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['sect'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}

	function get_last_id_ri(){
		include('conexion_pdo.php');
		$query_= " SELECT MAX(id) AS ult_id FROM eventos_ronda_inv LIMIT 1 ";
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

	function add_inscrip($id_ri, $emp, $cuit, $resp, $tel, $i_o, $prov, $email){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_inv_inscrip (fk_ri, persona, tel, email, fk_prov, i_o, emp, cuit, f_create) 
		         VALUES (:fk_ri, :persona, :tel, :email, :fk_prov, :i_o, :emp, :cuit, :f_create)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_ri', 	    $id_ri);
			$sql->bindParam(':persona', 	$resp);
			$sql->bindParam(':tel', 	    $tel);
			$sql->bindParam(':email', 	    $email);
			$sql->bindParam(':fk_prov',     $prov);
			$sql->bindParam(':i_o', 	    $i_o);
			$sql->bindParam(':emp', 	    $emp);
			$sql->bindParam(':cuit',     	$cuit);
			$sql->bindParam(':f_create', 	$hoy);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function add_inscrip_sect($id_ri, $id_sect){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_inv_inscrip_sect (fk_insc, fk_sect, f_create) 
		         VALUES (:fk_insc, :fk_sect, :f_create)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_insc', 	 $id_ri);
			$sql->bindParam(':fk_sect', 	 $id_sect);
			$sql->bindParam(':f_create',     $hoy);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function get_last_id_inscrip(){
		include('conexion_pdo.php');
		$query_= " SELECT MAX(id) AS ult_id FROM eventos_ronda_inv_inscrip LIMIT 1 ";
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

	function gets_id($id_ri){
		include('conexion_pdo.php');
		$query_  = " SELECT r.* FROM eventos_ronda_inv r WHERE r.id= :id_ri ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_ri', $id_ri);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function tf_existe_sector_elegido($id_ri, $id_sect){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM eventos_ronda_inv_sectores_select WHERE id_ri = :id_ri AND id_sect = :id_sect "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_ri',   $id_ri);
			$sql->bindParam(':id_sect', $id_sect);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}

	function upd($id, $user, $nombre, $lugar, $f1, $f2, $dsd, $hst, $hora){
		include('conexion_pdo.php');	
		$query_  = " UPDATE eventos_ronda_inv 
		             SET nombre= :nombre, fk_usuario= :fk_user, lugar= :lugar, f_dia_1= :f1, f_dia_2= :f2,
					     f_inscrip_dsd= :dsd, f_inscrip_hst= :hst, hora= :hora
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',       $id);			
			$sql->bindParam(':fk_user',  $user);		
			$sql->bindParam(':nombre',   $nombre);			
			$sql->bindParam(':lugar',    $lugar);			
			$sql->bindParam(':f1',       $f1);			
			$sql->bindParam(':f2',       $f2);			
			$sql->bindParam(':dsd',      $dsd);			
			$sql->bindParam(':hst',      $hst);			
			$sql->bindParam(':hora',     $hora);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_evento($tipo, $id, $user, $nombre, $lugar, $f1, $dsd, $hst, $hora){
		include('conexion_pdo.php');		 
		$query_  = " UPDATE eventos 
		             SET titulo= :nombre, fecha= :f1, hora= :hora, lugar= :lugar, 
					     f_inscrip_dsd= :dsd, f_inscrip_hst= :hst, fk_usuario= :fk_user
		             WHERE fk_evento= :id AND tipo= :tipo"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',       $id);			
			$sql->bindParam(':tipo',     $tipo);			
			$sql->bindParam(':nombre',   $nombre);			
			$sql->bindParam(':f1',       $f1);				
			$sql->bindParam(':hora',     $hora);				
			$sql->bindParam(':lugar',    $lugar);	
			$sql->bindParam(':dsd',      $dsd);			
			$sql->bindParam(':hst',      $hst);		
			$sql->bindParam(':fk_user',  $user);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM eventos_ronda_inv WHERE id= :id "; 
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

	function del_web($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM eventos WHERE fk_evento= :id "; 
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

	function gets_sectores_segun_ri($fk_id){
		include('conexion_pdo.php');
		$query_= " SELECT sel.id_sect AS id, s.nombre FROM eventos_ronda_inv_sectores AS s
				   INNER JOIN eventos_ronda_inv_sectores_select AS sel
				   ON sel.id_sect = s.id
				   WHERE sel.id_ri = :id_ri ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_ri', $fk_id);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	function del_sectores_segun_ri($id){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM eventos_ronda_inv_sectores_select WHERE id_ri= :id_ri "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_ri',  $id);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
	
	function gets_inscrip_x_id($id, $i_o){
		include('conexion_pdo.php');
		$query_= " SELECT i.*, p.nombre As prov 
		            FROM eventos_ronda_inv_inscrip AS i 
					INNER JOIN provincia AS p ON p.id= i.fk_prov
					WHERE i.fk_ri = :id AND i.i_o= :i_o ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':i_o', $i_o);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	//-------------------------------------------------------------------------------

	function gets_param(){
		include('conexion_pdo.php');
		$query_  = " SELECT p.* FROM eventos_ronda_neg_agenda_param p WHERE p.id= 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function upd_param($hs, $duracion, $x_dia, $user){
		include('conexion_pdo.php');		 
		$id      = 1;
		$f_update= Date('Y-m-d H:i:s');
		$query_  = " UPDATE eventos_ronda_neg_agenda_param 
		             SET primer_reunion= :primer_reunion, duracion= :duracion, x_dia= :x_dia, f_update= :f_update, fk_usuario= :fk_usuario
		             WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',                 $id);			
			$sql->bindParam(':primer_reunion',     $hs);			
			$sql->bindParam(':duracion',           $duracion);			
			$sql->bindParam(':x_dia',              $x_dia);				
			$sql->bindParam(':f_update',           $f_update);				
			$sql->bindParam(':fk_usuario',         $user);	
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
}
?>