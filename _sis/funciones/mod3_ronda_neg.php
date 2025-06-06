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
	function gets_id($id_rn){
		include('conexion_pdo.php');
		$query_  = " SELECT r.* FROM eventos_ronda_neg r WHERE r.id= :id_rn ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_rn', $id_rn);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_inscrip_x_id($id, $c_v){
		include('conexion_pdo.php');
		$query_= " SELECT i.*, p.nombre As prov 
		            FROM eventos_ronda_neg_inscrip AS i 
					INNER JOIN provincia AS p ON p.id= i.fk_prov
					WHERE i.fk_rn = :id AND i.c_v= :c_v ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':c_v', $c_v);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}	
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
	function get_last_id_inscrip(){
		include('conexion_pdo.php');
		$query_= " SELECT MAX(id) AS ult_id FROM eventos_ronda_neg_inscrip LIMIT 1 ";
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
	function tf_existe_producto_elegido($id_rn, $id_prod){
		include('conexion_pdo.php');
		$query_  = " SELECT count(*) as cant FROM eventos_ronda_neg_productos_select WHERE id_rn = :id_rn AND id_prod = :id_prod "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_rn',   $id_rn);
			$sql->bindParam(':id_prod', $id_prod);
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
	function add_inscrip($id_rn, $emp, $cuit, $resp, $tel, $c_v, $prov, $email){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_neg_inscrip (fk_rn, persona, tel, email, fk_prov, c_v, emp, cuit, f_create) 
		         VALUES (:fk_rn, :persona, :tel, :email, :fk_prov, :c_v, :emp, :cuit, :f_create)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_rn', 	    $id_rn);
			$sql->bindParam(':persona', 	$resp);
			$sql->bindParam(':tel', 	    $tel);
			$sql->bindParam(':email', 	    $email);
			$sql->bindParam(':fk_prov',     $prov);
			$sql->bindParam(':c_v', 	    $c_v);
			$sql->bindParam(':emp', 	    $emp);
			$sql->bindParam(':cuit',     	$cuit);
			$sql->bindParam(':f_create', 	$hoy);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function add_inscrip_prod($id_rn, $id_prod){
		include('conexion_pdo.php'); 
		$hoy  = Date('Y-m-d H:i:s');
		$query= "INSERT INTO eventos_ronda_neg_inscrip_prod (fk_insc, fk_prod, f_create) 
		         VALUES (:fk_insc, :fk_prod, :f_create)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_insc', 	 $id_rn);
			$sql->bindParam(':fk_prod', 	 $id_prod);
			$sql->bindParam(':f_create',     $hoy);
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
	function del_prod($id_rn){
		include('conexion_pdo.php');				
		$query_  = " DELETE FROM eventos_ronda_neg_productos_select WHERE id_rn= :id_rn "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_rn',  $id_rn);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}

	function upd($id, $user, $nombre, $lugar, $f1, $f2, $dsd, $hst, $hora){
		include('conexion_pdo.php');	
		$query_  = " UPDATE eventos_ronda_neg 
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