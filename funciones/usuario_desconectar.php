<?php
class UsuarioDesc {

	function del_user_activo($login){ 
		include('conexion_pdo.php');				
		$query_ = "DELETE FROM usuario_activo WHERE login= :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$sql = null;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}
	function desconectar(){
		
		session_start();
		$this->del_user_activo($_SESSION['sesion_UserId']);
		
		unset($_SESSION['sesion_UserId']);
		unset($_SESSION['sesion_UserFoto']);
		unset($_SESSION['sesion_Modulos']);
		unset($_SESSION['sesion_Menu']);
		unset($_SESSION['sesion_aux3']);
		unset($_SESSION['sesion_rptaOS']);
		unset($_SESSION['sesion_ImagenBienvenida']);
		
		setcookie('sisMinProd_UserId','',1);	
		
		header("Refresh:0; URL=../login.php");
	}	
}
?>