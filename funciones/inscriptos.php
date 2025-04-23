<?php

class Inscriptos {

	function gets_requisito($dni, $tipo){
		include('conexion_pdo.php');		
		$query_  = " SELECT archivo, extension FROM inscriptos_requisitos WHERE fk_persona= :dni AND requisito = :requisito "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',       $dni);
			$sql->bindParam(':requisito', $tipo);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_requisito_x_capacit($dni, $id_curso, $tipo){
		include('conexion_pdo.php');		
		$query_  = " SELECT archivo, extension FROM inscriptos_requisitos WHERE fk_persona= :dni AND requisito = :requisito AND fk_capacitacion = :fk_cap "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',       $dni);
			$sql->bindParam(':requisito', $tipo);
			$sql->bindParam(':fk_cap',    $id_curso);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_lista_negra(){
		include('conexion_pdo.php');
		$hoy     = Date('Y-m-d');		
		$query_  = " SELECT ln.*, c.nombre AS capaci, ins.dni, ins.apellido, ins.nombre, ins.correo, ins.telefono, d.nombre AS dpto_cap, d2.nombre AS dpto_pers
		             FROM inscriptos_lista_negra AS ln					 
				   		INNER JOIN capacitaciones AS c    ON ln.fk_capacitaciones = c.id				   		  
				   		INNER JOIN inscriptos AS ins      ON ln.fk_inscriptos = ins.dni
				   		INNER JOIN departamentos AS d     ON c.fk_departamento = d.id
				   		LEFT  JOIN departamentos AS d2    ON ins.fk_departamentos = d.id
		             WHERE :hoy >= ln.f_ini AND :hoy <= ln.f_fin "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':hoy',       $hoy);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_titulares_sin_nota($id_curso){
		include('conexion_pdo.php');	
		$query_  = " SELECT i.dni, i.apellido, i.nombre, i.sexo, d.nombre AS nom_depto, i.dir_nro, dir_calle, i.correo, i.telefono, DATE_FORMAT(i.f_nacimiento, '%d/%m/%Y') AS f_nacimiento, ic.estado, 
		            e.nivel_alcanzado, e.titulo_especialidad, e.ocupacion, e.trabajo_actual, e.trabajo_actual_hs, e.conoce_rubro, e.capacit_ant, e.capacit_ant_cual, ir.extension, ln.id as ln_id, ln.f_ini, ln.f_fin, n.nota
				  FROM inscriptos AS i
					INNER JOIN departamentos AS d                 ON i.fk_departamentos = d.id
					INNER JOIN inscriptos_capacitacion AS ic      ON i.dni = ic.fk_inscriptos 
					INNER JOIN capacitaciones AS c                ON c.id = ic.fk_capacitaciones
					INNER JOIN inscriptos_educacion AS e          ON e.dni = i.dni
					LEFT JOIN  inscriptos_requisitos AS ir        ON (ir.fk_persona = i.dni AND ir.fk_capacitacion = :id_curso)
					LEFT JOIN  inscriptos_lista_negra AS ln       ON i.dni = ln.fk_inscriptos
					LEFT JOIN  inscriptos_capacitacion_nota AS n  ON (ic.fk_capacitaciones = n.fk_capacitacion AND ic.fk_inscriptos = n.fk_inscriptos)
					WHERE c.id = :id_curso AND ic.fk_capacitaciones = :id_curso AND ic.estado_capacitacion ='1' AND ic.estado='t' "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':id_curso', $id_curso);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_datsPersInscripto($dni){				
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM inscriptos WHERE dni= :dni ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}
	function gets_datsPersInscriptoEducacion($dni){				
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM inscriptos_educacion WHERE dni= :dni ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}
	function gets_titulares_cursando(){				
		include('conexion_pdo.php');	
		$hoy     = Date('Y-m-d');
		$query_  = " SELECT c.id, c.nombre, c.f_inicio, c.f_fin, count(c.id) as cant, d.nombre as depto 
		             FROM capacitaciones AS c
		                  INNER JOIN inscriptos_capacitacion AS ic ON c.id = ic.fk_capacitaciones
		 				  INNER JOIN departamentos AS d            ON c.fk_departamento = d.id
					 WHERE ic.estado= 't' AND :hoy >= c.f_inicio AND :hoy <= c.f_fin
					 GROUP BY c.id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':hoy', $hoy);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}
	
	function get_cant_ln(){
		include('conexion_pdo.php');
		$hoy   = Date('Y-m-d');
		$query_= " SELECT count(*) AS cantidad 
		           FROM inscriptos_lista_negra AS ln 
		           WHERE :hoy >= ln.f_ini AND :hoy <= ln.f_fin ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':hoy',  $hoy);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['cantidad'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_cant_titulares_cursando(){
		include('conexion_pdo.php');
		$hoy   = Date('Y-m-d');
		$query_= " SELECT  count(*) as cant FROM capacitaciones AS c
		           INNER JOIN inscriptos_capacitacion AS ic ON c.id = ic.fk_capacitaciones		 
				   WHERE ic.estado= 't' AND :hoy >= c.f_inicio AND :hoy <= c.f_fin ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':hoy',  $hoy);
			$sql->execute();
			$res = $sql->fetch();
			return $res['cant'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
		finally{				$sql = null;			}
	}

	function add_listaNegra($dni, $id_curso, $f_hoy, $f_fin, $usr){
		include('conexion_pdo.php');
		$estado = 1;
		$query  = "INSERT INTO inscriptos_lista_negra (fk_inscriptos, fk_capacitaciones, estado, f_ini, f_fin, fk_user) 
		           VALUES (:fk_inscriptos, :fk_capacitaciones, :estado, :f_ini, :f_fin, :fk_user)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_inscriptos', 	  	$dni);
			$sql->bindParam(':fk_capacitaciones', 	$id_curso);
			$sql->bindParam(':estado', 			  	$estado);
			$sql->bindParam(':f_ini', 				$f_hoy);
			$sql->bindParam(':f_fin', 				$f_fin);
			$sql->bindParam(':fk_user', 			$usr);
			if($sql->execute())	{ $return = true;  }
			else				{ $return = false; }	
		}
		catch (Exception $e){	echo $e->getMessage();	}		
		finally{				$sql = null;			}
	}
	function add_nota( $id_curso, $dni, $nota, $id_user){
		include('conexion_pdo.php');
		$query  = "INSERT INTO inscriptos_capacitacion_nota ( fk_capacitacion, fk_inscriptos, nota, fk_usuario) 
		           VALUES (:fk_capacitacion, :fk_inscriptos, :nota, :fk_usuario)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_capacitacion', 	$id_curso);
			$sql->bindParam(':fk_inscriptos', 	  	$dni);
			$sql->bindParam(':nota', 			  	$nota);
			$sql->bindParam(':fk_usuario', 			$id_user);
			if($sql->execute())	{ $return = true;  }
			else				{ $return = false; }	
		}
		catch (Exception $e){	echo $e->getMessage();	}		
		finally{				$sql = null;			}
	}	
	       
	function tf_req_CN($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM inscriptos_requisitos WHERE fk_persona= :dni AND requisito = 'Certificacion Negativa' "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',   $dni);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	function aux_gets_dniRepetidosEn_inscripReq(){	
		// trae los DNI repetidos en tabla inscriptos_requisitos para revisar aquellos repetidos 			
		include('conexion_pdo.php');		
		$query_  = " SELECT fk_persona, count(fk_persona) c FROM inscriptos_requisitos GROUP BY fk_persona having c >1 ORDER BY c DESC";	
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
	function aux_inscRepetidas($dni, $id_capacit){	
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM inscriptos_requisitos WHERE fk_persona= :dni AND fk_capacitacion= :id_cap ";	
		try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':dni',    $dni);
			$sql->bindParam(':id_cap', $id_capacit);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}

	function get_anotados($id_capacitacion){ 
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM inscriptos_capacitacion WHERE fk_capacitaciones= :id AND (estado='n' OR estado='t' OR estado='s') "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':id', $id_capacitacion);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['cant'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function tf_inscripto_requisito($dni, $idCapacit){
		include('conexion_pdo.php');		
		$query_= " SELECT count(*) as cant FROM inscriptos_requisitos WHERE fk_persona= :dni AND fk_capacitacion = :id LIMIT 1 "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni', $dni);
			$sql->bindParam(':id',  $idCapacit);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_cupo($id_capacitacion){ 
		include('conexion_pdo.php');		
		$query_  = " SELECT cupo_ins FROM capacitaciones WHERE id= :id "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':id', $id_capacitacion);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['cupo_ins'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function tf_existeInscripto($dni){
		include('conexion_pdo.php');		
		$query_= " SELECT count(*) as cant FROM inscriptos WHERE dni= :dni AND token_validado = 1 "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',   $dni);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function tf_inscriptoEnCapacitVigente($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant  FROM inscriptos_capacitacion 
				   WHERE fk_inscriptos= :dni AND estado_capacitacion > 0 "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',   $dni);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	function upd_datsPersonales_x_sistema($dni, $apellido, $nombre, $telefono, $sexo, $f_nacimiento, $fk_departamentos, $dir_calle, $dir_nro, $correo){
		include('conexion_pdo.php');
		$query_  = " UPDATE inscriptos 
		             SET apellido= :ape, nombre= :nom, sexo= :sexo, fk_departamentos= :dpto, dir_nro= :nro, dir_calle= :calle, correo= :correo, telefono= :tel, f_nacimiento= :nac  
		             WHERE dni = :dni ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':ape',    	$apellido);			
			$sql->bindParam(':nom', 	$nombre);			
			$sql->bindParam(':tel',     $telefono);
			$sql->bindParam(':sexo', 	$sexo);
			$sql->bindParam(':nac',     $f_nacimiento);
			$sql->bindParam(':dpto',    $fk_departamentos);						
			$sql->bindParam(':calle',  	$dir_calle);			
			$sql->bindParam(':nro', 	$dir_nro);			
			$sql->bindParam(':correo', 	$correo);			
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function upd_datsEducacion_x_sistema($dni, $nivel_alcanzado, $titulo, $ocupacion, $trabajo_actual, $hs_trabajo, $posee_conocim_rubro, $capacit_ant, $capacit_ant_cual){
		include('conexion_pdo.php');
		$query_  = " UPDATE inscriptos_educacion 
		             SET nivel_alcanzado= :niv, titulo_especialidad= :tit, ocupacion= :ocu, trabajo_actual= :trab, trabajo_actual_hs= :hs_tr, conoce_rubro= :cono, capacit_ant= :cap_ant, capacit_ant_cual= :cap_cual
		             WHERE dni = :dni ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':niv',    	$nivel_alcanzado);			
			$sql->bindParam(':tit', 	$titulo);			
			$sql->bindParam(':ocu',     $ocupacion);
			$sql->bindParam(':trab', 	$trabajo_actual);
			$sql->bindParam(':hs_tr',   $hs_trabajo);
			$sql->bindParam(':cono',    $posee_conocim_rubro);						
			$sql->bindParam(':cap_ant', $capacit_ant);
			$sql->bindParam(':cap_cual', $capacit_ant_cual);			
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}
	function upd_req_a_inscrip($dni, $idCapacit, $certificacion, $archivo_b64, $extension){
		include('conexion_pdo.php');
		$query_  = " UPDATE inscriptos_requisitos 
		             SET fk_capacitacion= :id, requisito= :cer, archivo= :arc, extension= :ext
		             WHERE fk_persona= :dni and fk_capacitacion = :id";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':id',    	$idCapacit);			
			$sql->bindParam(':cer', 	$certificacion);			
			$sql->bindParam(':arc',     $archivo_b64);
			$sql->bindParam(':ext', 	$extension);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}
	function upd_nota($dni, $idCapacit, $nota){
		include('conexion_pdo.php');
		$query_  = " UPDATE inscriptos_capacitacion_nota SET nota= :nota WHERE fk_inscriptos= :dni and fk_capacitacion = :id";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',  $dni);			
			$sql->bindParam(':id',   $idCapacit);			
			$sql->bindParam(':nota', $nota);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}

	function add_datsPersonales_x_sistema($dni, $apellido, $nombre, $telefono, $sexo, $f_nacimiento, $fk_departamentos, $dir_calle, $dir_nro, $correo){
		include('conexion_pdo.php');
		$token_valido = 1;
		$query= "INSERT INTO inscriptos (dni, apellido, nombre, sexo, fk_departamentos, dir_nro, dir_calle, correo, telefono, token_valido, f_nacimiento) 
								VALUES  (:dni, :ape, :nom, :sexo, :dpto, :nro, :calle, :correo, :tel, :tkn, :nac)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':ape',    	$apellido);			
			$sql->bindParam(':nom', 	$nombre);			
			$sql->bindParam(':tel',     $telefono);
			$sql->bindParam(':sexo', 	$sexo);
			$sql->bindParam(':nac',     $f_nacimiento);
			$sql->bindParam(':tkn',    $token_valido);
			$sql->bindParam(':dpto',    $fk_departamentos);						
			$sql->bindParam(':calle',  	$dir_calle);			
			$sql->bindParam(':nro', 	$dir_nro);			
			$sql->bindParam(':correo', 	$correo);
			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }	
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function add_datsEducacion_x_sistema($dni, $nivel_alcanzado, $titulo, $ocupacion, $trabajo_actual, $hs_trabajo, $posee_conocim_rubro, $capacit_ant, $capacit_ant_cual){
		include('conexion_pdo.php');
		$query_ = " INSERT INTO inscriptos_educacion (dni, nivel_alcanzado, titulo_especialidad, ocupacion, trabajo_actual, trabajo_actual_hs, conoce_rubro, capacit_ant, capacit_ant_cual) 
											VALUES (:dni, :niv, :tit, :ocu, :trab, :hs_tr, :cono, :cap_ant, :cap_cual)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':niv',    	$nivel_alcanzado);			
			$sql->bindParam(':tit', 	$titulo);			
			$sql->bindParam(':ocu',     $ocupacion);
			$sql->bindParam(':trab', 	$trabajo_actual);
			$sql->bindParam(':hs_tr',   $hs_trabajo);
			$sql->bindParam(':cono',    $posee_conocim_rubro);						
			$sql->bindParam(':cap_ant', $capacit_ant);
			$sql->bindParam(':cap_cual', $capacit_ant_cual);			
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function add_req_a_inscrip($dni, $idCapacit, $certificacion, $archivo_b64, $extension){
		include('conexion_pdo.php');
		$query_  = " INSERT INTO inscriptos_requisitos (fk_persona, fk_capacitacion, requisito, archivo, extension)
		             VALUE (:dni, :id, :cer, :arc, :ext)";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':id',    	$idCapacit);			
			$sql->bindParam(':cer', 	$certificacion);			
			$sql->bindParam(':arc',     $archivo_b64);
			$sql->bindParam(':ext', 	$extension);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}

	function add_inscriptoACapacit_x_sistema($dni, $id_curso, $tipo_ins, $f_resuelto, $usr, $estado_capacitacion){
		include('conexion_pdo.php');
		$query_ = " INSERT INTO inscriptos_capacitacion (fk_inscriptos, fk_capacitaciones, estado, f_resuelto, fk_usuario, estado_capacitacion) 
											VALUES (:dni, :id, :est, :res, :usr, :est_ca)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    	$dni);			
			$sql->bindParam(':id',    	$id_curso);			
			$sql->bindParam(':est', 	$tipo_ins);			
			$sql->bindParam(':res',     $f_resuelto);
			$sql->bindParam(':usr', 	$usr);
			$sql->bindParam(':est_ca',  $estado_capacitacion);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	//------------------ AGREGUE DESDE ACA 08-10-2024 ----------------
	function tf_existeInscripto_en_capacitacion($dni, $id_curso){
		include('conexion_pdo.php');
		$query_  = " SELECT COUNT(*) as cantidad FROM inscriptos_capacitacion 
		WHERE fk_inscriptos= :dni AND fk_capacitaciones= :id AND estado ='t' AND estado_capacitacion ='1' LIMIT 1  "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);			
			$sql->bindParam(':id',  $id_curso);			
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cantidad']>0) return true;
			else				    return false;
		}
		catch (Exception $e){ echo $e->getMessage(); }
		finally { $sql = null; }	
	}

	function tf_ya_tiene_nota($dni, $id_curso){
		include('conexion_pdo.php');
		$query_  = " SELECT COUNT(*) as cantidad FROM inscriptos_capacitacion_nota 
		WHERE fk_inscriptos= :dni AND fk_capacitacion= :id LIMIT 1  "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);			
			$sql->bindParam(':id',  $id_curso);			
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cantidad']>0) return true;
			else				    return false;
		}
		catch (Exception $e){ echo $e->getMessage(); }
		finally { $sql = null; }
	}
	         
	function del_reg_errores_de_notas($id_curso){
		include('conexion_pdo.php');
		$query_  = " DELETE FROM inscriptos_capacitacion_notas_error 
		             WHERE fk_capacitacion = :fk_capacitacion ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_capacitacion', $id_curso);			
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage(); }
		finally { $sql = null; }
	}

	function add_error_asignar_nota($id_curso, $dni, $motivo){
		include('conexion_pdo.php');
		$query_ = " INSERT INTO inscriptos_capacitacion_notas_error (fk_capacitacion, fk_inscripto, motivo) 
						 VALUES (:capacitacion, :inscripto, :motivo)";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':inscripto',    $dni);			
			$sql->bindParam(':capacitacion', $id_curso);			
			$sql->bindParam(':motivo', 		 $motivo);			
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage(); }
		finally { $sql = null; }
	}
	function gets_errores_capacitacion($id_curso){
		include('conexion_pdo.php');
		$query_ = " SELECT * FROM inscriptos_capacitacion_notas_error WHERE fk_capacitacion= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id_curso);			
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); }
		finally { $sql = null; }
	}
	function gets_titulares_con_sin_notas($id_curso){
		include('conexion_pdo.php');
		$query_ = "SELECT i.dni, upper(CONCAT(i.apellido, ' ', i.nombre)) AS inscripto_nom, i.telefono, i.correo, d.nombre, icn.nota
					FROM inscriptos_capacitacion AS ic
					LEFT JOIN inscriptos_capacitacion_nota AS icn ON ic.fk_inscriptos = icn.fk_inscriptos
					INNER JOIN inscriptos AS i ON i.dni = ic.fk_inscriptos
					INNER JOIN departamentos AS d ON i.fk_departamentos = d.id
					WHERE ic.fk_capacitaciones = '59' AND ic.estado = 't'";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id_curso);			
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); }
		finally { $sql = null; }
	}
}
?>