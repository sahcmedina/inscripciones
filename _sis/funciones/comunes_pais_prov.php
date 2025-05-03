<?php

class Pais_prov {
	
	function gets_paises(){
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM pais  "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets_provincias(){
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM provincia  "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	

}
?>