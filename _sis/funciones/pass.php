<?php

class Pass {
	         
	function hash($pas){
		$hashedPas= password_hash($pas, PASSWORD_DEFAULT);
		return $hashedPas;
	}	

	function pass_verify($login, $pass){
		// busco el pass en DB para comparar
		$hashedPas= $this->aux_pass_hashed_DB($login);

		// Verifico
		if (password_verify($pass, $hashedPas)) {	$return= 1;	} 
		else {										$return= 0;	}
		if($return == 0) 	return 'no'; // return true;
		else				return 'si'; // return false;
	}

	function aux_pass_hashed_DB($login){
		include('conexion_pdo.php');
		$query_= " SELECT pass FROM usuario_ WHERE login = :login ";
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login',   $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['pass'];
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}

}
?>