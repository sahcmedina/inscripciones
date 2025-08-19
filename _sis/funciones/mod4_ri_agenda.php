<?php
date_default_timezone_set('America/Argentina/San_Juan');
class RI_Agenda {
	 
	function gets($tabla){
		include('conexion_pdo.php');
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
	function gets_fila_a_grabar($tabla, $emp_o){
		include('conexion_pdo.php');
		$query_  =" SELECT id FROM $tabla 
					WHERE id BETWEEN 2 AND 16
						AND :emp_o NOT IN (c1, c2, c3, c4, c5, c6, c7, c8, c9, c10)	
					";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':emp_o', $emp_o);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_empI($tabla){
		include('conexion_pdo.php');
		$query_  =" SELECT * FROM $tabla  WHERE id=1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}	
	function aux_gets_empI($tabla){

		// traigo la fila 1
		$arr = array();
		$arr = $this->gets_empI($tabla); 

		// me quedo con valores <> 0
		$arr_aux = array();
		//$ñ       = 1;
		for($i=0 ; $i<count($arr); $i++){
			$valor1 = $arr[$i]['c1']; 	if($valor1 != 0){ 	array_push($arr_aux, $valor1); }
			$valor2 = $arr[$i]['c2']; 	if($valor2 != 0){ 	array_push($arr_aux, $valor2); }
			$valor3 = $arr[$i]['c3']; 	if($valor3 != 0){ 	array_push($arr_aux, $valor3); }
			$valor4 = $arr[$i]['c4']; 	if($valor4 != 0){ 	array_push($arr_aux, $valor4); }
			$valor5 = $arr[$i]['c5']; 	if($valor5 != 0){ 	array_push($arr_aux, $valor5); }
			$valor6 = $arr[$i]['c6']; 	if($valor6 != 0){ 	array_push($arr_aux, $valor6); }
			$valor7 = $arr[$i]['c7']; 	if($valor7 != 0){ 	array_push($arr_aux, $valor7); }
			$valor8 = $arr[$i]['c8']; 	if($valor8 != 0){ 	array_push($arr_aux, $valor8); }
			$valor9 = $arr[$i]['c9']; 	if($valor9 != 0){ 	array_push($arr_aux, $valor9); }
			$valor10= $arr[$i]['c10']; 	if($valor10!= 0){ 	array_push($arr_aux, $valor10);}
		}
		return $arr_aux;
	}
	function gets_fila($tabla, $fila){
		include('conexion_pdo.php');
		$query_  =" SELECT * FROM $tabla WHERE id= $fila ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function gets_config($id_ri){
		include('conexion_pdo.php');
		$query_  =" SELECT * FROM eventos_ronda_inv_agenda_config WHERE fk_ri= :fk_ri ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_ri', $id_ri);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}


	function get_col($tabla, $dupla_i){
		include('conexion_pdo.php');
		$query_  ="	SELECT CONCAT_WS(', ', 
					IF(c1 = :dupla_i, 'c1', NULL),	   IF(c2 = :dupla_i, 'c2', NULL),	    IF(c3 = :dupla_i, 'c3', NULL),      IF(c4 = :dupla_i, 'c4', NULL),
					IF(c5 = :dupla_i, 'c5', NULL),	   IF(c6 = :dupla_i, 'c6', NULL),       IF(c7 = :dupla_i, 'c7', NULL),      IF(c8 = :dupla_i, 'c8', NULL),
					IF(c9 = :dupla_i, 'c9', NULL),     IF(c10= :dupla_i, 'c10', NULL)
				) AS col
				FROM $tabla
				WHERE  c1 = :dupla_i OR	c2 = :dupla_i OR c3 = :dupla_i OR c4 = :dupla_i OR c5 = :dupla_i OR c6 = :dupla_i OR c7 = :dupla_i OR c8 = :dupla_i OR c9 = :dupla_i OR c10= :dupla_i ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dupla_i', $dupla_i);
			$sql->execute();
			$res = $sql->fetch();
			return $res['col'];
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}	
	function get_fecha_config($id_ri){
		include('conexion_pdo.php');
		$query_  =" SELECT DATE_FORMAT(f_proceso, '%e/%c/%Y - %H:%i hs') AS fecha_f FROM eventos_ronda_inv_agenda_config WHERE fk_ri= :fk_ri ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_ri', $id_ri);
			$sql->execute();
			$res = $sql->fetch();
			return $res['fecha_f'];
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function add_i($tabla, $indice, $emp){
		include('conexion_pdo.php');
		$id = 1;
		switch($indice){
			case '1' :	$col='c1' ; break;
			case '2' :	$col='c2' ; break;
			case '3' :	$col='c3' ; break;
			case '4' :	$col='c4' ; break;
			case '5' :	$col='c5' ; break;
			case '6' :	$col='c6' ; break;
			case '7' :	$col='c7' ; break;
			case '8' :	$col='c8' ; break;
			case '9' :	$col='c9' ; break;
			case '10':	$col='c10'; break;
		}

		$query_= " UPDATE $tabla SET $col= :emp WHERE id= :id";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', 		$id);
			$sql->bindParam(':emp', 	$emp);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	
	function add_o($tabla, $col_i, $emp_o, $fila){
		include('conexion_pdo.php');
		$query_= " UPDATE $tabla SET $col_i= :emp_o WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':id',    $fila);
			$sql->bindParam(':emp_o', $emp_o);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function add_vista($nbreVista, $tablaOrigen){
		include('conexion_pdo.php');
		$query_  = "CREATE OR REPLACE VIEW $nbreVista AS
					SELECT * FROM $tablaOrigen "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function add_tabla($nbreTabla, $tablaOrigen){
		include('conexion_pdo.php');
		$query_  = "CREATE TABLE $nbreTabla AS
					SELECT * FROM $tablaOrigen "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function add_config($id_ri, $dia, $nbreVista, $f_proceso, $fk_user){
		include('conexion_pdo.php'); 
		if($dia== 1){  $dia1=1;		$dia2=0;	$view1=$nbreVista;		$view2='';					}
		else{	       $dia1=0;		$dia2=1;	$view1='';		        $view2=$nbreVista;			}
		$query= "INSERT INTO eventos_ronda_inv_agenda_config (fk_ri, dia1, dia2, view1, view2, f_proceso, fk_usuario) 
		         VALUES (:fk_ri, :dia1, :dia2, :view1, :view2, :f_proceso, :fk_usuario) ";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_ri', 	    $id_ri);
			$sql->bindParam(':dia1', 		$dia1);
			$sql->bindParam(':dia2',    	$dia2);
			$sql->bindParam(':view1',     	$view1);
			$sql->bindParam(':view2',     	$view2);
			$sql->bindParam(':f_proceso',   $f_proceso);
			$sql->bindParam(':fk_usuario',  $fk_user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function aux_inicializar($tabla){
		include('conexion_pdo.php');
		
		// 1 vacio
		$del = $this->aux_vaciar($tabla);
		
		// 2 inicializo (15 filas)
		for($i=1 ; $i<=16 ; $i++){
			$add = $this->aux_add_inicial($tabla, $i);
		} // con el for me aseguro que solo genera 16 registros.
	}
	function aux_vaciar($tabla){
		include('conexion_pdo.php');
		$query_  = " TRUNCATE TABLE $tabla "; // al borrar la tbl con el truncate coloca el id en 0
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function aux_delVista($tabla){
		include('conexion_pdo.php');
		$query_  = " DROP VIEW IF EXISTS $tabla "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function aux_delTabla($tabla){
		include('conexion_pdo.php');
		$query_  = " DROP TABLE $tabla "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function aux_addVista_OLD($tabla){
		include('conexion_pdo.php');
		$query_  = "CREATE VIEW $tabla AS
					SELECT 
						n.id, 0 as c1, 0 as c2, 0 as c3, 0 as c4, 0 as c5, 0 as c6, 0 as c7, 0 as c8, 0 as c9, 0 as c10
					FROM (
						SELECT 1 as id UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL
						SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL
						SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15 UNION ALL SELECT 16
					) n "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	
	function aux_copiar($tabla_destino, $tabla_origen){
		include('conexion_pdo.php');
		$query_  = " INSERT INTO $tabla_destino SELECT * FROM $tabla_origen "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function aux_add_inicial($tabla, $id){
		include('conexion_pdo.php');
		$null    = 0 ;
		$query_  = "INSERT INTO $tabla (id, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10)
		            VALUES (:id, :nul, :nul, :nul, :nul, :nul, :nul, :nul, :nul, :nul, :nul)"; // saco el campo id xq en la BD esta autoincremental
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',   $id);	
			$sql->bindParam(':nul',  $null);		
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function aux_upd_config($id_ri, $dia, $nbreVista, $f_proceso, $fk_user){
		
		$existe = $this->tf_existe_config($id_ri);
		if($existe){ $upd = $this->upd_config($id_ri, $dia, $nbreVista, $f_proceso, $fk_user);		$return= $upd; }
		else{		 $add = $this->add_config($id_ri, $dia, $nbreVista, $f_proceso, $fk_user);		$return= $add; }

		return $return;
	}
		
	function tf_esta_en_col($tabla, $col_i, $emp_o){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM $tabla WHERE $col_i = :emp_o AND id != 1 "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':emp_o',   $emp_o);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	function tf_filaOcupada($tabla, $col_i, $fila_aConsultar){
		include('conexion_pdo.php');		
		$query_  = " SELECT $col_i FROM $tabla WHERE id= :fila "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fila',   $fila_aConsultar);
			$sql->execute();
			$res = $sql->fetch();
			if ($res[$col_c] != 0) return true;
			else				   return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	function tf_existe_config($id_ri){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM eventos_ronda_inv_agenda_config WHERE fk_ri = :fk_ri "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_ri',   $id_ri);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}

	function upd_usar_tabla($nroTabla){
		include('conexion_pdo.php');		
		$col     = 't_'.$nroTabla;
		$query_  = " UPDATE aux_agenda_uso SET $col = 1 WHERE id= 1 "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_liberar_tabla($nroTabla){
		include('conexion_pdo.php');		
		$col     = 't_'.$nroTabla;
		$query_  = " UPDATE aux_agenda_uso SET $col = 0 WHERE id= 1 "; 
		try{
			$sql = $con->prepare($query_);			
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function upd_config($id_ri, $dia, $nbreVista, $f_proceso, $fk_user){
		include('conexion_pdo.php'); 
		if($dia== 1){  $col1='dia1';		$col2='view1';	}
		else{	       $col1='dia2';		$col2='view2';	}
		$query= " UPDATE eventos_ronda_neg_agenda_config SET $col1= :dia, $col2= :view, f_proceso= :f_proceso, fk_usuario= :fk_usuario
		          WHERE fk_ri= :fk_ri ";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_ri', 	    $id_ri);
			$sql->bindParam(':dia', 		$dia);
			$sql->bindParam(':view',     	$nbreVista);
			$sql->bindParam(':f_proceso',   $f_proceso);
			$sql->bindParam(':fk_usuario',  $fk_user);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function del_config($id_ri){	
		include('conexion_pdo.php'); 		
		$query_  = " DELETE FROM eventos_ronda_inv_agenda_config WHERE fk_ri= :fk_ri "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_ri',  $id_ri);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
	function del_union_io($id_ri){	
		include('conexion_pdo.php'); 		
		$query_  = " DELETE FROM eventos_ronda_inv_union_io WHERE fk_ri= :fk_ri "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_ri',  $id_ri);
			if($sql->execute())	$return= true;
			else				$return= false;
			return $return;
		}
		catch (Exception $e){ echo $e->getMessage();}
		finally{				$sql = null;		}
	}
}
?>