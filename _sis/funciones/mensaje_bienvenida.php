<?php
class MensajeBienvenida {
	
	// ESTADOS: 
	// mensaje_bienvenida_.estado 0-inhabilitado 1-habilitado
	
	function get_next_id(){				
		include('conexion_pdo.php');				
		$query_ = " SELECT max(id) as id FROM mensaje_bienvenida_ "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return ($res['id'] + 1);
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_tipo($id){				
		include('conexion_pdo.php');				
		$query_ = " SELECT tipo_usuario FROM mensaje_bienvenida_ WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['tipo_usuario'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	function gets_msj($estado){				
		include('conexion_pdo.php');				
		$query_ = "SELECT mb.*, u.fk_personal, p.apellido, p.nombre, t.nombre AS tipo
				   FROM mensaje_bienvenida_ mb 
					     INNER JOIN usuario_ u                ON u.id=mb.usr_creador 
					     INNER JOIN personal_ p               ON p.dni=u.fk_personal 
                         INNER JOIN mensaje_bienvenida_tipo t ON t.id=mb.tipo_usuario
				   WHERE mb.estado= :estado"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':estado', $estado);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_msj_user($tipo){				
		include('conexion_pdo.php');				
		$query_ = "SELECT titulo, mensaje FROM mensaje_bienvenida_ WHERE tipo_usuario= :tipo AND estado= '1' "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':tipo', $tipo);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_msj_particular($id){				
		include('conexion_pdo.php');				
		$query_ = "SELECT msj.*, t.nombre 
		           FROM mensaje_bienvenida_ msj INNER JOIN mensaje_bienvenida_tipo t ON msj.tipo_usuario = t.id
		           WHERE msj.id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_tipo_user(){				
		include('conexion_pdo.php');				
		$query_ = "SELECT id, nombre FROM mensaje_bienvenida_tipo WHERE estado= 1 "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	function add($tipo, $user, $titulo, $descrip){
		include('conexion_pdo.php');
		$next    = $this->get_next_id();
		$dsd     = Date('Y-m-d');
		$titulo_ = utf8_decode($titulo);
		$descrip_= utf8_decode($descrip);
		
		$query= "INSERT INTO mensaje_bienvenida_ (id, titulo, mensaje, tipo_usuario, dsd, hst, usr_creador, estado) VALUES (:id, :titulo, :mensaje, :tipo, :dsd, '0000-00-00', :user, '1')";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',      $next);
			$sql->bindParam(':titulo',  $titulo_);
			$sql->bindParam(':mensaje', $descrip_);
			$sql->bindParam(':tipo',    $tipo);
			$sql->bindParam(':dsd',     $dsd);
			$sql->bindParam(':user',    $user);
			$sql->execute();
			$sql = null;
			return $next;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	function upd_inhab_tipo($tipo){
		include('conexion_pdo.php');	
		$hst    = 	Date('Y-m-d');		
		$query_ = " UPDATE mensaje_bienvenida_ SET estado='0', hst= :hst WHERE tipo_usuario= :tipo "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':tipo', $tipo);
			$sql->bindParam(':hst',  $hst);
			$sql->execute();
			$sql = null;
		}
		catch (Exception $e){
			echo $e->getMessage();
		}
	}
	function upd_inhab_msj($id){
		include('conexion_pdo.php');	
		$hst    = Date('Y-m-d');		
		$query_ = " UPDATE mensaje_bienvenida_ SET estado='0', hst= :hst WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':hst', $hst);
			$sql->execute();
			$sql = null;
		}
		catch (Exception $e){
			echo $e->getMessage();
		}
	}
	function upd_hab_msj($id){
		include('conexion_pdo.php');	
		$dsd    = Date('Y-m-d');		
		$query_ = " UPDATE mensaje_bienvenida_ SET estado='1', dsd= :dsd WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':dsd', $dsd);
			$sql->execute();
			$sql = null;
		}
		catch (Exception $e){
			echo $e->getMessage();
		}
	}
	function upd($id, $titulo, $msj){
		include('conexion_pdo.php');	
		$query_  = " UPDATE mensaje_bienvenida_ SET titulo= :titulo, mensaje= :mensaje WHERE id= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',      $id);
			$sql->bindParam(':titulo',  $titulo);
			$sql->bindParam(':mensaje', $msj);
			if($sql->execute())	$return= true;
			else				$return= false;
		}
		catch (Exception $e){
			echo $e->getMessage();
		}
		$sql = null;
		return $return;
	}
	
}
?>