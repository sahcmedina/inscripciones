<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/plugins/interface/datatables.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/londinium-theme.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>
<?php
	  include('./usuario.php');		$U      = new Usuario();
      session_start();
      
      $idUser = $_SESSION['sesion_UserId'];	  
	  $datos  = array();
	  $datos  = $U->gets_datos_persona($idUser);
	  $permiso= '';
	
      // consultar permisos del usuario (logueado) a la funcion
	  $datos_f = array();
	  $datos_f = $U->get_permisos('1',$datos[0]['fk_perfil']);
	  $alta    = $datos_f[0]['alta'];
	  $baja    = $datos_f[0]['baja'];
	  $modf    = $datos_f[0]['modificacion'];
		
	  $patron = $_POST['b'];       
	  $id_emp = $_POST['id_emp'];       

      if(!empty($patron)) {	comprobar($patron, $modf, $baja, $id_emp);    }
    
	  function comprobar($patron, $modf, $baja, $id_emp) { 
			$Usr   = new Usuario();
			$datos = array();
      		$datos = $Usr->gets_buscar_patron($patron, $id_emp);

			if(count($datos) == 0){
				echo "<span style='font-weight:bold;color:red;'>No hay registros para esa búsqueda.</span>";  
			}else{
				?><div id="resultado_busqueda" class="panel panel-default">
                <div class="panel-heading" align="right"><h6 class="panel-title"><i class="icon-table"></i><?php echo "Usuarios" ?></h6>
                </div><?php
				
				echo '<div id="dt" class="datatable">
				      <table class="table table-striped table-bordered">'.
						"<thead><tr class=\"rowHeaders\">			
								<th style='text-align:center'> Estado       </th>
								<th style='text-align:center'> Nombre       </th>
								<th style='text-align:center'> Perfil	    </th>
								<th style='text-align:center'> Usuario	    </th>
								<th style='text-align:center'> Mdf Permisos </th>
								<th style='text-align:center'> Mdf Clave    </th>
								<th style='text-align:center'> Mdf Perfil   </th>
								<th style='text-align:center'> Borrar	    </th>".
						"</tr></thead><tbody>";				
				for($j=0 ; is_array($datos) && $j<count($datos) ; $j++){
					$cur = $datos[$j];
					
					switch($cur['tipo']){
						case '1': 	$tipo ='Administrativo';			
									$nbre = utf8_encode($cur['nbre_c']);		
									if( $cur['estado_user']== 1)	$estado= '<Font COLOR="green">'.'Activo'.'</Font>';
									else							$estado= '<Font COLOR="red">'.'Baja'.'</Font>';
									break;		
													
						default : 	$tipo  ='Error';	
									$nbre  = '';
									$estado= '<Font COLOR="red">'.'Error'.'</Font>';
									break;						
					}

					// if($modf == '1') {	$mdf_= '<td style="text-align:center"><a data-toggle="modal" role="button" data-target="#modal_edit_perfil" class="btn btn-link btn-icon" data-id="'.$cur['id'].'" data-perfil="'.utf8_encode($cur['perfil']).'" data-nbre="'.utf8_encode($cur['nbre_c']).'" ><IMG src="images/editar.png" title="modificar perfil para el usuario."></a>'."</td>\n";		}
					if($modf == '1') {	$mdf_= '<td style="text-align:center"><a data-toggle="modal" role="button" href="#modal_edit_perfil" class="btn btn-link btn-icon" data-id="'.$cur['id'].'" data-perfil="'.utf8_encode($cur['perfil']).'" data-nbre="'.utf8_encode($cur['nbre_c']).'"><button type="button" class="btn btn-icon btn-success" title="Modificar Perfil para el Usuario" style="padding: 0.1rem; width: 25px;"><i class="bi bi-person-vcard" style="font-size: 1.7rem;"></i></button></a>'."</td>\n";		}
					else				$mdf_= '<td style="text-align:center">' . '' . "</td>\n";
						
					// if($baja == '1') {	$del_= '<td style="text-align:center"><a href="./funciones/usuario_del.php?id='.$cur['id'].'" ><IMG src="./images/x.gif" title="eliminar el usuario"></a>'."</td>\n";					}
					if($baja == '1') {	$del_= '<td style="text-align:center"><a data-toggle="modal" role="button" href="#modal_del_user" class="btn btn-link btn-icon" data-id="'.$cur['id'].'" data-nbre="'.$nbre.'" ><button type="button" class="btn btn-icon btn-danger" title="Borrar Usuario" style="padding: 0.1rem; width: 25px;"><i class="bi bi-person-slash" style="font-size: 1.7rem;"></i></button></a>'."</td>\n";		}
					else				$del_= '<td style="text-align:center">' . '' . "</td>\n"; 
					
					
					echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
						. '<td style="text-align:center">' . $estado                     . "</td>\n"
						. '<td style="text-align:center">' . $nbre                       . "</td>\n"
						. '<td style="text-align:center">' . utf8_encode($cur['perfil']) . "</td>\n"
						. '<td style="text-align:center">' . utf8_encode($cur['login'])  . "</td>\n"
						// . '<td style="text-align:center"><a href="./_admin_usuarios_permisos_perfil.php?idperfil='.$cur['idperfil'].'" ><IMG src="./images/opc_edit.png" title="modificar permisos de un perfil"></a>'."</td>\n"
						. '<td style="text-align:center"><a data-toggle="modal" role="button" href="#modal_mdf_permiso_perfil" class="btn btn-link btn-icon" data-idperfil="'.$cur['idperfil'].'" data-nbre="'.utf8_encode($cur['perfil']).'"><button type="button" class="btn btn-icon btn-success" title="Modificar Permisos de un Perfil" style="padding: 0.1rem; width: 25px;"><i class="bi bi-ui-checks-grid" style="font-size: 1.7rem;"></i></button></a>'."</td>\n"
						// . '<td style="text-align:center"><a data-toggle="modal" role="button" data-target="#modal_edit_clave" class="btn btn-link btn-icon" data-id="'.$cur['id'].'" ><IMG src="images/mdf_pass.png" title="modificar contraseña para el usuario."></a>'."</td>\n"    
						. '<td style="text-align:center"><a data-toggle="modal" role="button" href="#modal_edit_clave" class="btn btn-link btn-icon" data-id="'.$cur['id'].'" ><button type="button" class="btn btn-icon btn-success" title="Modificar contraseña para el Usuario" style="padding: 0.1rem; width: 25px;"><i class="bi bi-key" style="font-size: 1.7rem;"></i></button></a>'."</td>\n"
						. $mdf_
						. $del_
						. "</tr>\n";						
				}// for
								
				echo "</tbody></table></div></div>";
			}
      		
      }     
?>