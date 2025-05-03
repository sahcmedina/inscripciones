<?php

class Capacitaciones {
	         
	function gets_all_capacitaciones_activas(){
		include('conexion_pdo.php');
		$query_= "  SELECT c.*, cat.id AS cat_id, cat.nombre AS cat_nombre, d.nombre AS depto_nombre, d.id AS depto_id, count(i.fk_capacitaciones) As cantidad
					FROM inscriptos_capacitacion AS i
					RIGHT JOIN capacitaciones AS c ON c.id = i.fk_capacitaciones
					INNER JOIN categoria AS cat    ON cat.id = c.fk_categorias
					INNER JOIN departamentos AS d  ON d.id = c.fk_departamento
					WHERE c.estado = 1
					GROUP BY c.id ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_capacitaciones_noVigentes(){
		include('conexion_pdo.php');
		$query_= " SELECT c.*, d.nombre AS depto_nombre 
		            FROM capacitaciones AS c		
						INNER JOIN departamentos AS d  ON d.id = c.fk_departamento 
					WHERE c.estado = 0 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_all_categorias(){
		include('conexion_pdo.php');
		$query_= " SELECT * FROM categoria ";
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
	function gets_all_requisitos(){
		include('conexion_pdo.php');
		$query_= " SELECT * FROM capacitaciones_requisitos ";
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
	function gets_capacitaciones_id(){
		include('conexion_pdo.php');
		$query_= " SELECT id FROM capacitaciones WHERE estado = 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['id'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_requisitos_de_un_curso($id){
		include('conexion_pdo.php');
		$query = " SELECT * FROM capacitaciones_requisitos WHERE fk_capacitaciones = :fk_capacitaciones  ";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_capacitaciones', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_departamentos(){
		include('conexion_pdo.php');
		$query_= "SELECT * FROM departamentos ";
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
	function gets_cantidad_cursos_x_categoria(){
		include('conexion_pdo.php');
		$query_= "SELECT count(*) AS cantidad, fk_categorias FROM capacitaciones group by fk_categorias ";
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
	function gets_inscriptos_por_id($id_curso){
		include('conexion_pdo.php');
		$query_= "SELECT i.dni, i.apellido, i.nombre, i.sexo, d.nombre AS nom_depto, i.dir_nro, dir_calle, i.correo, i.telefono, DATE_FORMAT(i.f_nacimiento, '%d/%m/%Y') AS f_nacimiento, ic.estado, 
		            e.nivel_alcanzado, e.titulo_especialidad, e.ocupacion, e.trabajo_actual, e.trabajo_actual_hs, e.conoce_rubro, e.capacit_ant, e.capacit_ant_cual, ir.extension, ln.id as ln_id, ln.f_ini, ln.f_fin, n.nota
				  FROM inscriptos AS i
					INNER JOIN departamentos AS d            	  ON i.fk_departamentos = d.id
					INNER JOIN inscriptos_capacitacion AS ic 	  ON i.dni = ic.fk_inscriptos 
					INNER JOIN capacitaciones AS c           	  ON c.id = ic.fk_capacitaciones
					INNER JOIN inscriptos_educacion AS e     	  ON e.dni = i.dni
					LEFT JOIN  inscriptos_requisitos AS ir   	  ON (ir.fk_persona = i.dni AND ir.fk_capacitacion = :id_curso)
					LEFT JOIN  inscriptos_lista_negra AS ln  	  ON i.dni = ln.fk_inscriptos
					LEFT JOIN  inscriptos_capacitacion_nota AS n  ON (ic.fk_capacitaciones = n.fk_capacitacion AND ic.fk_inscriptos=n.fk_inscriptos)
					WHERE c.id = :id_curso  AND ic.fk_capacitaciones = :id_curso AND ic.estado_capacitacion ='1' ";
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
	function gets_email_segun_estado($id_curso, $estado){
		include('conexion_pdo.php');
		$query_= "SELECT distinct(i.correo) email, i.dni
				    FROM inscriptos AS i
					INNER JOIN departamentos AS d ON i.fk_departamentos = d.id
					INNER JOIN inscriptos_capacitacion AS ic ON i.dni = ic.fk_inscriptos 
					INNER JOIN capacitaciones AS c ON c.id = ic.fk_capacitaciones
					INNER JOIN inscriptos_educacion AS e ON e.dni = i.dni
					LEFT  JOIN inscriptos_requisitos AS ir ON (ir.fk_persona = i.dni AND ir.fk_capacitacion = :id_curso )
					WHERE c.id = :id_curso AND ic.fk_capacitaciones = :id_curso AND ic.estado= :estado ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_curso', $id_curso);
			$sql->bindParam(':estado',   $estado);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_cantidad_inscriptos_x_curso(){
		include('conexion_pdo.php');
		$query_= "SELECT count(*) AS cantidad, c.id, c.fk_categorias, c.nombre, c.capacidad FROM inscriptos_capacitacion AS i 
					INNER JOIN capacitaciones AS c ON c.id = i.fk_capacitaciones
					GROUP BY i.fk_capacitaciones ";
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
	function gets_cantidad_aceptados_x_curso(){
		include('conexion_pdo.php');
		$query_= "SELECT count(*) AS cantidad, c.id, c.fk_categorias, c.nombre, c.capacidad FROM inscriptos_capacitacion AS i 
					INNER JOIN capacitaciones AS c ON c.id = i.fk_capacitaciones
					WHERE i.estado = 't'
					GROUP BY i.fk_capacitaciones ";
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
	function gets_emails_inscriptos_a_capacitacion($idCap){
		include('conexion_pdo.php');
		// $query_= " SELECT i.correo, ic.estado FROM inscriptos AS i INNER JOIN inscriptos_capacitacion AS ic
		// 			ON i.dni = ic.fk_inscriptos
		// 			WHERE ic.fk_capacitaciones = :id ";
		$query_= " SELECT i.correo, ic.estado 
				   FROM inscriptos AS i
					INNER JOIN departamentos AS d            	  ON i.fk_departamentos = d.id
					INNER JOIN inscriptos_capacitacion AS ic 	  ON i.dni = ic.fk_inscriptos 
					INNER JOIN capacitaciones AS c           	  ON c.id = ic.fk_capacitaciones
					INNER JOIN inscriptos_educacion AS e     	  ON e.dni = i.dni
					LEFT JOIN  inscriptos_requisitos AS ir   	  ON (ir.fk_persona = i.dni AND ir.fk_capacitacion = :id)
					LEFT JOIN  inscriptos_lista_negra AS ln  	  ON i.dni = ln.fk_inscriptos
					LEFT JOIN  inscriptos_capacitacion_nota AS n  ON (ic.fk_capacitaciones = n.fk_capacitacion AND ic.fk_inscriptos=n.fk_inscriptos)
					WHERE c.id = :id AND ic.fk_capacitaciones = :id AND ic.estado_capacitacion ='1' ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $idCap);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function gets_emails_inscriptos_a_capacitacion_segunEstado($idCap, $estado){
		include('conexion_pdo.php');
		// $query_= " SELECT i.correo FROM inscriptos AS i INNER JOIN inscriptos_capacitacion AS ic
		// 			ON i.dni = ic.fk_inscriptos
		// 			WHERE ic.fk_capacitaciones = :id AND ic.estado = :estado ";	
			$query_= " SELECT i.correo 
						FROM inscriptos AS i
						INNER JOIN departamentos AS d            	  ON i.fk_departamentos = d.id
						INNER JOIN inscriptos_capacitacion AS ic 	  ON i.dni = ic.fk_inscriptos 
						INNER JOIN capacitaciones AS c           	  ON c.id = ic.fk_capacitaciones
						INNER JOIN inscriptos_educacion AS e     	  ON e.dni = i.dni
						LEFT JOIN  inscriptos_requisitos AS ir   	  ON (ir.fk_persona = i.dni AND ir.fk_capacitacion = :id )
						LEFT JOIN  inscriptos_lista_negra AS ln  	  ON i.dni = ln.fk_inscriptos
						LEFT JOIN  inscriptos_capacitacion_nota AS n  ON (ic.fk_capacitaciones = n.fk_capacitacion AND ic.fk_inscriptos=n.fk_inscriptos)
						WHERE c.id = :id AND ic.fk_capacitaciones = :id AND ic.estado_capacitacion ='1' AND ic.estado = :estado ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $idCap);
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


	function add_curso($fk_categorias, $nombre, $institucion, $f_inicio, $capacidad, $cupo_ins, $duracion, $cant_enc, $ins_auto, $carga_hr, $lugar, $departamento, 
						$estado, $f_hs_creacion, $usuario, $f_inicio_ins, $f_fin_ins, $f_fin, $b64, $form_mostrar, $form_url, $web_duracion, $web_obj, $web_dictado_x, $web_cursado, $web_destinat){
		include('conexion_pdo.php');
		$mostrar_insc = 0;
		$nada         = ''; 
		$query= "INSERT INTO capacitaciones (fk_categorias, nombre, descripcion, institucion, f_inicio, capacidad, cupo_ins, duracion, insc_auto, cant_enc, carga_hr, lugar, fk_departamento, 
											 estado, f_hs_creacion, usuario, f_fin, f_inicio_ins, f_fin_ins, imagen, mostrar_form, mostrar_form_url, mostrar_insc, web_duracion, web_obj, web_dictado_x, web_cursado, web_destinat) 
						VALUES (:fk_categorias, :nombre, :descripcion, :institucion, :f_inicio, :capacidad, :cupo_ins, :duracion, :ins_auto, :cant_enc, :carga_hr, :lugar, :fk_departamento, 
								:estado, :f_hs_creacion, :usuario, :f_fin, :f_inicio_ins, :f_fin_ins, :imagen, :mostrar_form, :mostrar_form_url, :mostrar_insc, :web_duracion, :web_obj, :web_dictado_x, :web_cursado, :web_destinat)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_categorias',   $fk_categorias);
			
			$sql->bindParam(':nombre',  	    $nombre);
			$sql->bindParam(':institucion',  	$institucion);
			$sql->bindParam(':descripcion',     $nada);
			$sql->bindParam(':f_inicio',        $f_inicio);
			$sql->bindParam(':f_inicio_ins',    $f_inicio_ins);
			$sql->bindParam(':f_fin_ins',       $f_fin_ins);
			
			$sql->bindParam(':capacidad',       $capacidad);
			$sql->bindParam(':cupo_ins', 	    $cupo_ins);
			$sql->bindParam(':duracion',        $duracion);
			$sql->bindParam(':cant_enc', 	    $cant_enc);
			$sql->bindParam(':ins_auto', 	    $ins_auto);
			$sql->bindParam(':carga_hr', 	    $carga_hr);

			$sql->bindParam(':lugar',	        $lugar);
			$sql->bindParam(':fk_departamento', $departamento);
			$sql->bindParam(':estado', 	        $estado);
			$sql->bindParam(':f_hs_creacion',   $f_hs_creacion);
			$sql->bindParam(':usuario',  	    $usuario);

			$sql->bindParam(':f_fin',  	        $f_fin);

			$sql->bindParam(':imagen',	        $b64);
			$sql->bindParam(':web_duracion',	$web_duracion);
			$sql->bindParam(':web_obj',         $web_obj);
			$sql->bindParam(':web_dictado_x',   $web_dictado_x);
			$sql->bindParam(':web_cursado',     $web_cursado);
			$sql->bindParam(':web_destinat',    $web_destinat);

			$sql->bindParam(':mostrar_form',   $form_mostrar);
			$sql->bindParam(':mostrar_form_url',   $form_url);
			$sql->bindParam(':mostrar_insc',   $mostrar_insc);

			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }				
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function add_requisitos_curso($id, $requisito){
		include('conexion_pdo.php');
		$query= "INSERT INTO capacitaciones_requisitos (descripcion, fk_capacitaciones) VALUES (:descripcion, :fk_capacitaciones)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_capacitaciones', $id);
			$sql->bindParam(':descripcion',       $requisito);
			if($sql->execute())	{ $return = true;  }
			else				{ $return = false; }				
			$sql = null;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function add_dia_y_hora($id, $dia, $hs_desde, $hs_hasta){
		include('conexion_pdo.php');
		$query= "INSERT INTO capacitaciones_hs (fk_capacitaciones, dia, hs_desde, hs_hasta) 
						VALUES                 (:fk_capacitaciones, :dia, :hs_desde, :hs_hasta)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_capacitaciones', $id);
			$sql->bindParam(':dia',               $dia);
			$sql->bindParam(':hs_desde',          $hs_desde);
			$sql->bindParam(':hs_hasta',  	      $hs_hasta);
			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }	
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function add_categoria_nueva($nombre){
		include('conexion_pdo.php');
		$query= "INSERT INTO categoria (nombre) VALUES (:nombre)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':nombre', $nombre);
			if($sql->execute())	{ $return = true;  }
			else				{ $return = false; }
			return $return;	
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}		
		catch (Exception $e){	echo $e->getMessage();	}		
		finally{				$sql = null;			}		
	}
	function add_lote_emailEnviados($capacit, $msj, $msj_pie, $estado, $id_usr, $cant_enviar){
		include('conexion_pdo.php');
		$id_lote  = $this->get_next_id_loteEmailEnviados();
		$fecha_hs = Date('Y-m-d H:i:s');
		$query= "INSERT INTO inscriptos_capacitacion_email_lote (id, fk_capacitaciones, msj, pie, estado, fk_usuario, fecha_hs, cant_enviados) 
		         VALUES (:id, :fk_capacitaciones, :msj, :pie, :estado, :fk_usuario, :fecha_hs, :cant_enviados)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',         	        $id_lote);
			$sql->bindParam(':fk_capacitaciones', 	$capacit);
			$sql->bindParam(':msj', 				$msj);
			$sql->bindParam(':pie', 				$msj_pie);
			$sql->bindParam(':estado', 				$estado);
			$sql->bindParam(':fk_usuario', 			$id_usr);
			$sql->bindParam(':fecha_hs', 			$fecha_hs);
			$sql->bindParam(':cant_enviados', 		$cant_enviar);
			if($sql->execute())	{ $return = $id_lote;	}
			else				{ $return = 0; 			}	
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function add_cuerpo_emailEnviados($id_lote, $res, $dni, $email){
		include('conexion_pdo.php');
		$id_lote  = $this->get_next_id_loteEmailEnviados();
		$fecha_hs = Date('Y-m-d H:i:s');
		$query= "INSERT INTO inscriptos_capacitacion_email_cuerpo (fk_lote, estado_envio, fk_inscripto, email) 
		         VALUES (:fk_lote, :estado_envio, :fk_inscripto, :email)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_lote', 	 $id_lote);
			$sql->bindParam(':estado_envio', $res);
			$sql->bindParam(':fk_inscripto', $dni);
			$sql->bindParam(':email',        $email);
			if($sql->execute())	{ $return = true;	}
			else				{ $return = false; 	}	
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}

	
	function get_last_id(){
		include('conexion_pdo.php');
		$query_= " SELECT id FROM capacitaciones ORDER BY id DESC LIMIT 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['id'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_next_id_loteEmailEnviados(){	
		include('conexion_pdo.php');
		$query_= " SELECT max(id) as id FROM inscriptos_capacitacion_email_lote ";
		try{
			$sql = $con->prepare($query_);
			if($sql->execute()){	$res   = $sql->fetch(); $return= $res['id'] + 1;	}
			else					$return= 1;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function get_tiene_penalizacion($dni){
		include('conexion_pdo.php');		
		$query_= " SELECT * FROM inscriptos_lista_negra WHERE  fk_inscriptos= :dni and DATE(f_fin) <= CURDATE() ";	
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
	function get_datos_curso_x_id($id_curso){
		include('conexion_pdo.php');
		$query_= "SELECT * FROM capacitaciones where id = :id_curso ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_curso',  	  $id_curso);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_nbreCapacit($id_capacit){
		include('conexion_pdo.php');		
		$query_= " SELECT nombre FROM capacitaciones WHERE id = :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id_capacit);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['nombre'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_FechaFinInsc($id_capacit){
		include('conexion_pdo.php');		
		$query_= " SELECT f_fin_ins FROM capacitaciones WHERE id = :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id_capacit);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['f_fin_ins'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_imagen_de_un_curso($id){
		include('conexion_pdo.php');
		$query_= " SELECT imagen FROM capacitaciones WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['imagen'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_cant_isncriptos_segun_estado_x_curso($id_curso, $estado){
		// revisar x q no muestra informacion real...
		// revisar x q no muestra informacion real...
		// revisar x q no muestra informacion real...
		include('conexion_pdo.php');
		$query_= " SELECT count(*) AS cantidad FROM inscriptos_capacitacion WHERE fk_capacitaciones = :fk_capacitaciones AND estado = :estado ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_capacitaciones', $id_curso);
			$sql->bindParam(':estado',  	      $estado);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['cantidad'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_cant_inscriptos_por_id($id_curso){
		include('conexion_pdo.php');
		$query_= "SELECT count(*) as cant
				    FROM inscriptos AS i
					INNER JOIN departamentos AS d ON i.fk_departamentos = d.id
					INNER JOIN inscriptos_capacitacion AS ic ON i.dni = ic.fk_inscriptos 
					INNER JOIN capacitaciones AS c ON c.id = ic.fk_capacitaciones
					INNER JOIN inscriptos_educacion AS e ON e.dni = i.dni
					LEFT  JOIN inscriptos_requisitos AS ir ON (ir.fk_persona = i.dni AND ir.fk_capacitacion = :id_curso)
					WHERE c.id = :id_curso AND ic.fk_capacitaciones = :id_curso AND ic.estado_capacitacion ='1'";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_curso', $id_curso);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['cant'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function get_last_id_categoria(){
		include('conexion_pdo.php');
		$query_= " SELECT id FROM categoria ORDER BY id DESC LIMIT 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['id'];
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	
	         
	function del_curso_cambia_estado($id, $estado, $f_hs_creacion, $usuario){
		// no es una consulta para borrar sino que ectualiza estado para no mostrar despues.
		include('conexion_pdo.php');
		$query_= " UPDATE capacitaciones SET estado= :estado, f_hs_creacion= :f_hs_creacion, usuario= :usuario WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':estado',  	  $estado);
			$sql->bindParam(':usuario',       $usuario);
			$sql->bindParam(':f_hs_creacion', $f_hs_creacion);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function del_curso($id){
		include('conexion_pdo.php');
		$query_= " DELETE FROM capacitaciones WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function del_requisitos($id){
		include('conexion_pdo.php');
		$query_= " DELETE FROM capacitaciones_requisitos WHERE fk_capacitaciones= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function del_requisito_($id_req){
		include('conexion_pdo.php');
		$query_= " DELETE FROM capacitaciones_requisitos WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id_req);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;	
	}
	

	function upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr){
		include('conexion_pdo.php');
		$query_= " UPDATE inscriptos_capacitacion SET estado= :estado, f_resuelto= :f_resuelto, fk_usuario= :fk_usuario
					WHERE fk_capacitaciones= :fk_capacitaciones AND fk_inscriptos = :fk_inscriptos ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_capacitaciones', $id_curso);
			$sql->bindParam(':fk_inscriptos',  	  $dni);
			$sql->bindParam(':estado',  	      $estado);
			$sql->bindParam(':fk_usuario',        $usr);
			$sql->bindParam(':f_resuelto',        $f_resuelto);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function upd_estado_restoPreInscripc($dni, $id_curso){
		$estado    = 'b';
		$estado_cap= '1';
		$f_resuelto= Date('Y-m-d H:i:s');
		include('conexion_pdo.php');
		$query_= " UPDATE inscriptos_capacitacion SET estado= :estado, f_resuelto= :f_resuelto
					WHERE fk_capacitaciones != :fk_capacitaciones AND fk_inscriptos = :fk_inscriptos AND estado_capacitacion = :estado_capacitacion ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_capacitaciones', 	$id_curso);
			$sql->bindParam(':fk_inscriptos',  	  	$dni);
			$sql->bindParam(':estado',  	      	$estado);
			$sql->bindParam(':f_resuelto',        	$f_resuelto);
			$sql->bindParam(':estado_capacitacion', $estado_cap);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function upd_a_historico($id){
		include('conexion_pdo.php');
		$estado= 0;
		$query_= " UPDATE capacitaciones SET estado= :estado WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->bindParam(':estado', $estado);
			if($sql->execute())	$return= true;
			else				$return= false;	
			return $return;								
			}
		catch (Exception $e){	echo $e->getMessage();	}
		finally{				$sql = null;			}
	}
	function upd_datos_curso_mostrar_web($id_curso, $usuario, $web_descrip, $web_duracion){
		include('conexion_pdo.php');
		$query_= " UPDATE capacitaciones SET usuario = :usuario, web_descrip= :web_descrip, web_duracion = :web_duracion
					WHERE id = :id_curso ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_curso',     $id_curso);
			$sql->bindParam(':usuario',      $usuario);
			//$sql->bindParam(':web_nombre',   $web_nombre);
			$sql->bindParam(':web_descrip',  $web_descrip);
			$sql->bindParam(':web_duracion', $web_duracion);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}	         
	function upd_curso($id_curso, $fk_categorias, $nombre, $institucion, $descripcion, $f_inicio, $capacidad, $cupo_ins, $duracion, $cant_enc, $carga_hr, $lugar, $departamento, $f_inicio_ins, $f_fin_ins, $f_fin, $b64, $form_mostrar, $form_url, $web_duracion, $web_obj, $web_dictado_x, $web_cursado, $web_destinat){
		include('conexion_pdo.php');
		$query_= " UPDATE capacitaciones SET 
						fk_categorias = :fk_categorias,
						
						nombre        = :nombre,
			            descripcion   = :descripcion,
						institucion   = :institucion,
						f_inicio      = :f_inicio,
						capacidad     = :capacidad,
						cupo_ins      = :cupo_ins,
						duracion      = :duracion,
						cant_enc      = :cant_enc, 
						carga_hr      = :carga_hr,
						lugar         = :lugar,
						fk_departamento = :fk_departamento,
						f_fin         = :f_fin,
						f_inicio_ins  = :f_inicio_ins,
						f_fin_ins     = :f_fin_ins,
						
						imagen        = :imagen,
						web_duracion  = :web_duracion,     
						web_obj       = :web_obj,
						web_dictado_x = :web_dictado_x,
						web_cursado   = :web_cursado,
						web_destinat  = :web_destinat,

						mostrar_form  = :mostrar_form,
						mostrar_form_url = :mostrar_form_url
					WHERE id = :id_curso ";
		try{
			$sql = $con->prepare($query_);

			$sql->bindParam(':id_curso',        $id_curso);
			$sql->bindParam(':fk_categorias',   $fk_categorias);
			
			$sql->bindParam(':nombre',  	    $nombre);
			$sql->bindParam(':institucion',  	$institucion);
			$sql->bindParam(':descripcion',     $descripcion);
			$sql->bindParam(':f_inicio',        $f_inicio);
			$sql->bindParam(':f_inicio_ins',    $f_inicio_ins);
			$sql->bindParam(':f_fin_ins',       $f_fin_ins);
			
			$sql->bindParam(':capacidad',       $capacidad);
			$sql->bindParam(':cupo_ins', 	    $cupo_ins);
			$sql->bindParam(':duracion',        $duracion);
			$sql->bindParam(':cant_enc', 	    $cant_enc);
			$sql->bindParam(':carga_hr', 	    $carga_hr);

			$sql->bindParam(':lugar',	        $lugar);
			$sql->bindParam(':fk_departamento', $departamento);
			
			$sql->bindParam(':f_fin',  	        $f_fin);
			
			$sql->bindParam(':imagen',  	    $b64);
			$sql->bindParam(':web_duracion',    $web_duracion);
			$sql->bindParam(':web_obj', 		$web_obj);
			$sql->bindParam(':web_dictado_x', 	$web_dictado_x);
			$sql->bindParam(':web_cursado', 	$web_cursado);
			$sql->bindParam(':web_destinat', 	$web_destinat);

			$sql->bindParam(':mostrar_form',    $form_mostrar);
			$sql->bindParam(':mostrar_form_url',$form_url);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	function upd_requisito($id, $descripcion){
		include('conexion_pdo.php');
		$query_= " UPDATE capacitaciones_requisitos SET descripcion = :descripcion WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->bindParam(':descripcion',      $descripcion);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}
	
	
	function habilitar_curso($id){
		include('conexion_pdo.php');
		$query_= " UPDATE capacitaciones SET mostrar_insc = '1' WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}

	function mdf_estado_formInscripcion($id, $estado){
		include('conexion_pdo.php');
		$query_= " UPDATE capacitaciones SET mostrar_insc = :estado WHERE id = :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',     $id);
			$sql->bindParam(':estado', $estado);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){			
			echo $e->getMessage();
		}
		return $return;
	}

	
}
?>