<?php
class Versionado {
	
	function gets_(){
		include('conexion_pdo.php');
		// $query_ = " SELECT * FROM versionado ORDER BY id DESC "; 
		$query_ = " SELECT v.*, f.nombre as nom_f, m.nombre as nom_m
					FROM versionado AS v
					LEFT JOIN usuario_funcion AS f ON (v.funcion=f.id)
					LEFT JOIN usuario_modulos AS m ON (m.id = f.fk_modulo) ORDER BY id DESC "; 
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
	function gets_mod_fun(){
		include('conexion_pdo.php');
		$query_= " SELECT CONCAT(m.nombre,' - ',f.nombre) as nombre, f.id
				    FROM usuario_modulos AS m INNER JOIN usuario_funcion AS f ON (m.id = f.fk_modulo) ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();	}
		finally{				$sql = null;			}
	}	

	function get_version(){				
		include('conexion_pdo.php');
		$query_  = " SELECT concat(nro,'.',review) as v FROM versionado ORDER BY id DESC "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return Date('Y').'. V '.$res['v'].' - Sistema de Inscripciones';
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}	
	}	
	
	function add_version($ver, $rev, $proyecto, $fun, $tipo, $titulo, $desc){
		include('conexion_pdo.php');
		$hoy  = Date('Y-m-d');
		$query= "INSERT INTO versionado (fecha, nro, review, proyecto, funcion, titulo, descripcion, tipo_mejora) 
		         VALUES (:fecha, :nro, :review, :proyecto, :funcion, :titulo, :descripcion, :tipo_mejora)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fecha', 		 $hoy);
			$sql->bindParam(':nro',       	 $ver);
			$sql->bindParam(':review',       $rev);
			$sql->bindParam(':proyecto',     $proyecto);
			$sql->bindParam(':funcion',      $fun);
			$sql->bindParam(':titulo',       $titulo);
			$sql->bindParam(':descripcion',  $desc);
			$sql->bindParam(':tipo_mejora',  $tipo);
			if($sql->execute())	{ $return = true; }
			else				{ $return = false; }
			return $return;	
		}
		catch (Exception $e){		echo $e->getMessage();		}
		finally{					$sql= null;					}
	}
}
?>