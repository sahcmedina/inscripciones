<?php
class Usuario {

	/**
	ESTADOS: 
	* 	(usuario_) 
	*/
	
	function conectar($login, $pass){
		session_start();
		require_once('./_cripto.php');		$Cripto2  = new Cripto();

		// traigo el id
		$datos_user= array();
		$id        = $this->get_id($login);
		
		// tipo de Usuario
		$tipo_user = $this->get_tipo_user($login);
		
		$_SESSION['sesion_UserId']  		= $login;
		$_SESSION['sesion_UserFoto']		= $id;
		$_SESSION['sesion_ImagenBienvenida']= 1;
		$_SESSION['sesion_aux3']    		= null;
		$_SESSION['sesion_rptaOS']    		= null;
		
		// borro registros que hayan quedado como basura de ingresos anteriores
		$borrar= $this->del_user_activo($login);
		$nada  = $this->add_user_activo($login);
		
		// cookies
		$cookieHash = $Cripto2->encrypt_decrypt('encrypt',$login);
		setcookie('sisMinProd_UserId', $cookieHash, time() + 60 * 120, '/'); // 120 minutos
		
		// traigo los modulos en los que participa el usuario
		$datos_modulos = array();
		$datos_modulos = $this->gets_modulos($id);

		// Si usuario es Super Admin
		if($tipo_user == '10'){ 

			// Modulo
			// $datos_modulos_sadmin = array();
			// $datos_modulos_sadmin = $this->gets_modulos_sadmin();
			// $datos_modulos = array_merge($datos_modulos, $datos_modulos_sadmin);

			// Funcion
			// $datos_menu_sadmin = array();
			// $datos_menu_sadmin = $this->gets_menu_sadmin();				
		} 
		
		// armo el menu para el usuario logueado
		$datos_menu = array();
		$datos_menu = $this->gets_menu($id);
		if($tipo_user == '10'){	$datos_menu = array_merge($datos_menu, $datos_menu_sadmin);	}
		
		$k_mod = count( $datos_modulos);
		$k_men = count( $datos_menu);

		// echo ' * '.$datos_menu[0]['funcion'];
		// echo ' * '.$datos_menu[1]['funcion'];die();

		// echo 'ACA: '.$tipo_user.'-'.$k_men;die();	
		// if($tipo_user == 2){	$tipo_cta= $S->get_tipo($login);}	
		// else{					$tipo_cta= '';					}
			
		// $menu= '<ul class="navigation">';
		// for($i=0 ; $i<$k_mod ; $i++){
		// 	$menu.='<li>';
		// 	$menu.='<a href="#" title="Módulo '.$datos_modulos[$i]['nombre'].'"><span>'.$datos_modulos[$i]['nombre'].'</span> <i class="'.$datos_modulos[$i]['icono'].'"></i></a>';
		// 	$menu.='	<ul>';
		// 	for($j=0 ; $j<$k_men ; $j++){
		// 		if( utf8_encode($datos_menu[$j]['modulo']) == utf8_encode($datos_modulos[$i]['nombre']) ){					
		// 			$menu.='		<li><a href="'.$datos_menu[$j]['url'].'">'.utf8_encode($datos_menu[$j]['funcion']).' </a></li>';
		// 		}
		// 	}
		// 	$menu.='	</ul>';
		// 	$menu.='</li>';			
		// }	
		// $_SESSION['sesion_Menu']= $menu;	
			
		$menu= '';
		for($i=0 ; $i<$k_mod ; $i++){

			// Modulo
			if($i == 0)	$menu.='<li class="menu active">';
			else       	$menu.='<li class="menu">';

			$menu.='<a href="#'.$datos_modulos[$i]['nombre'].'" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle" title="Modulo '.$datos_modulos[$i]['nombre'].'">';
			$menu.='	<div class="">';
			// $menu.='		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>';
			$menu.='		<span>'.$datos_modulos[$i]['nombre'].'</span>';
			$menu.='	</div>';
			$menu.='	<div>';
			$menu.='		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>';
			$menu.='	</div>';
			$menu.='</a>';			

			// Funciones
			$menu.='<ul class="collapse submenu list-unstyled" id="'.$datos_modulos[$i]['nombre'].'" data-bs-parent="#accordionExample">';
			for($j=0 ; $j<$k_men ; $j++){
				if( utf8_encode($datos_menu[$j]['modulo']) == utf8_encode($datos_modulos[$i]['nombre']) ){					
					$menu.='	<li><a href="'.$datos_menu[$j]['url'].'">'.utf8_encode($datos_menu[$j]['funcion']).' </a></li>';
				}
			}
			$menu.='</ul>';
			$menu.='</li>';

			// Linea divisoria
			$menu.='<li class="menu menu-heading">';
			$menu.='	<div class="heading">';
			$menu.='		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
			$menu.='		<span>...</span>';
			$menu.='	</div>';
			$menu.='</li>';		
		}	
		
		$_SESSION['sesion_Menu']= $menu;	
		
		switch($tipo_user){
			
			case '10': 	// Super Admin 
						?> <script type="text/javascript"> window.location="../principal.php"; </script> <?php
						break;
				
			case '1': 	// Administradores (unico tipo)
						?> <script type="text/javascript"> window.location="../principal.php"; </script> <?php
						break;		
						
			default:	// resto de usuarios
						?> <script type="text/javascript"> window.location="../principal.php"; </script> <?php
						break;
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
		unset($_SESSION['sesion_ImagenBienvenida']);
		
		setcookie('sisMinProd_UserId','',1);		
		
		header("Refresh:0; URL=../login.php");
	}	
	

	function gets_datos_persona( $login){
		include('conexion_pdo.php');				
		$query_  = "SELECT u.*, p.nombre, p.dni, p.f_nac, p.apellido, pa.fk_perfil
	    		   FROM usuario_ u 
			      	  INNER JOIN usuario_persona p          ON u.fk_personal = p.dni
			          INNER JOIN usuario_perfil_asociado pa ON u.id = pa.fk_usuario
				   WHERE u.login = :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_datos_responsable( $login){
		include('conexion_pdo.php');				
		$query_  = "SELECT u.*, p.nombre, p.dni, p.apellido, pa.fk_perfil
	    		   FROM usuario_ u 
			      	  INNER JOIN concurso_responsable p     ON u.fk_personal = p.dni
			          INNER JOIN usuario_perfil_asociado pa ON u.id = pa.fk_usuario
				   WHERE u.login = :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}	
	function gets_funciones_segun_perfil($id_perfil){ 
		include('conexion_pdo.php');				
		$query_  = "SELECT m.id as m,f.id as f,m.nombre as nbre_m,f.nombre as nbre_f,f.descripcion,
				         p.alta,p.baja,p.modificacion,p.vista,perf.nombre as nbre_perf,perf.descripcion as descrip_perf
				    FROM usuario_modulos m 
				  	   LEFT JOIN usuario_funcion f            ON m.id=f.fk_modulo
				  	   LEFT JOIN usuario_permisos p           ON (f.id=p.fk_funcion AND p.fk_usuario_perfil= :id_perfil)		  	
				  	   LEFT JOIN usuario_perfil perf          ON perf.id=p.fk_usuario_perfil
					   WHERE f.estado = 1
				    ORDER BY nbre_m, nbre_f ASC"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_perfil', $id_perfil);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}

	}
	function gets_menu($id){ 
		include('conexion_pdo.php');				
		$query_  = "SELECT m.nombre as modulo, f.nombre as funcion, f.url, f.id as id_funcion
				  FROM usuario_perfil_asociado pa 
				  INNER JOIN usuario_permisos p ON pa.fk_perfil=p.fk_usuario_perfil
				  INNER JOIN usuario_funcion f  ON f.id=p.fk_funcion
				  INNER JOIN usuario_modulos m  ON f.fk_modulo=m.id
				  WHERE pa.fk_usuario = :id AND f.estado= '1' "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}	
	function gets_menu_sadmin(){ 
		include('conexion_pdo.php');				
		$query_  = "SELECT m.nombre as modulo, f.nombre as funcion, f.url, f.id as id_funcion
				    FROM usuario_funcion f INNER JOIN usuario_modulos m  ON f.fk_modulo=m.id
				    WHERE f.fk_modulo = '20' AND f.estado= '1' "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}	
	function gets_modulos($id){ 
		include('conexion_pdo.php');				
		$query_  = "SELECT distinct(m.nombre) nombre, m.icono 
	              FROM usuario_perfil_asociado pa 
	              INNER JOIN usuario_permisos p ON pa.fk_perfil=p.fk_usuario_perfil
	              INNER JOIN usuario_funcion f  ON f.id=p.fk_funcion                  
				  INNER JOIN usuario_modulos m  ON f.fk_modulo=m.id
	              WHERE pa.fk_usuario= :id "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}	
	function gets_modulos_sadmin(){ 
		include('conexion_pdo.php');				
		$query_  = "SELECT distinct(m.nombre) nombre, m.icono FROM  usuario_modulos m WHERE m.id= '20' "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}	
	function gets_modulos_(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT id,nombre FROM usuario_modulos ORDER BY nombre ASC"; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_funciones(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT m.id as m,f.id as f,m.nombre as nbre_m,f.nombre as nbre_f,f.descripcion,
		                 concat(m.nombre,': ',f.nombre,' - ',f.descripcion) as todo
				  	FROM usuario_modulos m INNER JOIN usuario_funcion f ON m.id=f.fk_modulo
				  	WHERE f.estado='1'
				  	ORDER BY nbre_m, nbre_f ASC"; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_funciones_segun_cli($id_cli){ 
		include('conexion_pdo.php');				
		$query_  = "SELECT m.id as m,f.id as f,m.nombre as nbre_m,f.nombre as nbre_f,f.descripcion,
		                    concat(m.nombre,': ',f.nombre,' - ',f.descripcion) as todo
				  	FROM usuario_modulos m 
					    INNER JOIN usuario_funcion f          ON m.id = f.fk_modulo
						INNER JOIN usuario_cliente_permisos p ON m.id = p.fk_modulo
				  	WHERE f.estado='1' AND p.fk_cliente = :id_cli
				  	ORDER BY nbre_m, nbre_f ASC"; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_cli',  $id_cli);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_func_segun_modulo($id_mod){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT f.id, f.nombre as nbre_f FROM usuario_funcion f 
				  	WHERE f.estado= '1' AND f.fk_modulo= :id_mod "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_mod',  $id_mod);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_perfil(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT id, nombre FROM usuario_perfil WHERE estado= '1' ORDER BY nombre ASC "; 
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_perfil_OLD($id_cliente){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT id, nombre FROM usuario_perfil WHERE estado= '1' AND grupo= :grupo ORDER BY nombre ASC "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':grupo',  $id_cliente);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();		}
	}
	function gets_buscar_patron($patron, $id_cliente){				
		include('conexion_pdo.php');		
		$query_  = "SELECT u.id, u.tipo, u.login, u.estado as estado_user, 
							concat(p.apellido,', ',p.nombre) as nbre_c, 
	                        perf.nombre as perfil, perf.descripcion, perf.id as idperfil                              
   					   FROM usuario_ u LEFT JOIN usuario_persona p           ON u.fk_personal = p.dni
					                   INNER JOIN usuario_perfil_asociado pa ON u.id = pa.fk_usuario       
					                   INNER JOIN usuario_perfil perf        ON pa.fk_perfil = perf.id
									   LEFT JOIN usuario_cliente c           ON u.grupo = c.id
                       WHERE (p.nombre like ? OR p.apellido like ? OR u.login like ? OR perf.nombre like ? )
					         AND c.id = ? ";	
		try{
			$sql = $con->prepare($query_);
			$busc= "%$patron%"; 
			$sql->bindValue(1, $busc, PDO::PARAM_STR);
			$sql->bindValue(2, $busc, PDO::PARAM_STR);
			$sql->bindValue(3, $busc, PDO::PARAM_STR);
			$sql->bindValue(4, $busc, PDO::PARAM_STR);
			$sql->bindValue(5, $id_cliente, PDO::PARAM_STR);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}
	function gets_buscar_patron_admin($patron){				
		// u.tipo = 1 (usuarios administradores clientes)
		include('conexion_pdo.php');		
		$query_  = "SELECT u.id, u.tipo, u.login, u.estado as estado_user, 
							concat(p.apellido,', ',p.nombre) as nbre_c, 
	                        perf.nombre as perfil, perf.descripcion, perf.id as idperfil,                              
							c.nombre as cli_nom
   					   FROM usuario_ u LEFT JOIN usuario_persona p           ON u.fk_personal=p.dni
					                   INNER JOIN usuario_perfil_asociado pa ON u.id=pa.fk_usuario       
					                   INNER JOIN usuario_perfil perf        ON pa.fk_perfil=perf.id
									   LEFT JOIN usuario_cliente c           ON u.grupo = c.id
                       WHERE (p.nombre like ? OR p.apellido like ? OR u.login like ? OR perf.nombre like ? )
					         AND u.tipo= 1 ";	
		try{
			$sql = $con->prepare($query_);
			$busc= "%$patron%"; 
			$sql->bindValue(1, $busc, PDO::PARAM_STR);
			$sql->bindValue(2, $busc, PDO::PARAM_STR);
			$sql->bindValue(3, $busc, PDO::PARAM_STR);
			$sql->bindValue(4, $busc, PDO::PARAM_STR);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}
	function gets_user_empresa(){				
		include('conexion_pdo.php');		
		$query_  = "SELECT u.id, u.tipo, u.login, u.estado as estado_user, 
							concat(p.apellido,', ',p.nombre) as nbre_c, 
	                        perf.nombre as perfil, perf.descripcion, perf.id as idperfil                              
   					   FROM usuario_ u LEFT JOIN usuario_persona p           ON u.fk_personal = p.dni
					                   INNER JOIN usuario_perfil_asociado pa ON u.id = pa.fk_usuario       
					                   INNER JOIN usuario_perfil perf        ON pa.fk_perfil = perf.id
									   LEFT JOIN usuario_cliente c           ON u.grupo = c.id ";		
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}
	
	function get_permisos($idFuncion, $idPerfilUsuario){
		include('conexion_pdo.php');				
		$query_  = "SELECT alta,baja,modificacion,vista FROM usuario_permisos WHERE fk_funcion = :idFuncion AND fk_usuario_perfil = :idPerfilUsuario "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':idFuncion',       $idFuncion);
			$sql->bindParam(':idPerfilUsuario', $idPerfilUsuario);
			$sql->execute();
			$res = $sql->fetchAll();
			$sql = null;
			return $res;
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function get_perfilAsociado($id){ 
		include('conexion_pdo.php');				
		$query_= " SELECT up.id
					FROM usuario_ as u
  					     INNER JOIN usuario_perfil_asociado AS upa ON upa.fk_usuario= u.id
					     INNER JOIN usuario_perfil AS up           ON upa.fk_perfil = up.id
					WHERE u.id = :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['id'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}	
	function get_nbre_perfil($id_perfil){ 
		include('conexion_pdo.php');				
		$query_= " SELECT nombre FROM usuario_perfil WHERE id= :id_perfil ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_perfil', $id_perfil);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['nombre'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function get_tipo_user( $login){
		include('conexion_pdo.php');				
		$query_  = "SELECT tipo FROM usuario_ WHERE login = :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['tipo'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function get_id( $login){
		include('conexion_pdo.php');				
		$query_ = "SELECT id FROM usuario_ WHERE login = :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['id'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function get_nombre_empresa( $login){
		include('conexion_pdo.php');				
		$query_ = "SELECT c.nombre FROM usuario_ AS u INNER JOIN usuario_cliente AS c ON u.grupo = c.id WHERE u.login = :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['nombre'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function get_id_empresa( $login){
		include('conexion_pdo.php');				
		$query_ = "SELECT c.id FROM usuario_ AS u INNER JOIN usuario_cliente AS c ON u.grupo = c.id WHERE u.login = :login "; 
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['id'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}

	function upd_pass($clave, $id){	
		include('conexion_pdo.php');		
		include('pass.php');			$Pas_ = new Pass();	
		$clave_ = $Pas_->hash($clave);		
		$query_ = ' UPDATE usuario_ SET pass= ? WHERE id= ? ';
		try{
			$sql = $con->prepare($query_);
			$sql->bindValue(1, $clave_, PDO::PARAM_STR);
			$sql->bindValue(2, $id,     PDO::PARAM_INT);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function upd_perfil_asociado($fk_perfil, $fk_usuario){	
		include('conexion_pdo.php');				
		$query_  = ' UPDATE usuario_perfil_asociado SET fk_perfil= :fk_perfil WHERE fk_usuario= :fk_usuario ';
		try{
			$sql = $con->prepare($query_);			
			$sql->bindParam(':fk_perfil',  $fk_perfil);
			$sql->bindParam(':fk_usuario', $fk_usuario);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){			
			echo $e->getMessage();
		}
	}	

	
	function del_permiso($id_perfil){ 
		include('conexion_pdo.php');				
		$query_= "DELETE FROM usuario_permisos WHERE fk_usuario_perfil= :id_perfil ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id_perfil', $id_perfil);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}		
	}
	function del_usuario_segun_id($id){
		include('conexion_pdo.php');				
		$query_= " UPDATE usuario_ SET estado='0' WHERE id= :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function del_perfil_asociado($id){ 
		include('conexion_pdo.php');				
		$query_= " DELETE FROM usuario_perfil_asociado WHERE fk_usuario= :id ";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id', $id);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
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


	function add_permiso($id, $fk_funcion, $fk_usuario_perfil, $alta, $baja, $modificacion){ 
		include('conexion_pdo.php');	    
		$vista= '1';
		$query= " INSERT INTO usuario_permisos (id,fk_funcion,fk_usuario_perfil,alta,baja,modificacion,vista) 
		                 VALUES (:id, :fk_funcion, :fk_usuario_perfil, :alta, :baja, :modificacion, :vista)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',             		$id);
			$sql->bindParam(':fk_funcion',			$fk_funcion);
			$sql->bindParam(':fk_usuario_perfil',	$fk_usuario_perfil);
			$sql->bindParam(':alta',				$alta);
			$sql->bindParam(':baja',				$baja);
			$sql->bindParam(':modificacion',		$modificacion);
			$sql->bindParam(':vista',				$vista);
			$sql->execute();
			$sql = null;	
			return $id;										
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_usuario_OLD($dni, $login, $pass){ // mdf 2025-02-24
		include('pass.php');			$P_ = new Pass();		
		include('conexion_pdo.php');				
		$next = $this->next_id_user();
		// $clave= md5($pass);	    
		$clave= $Pas_->hash($pass);	  
		$nada = '1';
		$query= " INSERT INTO usuario_ (id, login, pass, estado, tipo, fk_personal) 
		                 VALUES (:id, :login, :pass, :estado, :tipo, :fk_personal)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',          $next);
			$sql->bindParam(':login',		$login);
			$sql->bindParam(':pass',		$clave);
			$sql->bindParam(':estado',		$nada);
			$sql->bindParam(':tipo',		$nada);
			$sql->bindParam(':fk_personal',	$dni);
			$sql->execute();
			$sql = null;	
			return $next;										
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_usuario_permiso_admin($id_funcion, $id_perfil){ 		
		include('conexion_pdo.php');	
		$uno  = '1';
		$query= " INSERT INTO usuario_permisos (fk_funcion, fk_usuario_perfil, alta, baja, modificacion, vista) 
		                 VALUES (:fk_funcion, :fk_usuario_perfil, :alta, :baja, :modificacion, :vista)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_funcion',			$id_funcion);
			$sql->bindParam(':fk_usuario_perfil',	$id_perfil);
			$sql->bindParam(':alta',				$uno);
			$sql->bindParam(':baja',				$uno);
			$sql->bindParam(':modificacion',		$uno);
			$sql->bindParam(':vista',				$uno);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;										
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_usuario_admin($dni, $login, $pass, $id_cliente){ 
		include('pass.php');			$Pas_ = new Pass();		
		include('conexion_pdo.php');				
		$next = $this->next_id_user();
		// $clave= md5($pass);	    
		$clave= $Pas_->hash($pass);	    
		$nada = '1';
		$query= " INSERT INTO usuario_ (id, login, pass, estado, tipo, fk_personal, grupo) 
		          VALUES (:id, :login, :pass, :estado, :tipo, :fk_personal, :grupo)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',          $next);
			$sql->bindParam(':login',		$login);
			$sql->bindParam(':pass',		$clave);
			$sql->bindParam(':estado',		$nada);
			$sql->bindParam(':tipo',		$nada);
			$sql->bindParam(':fk_personal',	$dni);
			$sql->bindParam(':grupo',    	$id_cliente);
			$sql->execute();
			$sql = null;	
			return $next;										
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_cliente($nombre){ 
		include('conexion_pdo.php');				
		$next = $this->next_id_cliente();
		$nada = '0000-00-00 00:00:00';
		$hoy  = Date('Y-m-d H:i:s');
		$query= " INSERT INTO usuario_cliente (id, nombre, estado, f_create, f_update) 
		                 VALUES (:id, :nombre, '1', :f_create, :f_update)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',          $next);
			$sql->bindParam(':nombre',		$nombre);
			$sql->bindParam(':f_create',	$hoy);
			$sql->bindParam(':f_update',	$nada);
			$sql->execute();
			$sql = null;	
			return $next;										
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_usuario_concursante($dni, $login, $pass){ 
		include('pass.php');			$P_ = new Pass();		
		include('conexion_pdo.php');				
		$next = $this->next_id_user();
		// $clave= md5($pass);	      
		$clave= $Pas_->hash($pass);	
		$nada = '1';
		$tipo = '2';
		$query= " INSERT INTO usuario_ (id, login, pass, estado, tipo, fk_personal) 
		                 VALUES (:id, :login, :pass, :estado, :tipo, :fk_personal)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',          $next);
			$sql->bindParam(':login',		$login);
			$sql->bindParam(':pass',		$clave);
			$sql->bindParam(':estado',		$nada);
			$sql->bindParam(':tipo',		$tipo);
			$sql->bindParam(':fk_personal',	$dni);
			$sql->execute();
			$sql = null;	
			return $next;										
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_usuario_persona($dni, $nom, $ape, $tel, $email){ 
		include('conexion_pdo.php');	    
	    $f_nac= '1990-01-01';
		$query= " INSERT INTO usuario_persona (dni, apellido, nombre, correo, telefono, f_nac) 
		          VALUES (:dni, :apellido, :nombre, :correo, :telefono, :f_nac)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':dni',         $dni);
			$sql->bindParam(':apellido',	$ape);
			$sql->bindParam(':nombre',      $nom);
			$sql->bindParam(':correo',      $email);
			$sql->bindParam(':telefono',    $tel);
			$sql->bindParam(':f_nac',       $f_nac);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;									
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_perfil_asociado($fk_user, $fk_perfil){ 
		include('conexion_pdo.php');	 
		$next_   = $this->next_id_perfil_asociado();
		$query   = " INSERT INTO usuario_perfil_asociado (id, fk_usuario, fk_perfil) VALUES (:id, :fk_usuario, :fk_perfil)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',          $next_);
			$sql->bindParam(':fk_usuario',	$fk_user);
			$sql->bindParam(':fk_perfil',   $fk_perfil);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;									
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}	
	function add_perfil($id, $nbre, $descrip, $id_cliente){ 
		include('conexion_pdo.php');	
		$estado = '1'; 
		$query  = " INSERT INTO usuario_perfil (id, nombre, descripcion, estado, grupo) 
		            VALUES (:id, :nombre, :descripcion, :estado, :grupo)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',          $id);
			$sql->bindParam(':nombre',		$nbre);
			$sql->bindParam(':descripcion', $descrip);
			$sql->bindParam(':estado',   	$estado);
			$sql->bindParam(':grupo',   	$id_cliente);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;									
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function add_user_activo($login){ 
		include('conexion_pdo.php');
		$hoy  = Date('Y-m-d');
		$next = $this->next_id_user_activo();	
		$query= "INSERT INTO usuario_activo (id, login, f_login) VALUES (:id, :login, :hoy)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':id',    $next);
			$sql->bindParam(':login', $login);
			$sql->bindParam(':hoy',   $hoy);
			$sql->execute();
			$sql = null;
			return $next;
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}	
	function add_mod_a_cli($id_mod, $id_cliente){ 
		include('conexion_pdo.php');	
		$nada = '0000-00-00 00:00:00';
		$hoy  = Date('Y-m-d H:i:s');
		$query= " INSERT INTO usuario_cliente_permisos (fk_cliente, fk_modulo, f_create, f_update) 
		                 VALUES (:fk_cli, :fk_mod, :f_cre, :f_upd)";
		try{
			$sql = $con->prepare($query);
			$sql->bindParam(':fk_cli',	$id_cliente);
			$sql->bindParam(':fk_mod',	$id_mod);
			$sql->bindParam(':f_cre',	$hoy);
			$sql->bindParam(':f_upd',	$nada);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}

	
	function next_id_permiso(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT max(id) as id FROM usuario_permisos ";	
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if($res == null)	return 1;
			else				return ($res['id'] + 1);
		}
		catch (Exception $e){	return 1;	}
	}
	function next_id_user(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT max(id) as id FROM usuario_  ";	
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if($res == null)	return 1;
			else				return ($res['id'] + 1);
		}
		catch (Exception $e){	return 1;	}
	}
	function next_id_cliente(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT max(id) as id FROM usuario_cliente  ";	
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if($res == null)	return 1;
			else				return ($res['id'] + 1);
		}
		catch (Exception $e){	return 1;	}
	}
	function next_id_perfil_asociado(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT max(id) as id FROM usuario_perfil_asociado ";	
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if($res == null)	return 1;
			else				return ($res['id'] + 1);
		}
		// catch (Exception $e){	return 1;	}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function next_id_perfil(){ 
		include('conexion_pdo.php');				
		$query_  = " SELECT max(id) as id FROM usuario_perfil ";	
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$result = $sql->fetch();
			$sql = null;
			if($result == null)	return 1;
			else				return ($result['id'] + 1);
		}
		// catch (Exception $e){	return 1;	}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function next_id_user_activo(){
		include('conexion_pdo.php');				
		$query_  = " SELECT max(id) as id FROM usuario_activo ";	
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if($res == null)	return 1;
			else				return ($res['id'] + 1);
		}
		// catch (Exception $e){	return 1;	}
		catch (Exception $e){	echo $e->getMessage();	}	
	}


	function tf_repite_login($login){ 
		include('conexion_pdo.php');		
		$query_= " SELECT count(*) as cant FROM usuario_ WHERE login= :login "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
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
	function tf_repite_dni($dni){ 
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM usuario_persona WHERE dni= :dni "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni', $dni);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}
	function tf_repite_perfil($nbre, $id_cliente){ 	
		include('conexion_pdo.php');		
		$query_= " SELECT count(*) as cant FROM usuario_perfil WHERE nombre= :nombre AND grupo= :grupo"; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':nombre', $nbre);
			$sql->bindParam(':grupo',  $id_cliente);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}
	function existe($login, $pass){
		include('conexion_pdo.php');					
		include('pass.php');			$Pas_ = new Pass();		
		// $clave= $Pas_->hash($pass);
		$return = $Pas_->pass_verify($login, $pass);
		//echo 'ACA: '.$login.'-'.$pass.'-'.$return;die();
		return $return;
		// $query_ = "SELECT count(*) as cant FROM usuario_ WHERE login = :login AND pass = md5(:pass) AND estado='1' "; 
		//  try{
		//  	$sql = $con->prepare($query_);
		//  	$sql->bindParam(':login',   $login);
		//  	$sql->bindParam(':pass', $pass);
		//  	$sql->execute();
		//  	$res = $sql->fetch();
		//  	$sql = null;
		//  	if ($res['cant'] > 0){	return 'si';	}
		//  	else{ 					return 'no';	}
		//  }
		//  catch (Exception $e){		echo $e->getMessage();	}
	}
	function existe_logueado($login){
		include('conexion_pdo.php');		
		$query_= " SELECT COUNT(id) as cant FROM usuario_activo WHERE login= :login "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':login', $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}

		
}
?>