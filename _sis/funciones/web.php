<?php

class Web {
	         
	function gets_(){
		include('conexion_pdo.php');
		$query_= "  SELECT * FROM web_msj_bienvenida ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}

	function upd_($msj){
		$id    = '1';
		$f_hs  = Date('Y-m-d H:i:s');
		include('conexion_pdo.php');
		$query_= " UPDATE web_msj_bienvenida SET descripcion= :msj, f_hs= :f_hs WHERE id= 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':msj',  $msj);
			$sql->bindParam(':f_hs', $f_hs);
			if($sql->execute())	$return= true;
			else				$return= false;								
			}
		catch (Exception $e){	echo $e->getMessage();	}
		return $return;
	}
	
}
?>