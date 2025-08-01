<?php

class Conferencias {
	         
	function gets_all_conferencias(){
		include('conexion_pdo.php');
		$query_= " SELECT e.id AS id_evento, e.titulo, e.tipo, e.fk_evento, e.fecha, e.hora, e.lugar, e.f_inscrip_dsd, e.f_inscrip_hst, e.f_create, e.fk_usuario, 
		        c.id AS id_conferencia, c.disertante, c.modalidad, c.organismo AS id_organismo, c.estado, c.cupo, c.f_update, c.fk_usuario AS user_mdf, o.organismo 
				FROM eventos AS e
				INNER JOIN eventos_conferencias AS c ON c.id = e.fk_evento
				INNER JOIN organismos AS o ON o.id = c.organismo
				WHERE e.tipo = 'C' ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function gets_all_organismos(){
		include('conexion_pdo.php');
		$query_= "  SELECT * FROM organismos ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function add_evento($tipo, $ult_id_foro, $titulo, $fecha, $hora, $lugar, $insc_inicio, $insc_final, $f_create, $id_user){
		include('conexion_pdo.php');
		$query_= "INSERT INTO eventos (tipo, fk_evento, titulo, fecha, hora, lugar, f_inscrip_dsd, f_inscrip_hst, f_create, fk_usuario)
					VALUES    (:tipo, :fk_evento, :titulo, :fecha, :hora, :lugar, :f_inscrip_dsd, :f_inscrip_hst, :f_create, :fk_usuario)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':tipo',          $tipo);
			$sql->bindParam(':fk_evento',  	  $ult_id_foro);
			$sql->bindParam(':titulo',        $titulo);
			$sql->bindParam(':fecha',  	      $fecha);
			$sql->bindParam(':hora',          $hora);
			$sql->bindParam(':lugar',  	      $lugar);
			$sql->bindParam(':f_inscrip_dsd', $insc_inicio);
			$sql->bindParam(':f_inscrip_hst', $insc_final);
			$sql->bindParam(':f_create',      $f_create);
			$sql->bindParam(':fk_usuario',    $id_user);
			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }				
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function get_last_id(){
		include('conexion_pdo.php');
		$query_= " SELECT MAX(id) AS ult_id FROM eventos_conferencias LIMIT 1 ";
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
	         
	function add_conferencia($disertante, $organismo, $modalidad, $cupo, $estado, $f_update, $id_user){
		include('conexion_pdo.php');
		$query_= "INSERT INTO eventos_conferencias (disertante, organismo, modalidad, cupo, estado, f_update, fk_usuario)
				  VALUES (:disertante, :organismo, :modalidad, :cupo, :estado, :f_update, :fk_usuario)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':disertante', $disertante);
			$sql->bindParam(':organismo',  $organismo);
			$sql->bindParam(':modalidad',  $modalidad);
			$sql->bindParam(':cupo',       $cupo);
			$sql->bindParam(':estado',     $estado);
			$sql->bindParam(':f_update',   $f_update);
			$sql->bindParam(':fk_usuario', $id_user);
			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }				
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	// borro la cabecera
	function del_evento($id_e){
		include('conexion_pdo.php');
		$query_= " DELETE FROM eventos WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id_e);
			if($sql->execute())	$return= true;
			else				$return= false;								
			return $return;	
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	// borro el detalle
	function del_conferencia($id_c){
		include('conexion_pdo.php');
		$query_= " DELETE FROM eventos_conferencias WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id_c);
			if($sql->execute())	$return= true;
			else				$return= false;								
			return $return;	
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	        
	function upd_cambia_estado($id, $estado_nuevo, $f_update, $id_user){
		include('conexion_pdo.php');
		$query_= " UPDATE eventos_conferencias SET 
					estado     = :estado, 
					f_update   = :f_update, 
					fk_usuario = :fk_usuario 
				   WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',       $id);
			$sql->bindParam(':estado',   $estado_nuevo);
			$sql->bindParam(':f_update', $f_update);
			$sql->bindParam(':fk_usuario',  $id_user);
			if($sql->execute())	$return= true;
			else				$return= false;								
			return $return;	
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	//--------------- UPDATE EVENTO
	function upd_evento($id_evento, $titulo, $fecha, $hora, $lugar, $insc_inicio, $insc_final){
		include('conexion_pdo.php');
		$query_= " UPDATE eventos SET
					titulo        = :titulo, 
					fecha         = :fecha,
					hora		  = :hora,
					lugar         = :lugar,
					f_inscrip_dsd = :f_inscrip_dsd,
					f_inscrip_hst = :f_inscrip_hst
				   WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',            $id_evento);
			$sql->bindParam(':titulo',  	  $titulo);
			$sql->bindParam(':fecha',         $fecha);
			$sql->bindParam(':hora',          $hora);
			$sql->bindParam(':lugar',         $lugar);
			$sql->bindParam(':f_inscrip_dsd', $insc_inicio);
			$sql->bindParam(':f_inscrip_hst', $insc_final);
			if($sql->execute())	$return= true;
			else				$return= false;								
			return $return;	
			}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
		
	}

	//--------------- UPDATE FORO
	function upd_conferencia($fk_evento, $disertante, $organismo, $modalidad, $cupo, $f_update, $id_user){
		include('conexion_pdo.php');
		$query_= " UPDATE eventos_conferencias SET
					disertante = :disertante, 
					organismo  = :organismo,
					modalidad  = :modalidad,
					cupo       = :cupo,
					f_update   = :f_update,
					fk_usuario = :fk_usuario
				   WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',         $fk_evento);
			$sql->bindParam(':disertante', $disertante);
			$sql->bindParam(':organismo',  $organismo);
			$sql->bindParam(':modalidad',  $modalidad);
			$sql->bindParam(':cupo',  	   $cupo);
			$sql->bindParam(':f_update',   $f_update);
			$sql->bindParam(':fk_usuario', $id_user);
			if($sql->execute())	$return= true;
			else				$return= false;								
			return $return;	
			}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
		
	}

	function gets_inscriptos_conferencia_segun_id($id){
		include('conexion_pdo.php');
		$query_= " SELECT co.*, d.nombre As departamento FROM conferencia_inscriptos AS co 
					INNER JOIN departamentos AS d ON d.id= co.localidad
					WHERE co.fk_conferencia = :id";
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
	         
	function add_inscripto($fkevento, $dni, $nombre, $apellido, $telefono, $email, $empresa, $cargo, $localidad){
		include('conexion_pdo.php');
		$f_create= date("Y-m-d H:i");
		$query_= "INSERT INTO conferencia_inscriptos (fk_conferencia, apellido, nombre, dni, telefono, email, empresa, cargo, localidad, f_create)
				  VALUES (:fk_conferencia, :apellido, :nombre, :dni, :telefono, :email, :empresa, :cargo, :localidad, :f_create)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_conferencia', $fkevento);
			$sql->bindParam(':apellido',       $apellido);
			$sql->bindParam(':nombre',         $nombre);
			$sql->bindParam(':dni',            $dni);
			$sql->bindParam(':telefono',       $telefono);
			$sql->bindParam(':email',          $email);
			$sql->bindParam(':empresa',        $empresa);
			$sql->bindParam(':cargo',          $cargo);
			$sql->bindParam(':localidad',      $localidad);
			$sql->bindParam(':f_create',       $f_create);
			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }				
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function gets_localidades(){
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM departamentos  "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function tf_dni_inscripto_evento($dni, $fk_evento){
		include('conexion_pdo.php');
		$query_= " SELECT * FROM conferencia_inscriptos WHERE dni = :dni AND fk_conferencia = :fk_conferencia LIMIT 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);
			$sql->bindParam(':fk_conferencia', $fk_evento);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function get_datos_dni_inscripto($dni){
		include('conexion_pdo.php');
		$query_= " SELECT * FROM conferencia_inscriptos WHERE dni = :dni LIMIT 1";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function get_nombre_evento_segun_id($id){
		include('conexion_pdo.php');
		$query_= " SELECT titulo FROM eventos WHERE fk_evento = :fk_evento";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_evento', $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['titulo'];
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

}
?>