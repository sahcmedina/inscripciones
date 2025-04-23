<?php

class Concurso_int {
	         
	function gets(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_concurso_int_parametros order by id DESC ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function gets_nombres_archivos($id){
		include('conexion_pdo.php');
		$query_  = " SELECT reglamento_es, reglamento_en FROM web_concurso_int_parametros WHERE id= :id ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;                }
	}

	function upd_concurso($id, $habilitar, $deshabilitar, $mostrar_jurado, $mostrar_ganadores, $reglamento_es, $reglamento_en){
		include('conexion_pdo.php');				
		$query_  = " UPDATE web_concurso_int_parametros SET habilitar= :habilitar, deshabilitar= :deshabilitar, mostrar_jurado= :mostrar_jurado, 
		                                                    mostrar_ganadores= :mostrar_ganadores, reglamento_es= :reglamento_es, reglamento_en= :reglamento_en  
		             WHERE id= :id"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':habilitar', $habilitar);
			$sql->bindParam(':deshabilitar', $deshabilitar);
			$sql->bindParam(':mostrar_jurado', $mostrar_jurado);
			$sql->bindParam(':mostrar_ganadores', $mostrar_ganadores);
			$sql->bindParam(':reglamento_es', $reglamento_es);
			$sql->bindParam(':reglamento_en', $reglamento_en);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	
	function get($id){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM web_concurso_int_parametros WHERE id= :id ";
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

	function get_ultimo_id_insert(){
		include('conexion_pdo.php');				
		$query_  = " SELECT MAX(id) as id FROM web_concurso_int_parametros "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			return $res['id'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function add($habilitar, $deshabilitar, $mostrar_jurado, $mostrar_ganadores, $reglamento_es, $reglamento_en){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO web_concurso_int_parametros (habilitar, deshabilitar, mostrar_jurado, mostrar_ganadores, reglamento_es, reglamento_en) 
		         VALUES (:habilitar, :deshabilitar, :mostrar_jurado, :mostrar_ganadores, :reglamento_es, :reglamento_en)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':habilitar', $habilitar);
			$sql->bindParam(':deshabilitar', $deshabilitar);
			$sql->bindParam(':mostrar_jurado', $mostrar_jurado);
			$sql->bindParam(':mostrar_ganadores', $mostrar_ganadores);
			$sql->bindParam(':reglamento_es', $reglamento_es);
			$sql->bindParam(':reglamento_en', $reglamento_en);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	// VALORES DE MUESTRAS: CONCURSO NACIONAL E INTERNACIONAL (+ ADUANA)
	
	function gets_valores(){
		include('conexion_pdo.php');
		$query_  = " SELECT * FROM concurso_muestras_valores order by id DESC ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function add_valores($fecha, $valor_nac, $valor_int, $valor_int_aduana){
		include('conexion_pdo.php'); 
		$query= "INSERT INTO concurso_muestras_valores (fecha, valor_nac, valor_int, valor_int_aduana) 
		         VALUES (:fecha, :valor_nac, :valor_int, :valor_int_aduana)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fecha', $fecha);
			$sql->bindParam(':valor_nac', $valor_nac);
			$sql->bindParam(':valor_int', $valor_int);
			$sql->bindParam(':valor_int_aduana', $valor_int_aduana);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

	function upd_valores($id, $fecha, $valor_nac, $valor_int, $valor_int_aduana){
		include('conexion_pdo.php');				
		$query_  = " UPDATE concurso_muestras_valores SET fecha= :fecha, valor_nac= :valor_nac, valor_int= :valor_int, valor_int_aduana= :valor_int_aduana 
		             WHERE id= :id"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',  $id);
			$sql->bindParam(':fecha', $fecha);
			$sql->bindParam(':valor_nac', $valor_nac);
			$sql->bindParam(':valor_int', $valor_int);
			$sql->bindParam(':valor_int_aduana', $valor_int_aduana);
			if($sql->execute()) return true; else return false ;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
}
?>