<?php

class ComprobantePago {
	
	function tf_existe_comp_concurso($id_emp, $nac_int){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_muestras_comp_pago WHERE fk_concurso_empresa= :id_emp AND nac_int= :nac_int "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':id_emp',  $id_emp);
			$sql->bindParam(':nac_int', $nac_int);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}

	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////

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
	function gets_responsable($dni, $anio){
		include('conexion_pdo.php');		
		$query_  = " SELECT r.*, p.nombre AS pais, prov.nombre AS prov_arg
					 FROM concurso_responsable AS r 
						INNER JOIN pais AS p ON p.id = r.fk_pais
						LEFT JOIN  provincia AS prov ON prov.id = r.fk_provincia_ar
					 WHERE dni= :dni AND anio= :anio "; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':dni',   $dni);
			$sql->bindParam(':anio',  $anio);	
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	} 
	function gets_concurso_tipo(){
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM concurso_tipo "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets_categorias(){
		include('conexion_pdo.php');		
		$query_  = " SELECT * FROM concurso_categoria "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}	
	function gets_muestras($dni, $nac_int){
		include('conexion_pdo.php');		
		$query_  = " SELECT m.*, c.nombre AS grupo FROM concurso_empresa AS emp  
					 INNER JOIN concurso_muestras AS m ON m.fk_concurso_empresa = emp.id
					 INNER JOIN concurso_categoria AS c ON m.fk_concurso_categoria = c.id
					 WHERE emp.fk_responsable= :dni AND m.nac_int= :nac_int"; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':dni',     $dni);	
			$sql->bindParam(':nac_int', $nac_int);	
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	function gets_empresa($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT emp.*, p.nombre AS pais, prov.nombre AS prov_arg
		            FROM concurso_empresa AS emp  
						 INNER JOIN pais AS p          ON p.id = emp.fk_pais
						 LEFT JOIN  provincia AS prov  ON prov.id = emp.fk_provincia_ar
					WHERE emp.fk_responsable= :dni "; 
        try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':dni',   $dni);	
			$sql->execute();
			$res = $sql->fetchAll();
			return $res;
		}
		catch (Exception $e){ echo $e->getMessage(); 		}
		finally{				$sql = null;				}
	}
	
	function get_anio(){
		include('conexion_pdo.php');
		$query_= " SELECT anio FROM concurso_anio WHERE id= 1 ";
		try{
			$sql = $con->prepare($query_);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['anio'];
		}
		catch (Exception $e){	echo $e->getMessage();	}
	}
	function get_next_id_empresa(){	
		include('conexion_pdo.php');
		$query_= " SELECT max(id) as id FROM concurso_empresa ";
		try{
			$sql = $con->prepare($query_);
			if($sql->execute()){	$res   = $sql->fetch(); $return= $res['id'] + 1;	}
			else					$return= 1;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	function get_dni_concursante($login){	
		include('conexion_pdo.php');
		$query_= " SELECT dni FROM concurso_responsable WHERE email= :email ";
		try{
			$sql = $con->prepare($query_);	
			$sql->bindParam(':email',   $login);
			$sql->execute();
			$res = $sql->fetch();
			$sql = null;
			return $res['dni'];
		}
		catch (Exception $e){	echo $e->getMessage();		}
		finally{				$sql = null;				}
	}
	
	function add_responsable($dni, $correo, $nom, $ape, $pin, $tel, $pais, $prov, $prov_arg, $anio){
		include('conexion_pdo.php');
		$query_  = " INSERT INTO concurso_responsable (dni, apellido, nombre, email, pin, tel, anio, fk_pais, fk_provincia_ar, provincia_region_estado)
		             VALUE (:dni, :ape, :nom, :email, :pin, :tel, :anio, :fk_pais, :fk_prov_ar, :prov_region_estado)";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':dni',    				$dni);			
			$sql->bindParam(':ape',    				$ape);			
			$sql->bindParam(':nom', 				$nom);			
			$sql->bindParam(':email',     			$correo);
			$sql->bindParam(':pin', 				$pin);
			$sql->bindParam(':tel', 				$tel);
			$sql->bindParam(':anio', 				$anio);
			$sql->bindParam(':fk_pais', 	       	$pais);
			$sql->bindParam(':fk_prov_ar', 	       	$prov_arg);
			$sql->bindParam(':prov_region_estado', 	$prov);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}
	function add_empresa($raz_soc, $cod_id, $dom, $tel, $pais, $prov_arg, $prov, $web, $dni, $volumen, $categ_reg_int, $categ_reg_nac){
		include('conexion_pdo.php');
		$id      = $this->get_next_id_empresa();
		$query_  = " INSERT INTO concurso_empresa (id, cuit, razon_social, domicilio, tel, web, fk_responsable, fk_pais, fk_provincia_ar, provincia_region_estado, volumen, categ_conc_int, categ_conc_nac)
		             VALUE (:id, :cuit, :razon_soc, :dom, :tel, :web, :fk_resp, :fk_pais, :fk_prov_ar, :prov_region_estado, :volumen, :categ_conc_int, :categ_conc_nac)";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':id',       			$id);			
			$sql->bindParam(':cuit',    			$cod_id);			
			$sql->bindParam(':razon_soc',    		$raz_soc);			
			$sql->bindParam(':dom', 				$dom);			
			$sql->bindParam(':tel',     			$tel);
			$sql->bindParam(':web', 				$web);
			$sql->bindParam(':fk_resp', 			$dni);
			$sql->bindParam(':fk_pais', 			$pais);
			$sql->bindParam(':fk_prov_ar', 	       	$prov_arg);
			$sql->bindParam(':prov_region_estado', 	$prov);
			$sql->bindParam(':volumen', 	        $volumen);
			$sql->bindParam(':categ_conc_int', 	    $categ_reg_int);
			$sql->bindParam(':categ_conc_nac', 	    $categ_reg_nac);
			if($sql->execute())	$return= $id;
			else				$return= 0;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}	
	function add_muestra($id_emp, $marca, $varietal, $lote, $litros, $grupo, $origen, $nac_int, $codigo){
		include('conexion_pdo.php');
		$cero    = 0;
		$f_vacio = '0000-00-00 00:00:00';
		$anio    = Date('Y');
		$query_  = " INSERT INTO concurso_muestras (fk_concurso_empresa, marca, fk_concurso_varietal, lote, litros, fk_concurso_categoria, origen, ganador, nac_int, codigo, codigo_confirmado, codigo_confirmado_f, anio_concurso)
		             VALUE (:fk_concurso_empresa, :marca, :fk_concurso_varietal, :lote, :litros, :fk_concurso_categoria, :origen, :ganador, :nac_int, :codigo, :codigo_confirmado, :codigo_confirmado_f, :anio_concurso)";	
		try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':fk_concurso_empresa',     $id_emp);			
			$sql->bindParam(':marca',    				$marca);			
			$sql->bindParam(':fk_concurso_varietal',    $varietal);			
			$sql->bindParam(':lote', 				    $lote);			
			$sql->bindParam(':litros',     			    $litros);
			$sql->bindParam(':fk_concurso_categoria', 	$grupo);
			$sql->bindParam(':origen',              	$origen);
			$sql->bindParam(':ganador', 			    $cero);
			$sql->bindParam(':nac_int', 			    $nac_int);
			$sql->bindParam(':codigo', 			        $codigo);
			$sql->bindParam(':codigo_confirmado',       $cero);
			$sql->bindParam(':codigo_confirmado_f', 	$f_vacio);
			$sql->bindParam(':anio_concurso', 			$anio);
			if($sql->execute())	$return= true;
			else				$return= false;
			$sql = null;
			return $return;
		}
		catch (Exception $e){	echo $e->getMessage();	}	
	}

	function tf_esta_dni($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_responsable WHERE dni= :dni "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',   $dni);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	function tf_esta_email($email){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_responsable WHERE email= :email "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':email',   $email);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	} 
	
	function tf_existe_empresa($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_empresa WHERE fk_responsable= :dni "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',   $dni);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	function tf_existe_muestra($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant 
					FROM concurso_empresa AS emp 
					INNER JOIN concurso_muestras AS m ON m.fk_concurso_empresa = emp.id
					WHERE emp.fk_responsable= :dni "; 
        try{
			$sql = $con->prepare($query_);		
			$sql->bindParam(':dni',   $dni);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	function tf_existe_pin($dni){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_responsable WHERE pin= :pin "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':pin',   $pin);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}	
	function tf_repite_codigo($codigo){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_muestras WHERE codigo= :codigo "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':codigo', $codigo);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}
	function tf_existe_codigo_id($cuit){
		include('conexion_pdo.php');		
		$query_  = " SELECT count(*) as cant FROM concurso_empresa WHERE cuit= :cuit "; 
        try{
			$sql = $con->prepare($query_);
			$sql->bindParam(':cuit',   $cuit);
			$sql->execute();
			$res = $sql->fetch();
			if ($res['cant']>0) return true;
			else				return false;
		}
		catch (Exception $e){	echo $e->getMessage(); 	}		
		finally             {	$sql = null;			}
	}

	function aux_generar_codigo(){
		$caract = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$codigo = substr(str_shuffle($caract), 0, 3);
		$band   = 0;
		for($i=0 ; $band==0 ; $i++){
			$existe = $this->tf_repite_codigo($codigo);
			if(!$existe)	$band  = 1; 
			else            $codigo= substr(str_shuffle($caract), 0, 3);
		}
		return $codigo;
	}

}
?>