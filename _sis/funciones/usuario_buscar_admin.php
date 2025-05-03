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
	  // $datos_f = $U->get_permisos('1',$datos[0]['fk_perfil']);
	  // $alta    = $datos_f[0]['alta'];
	  // $baja    = $datos_f[0]['baja'];
	  // $modf    = $datos_f[0]['modificacion'];

	  $alta    = 1;
	  $baja    = 1;
	  $modf    = 1;
		
	  $patron = $_POST['b'];            
      if(!empty($patron)) {	comprobar($patron, $modf, $baja);    }
    
	  function comprobar($patron, $modf, $baja) { 

			$Usr   = new Usuario();
			$datos = array();
      		$datos = $Usr->gets_buscar_patron_admin($patron);

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
								<th style='text-align:center'> Empresa      </th>
								<th style='text-align:center'> Perfil	    </th>
								<th style='text-align:center'> Usuario	    </th>
								<th style='text-align:center'> # User creados	    </th>
								<th style='text-align:center'> Permisos a Módulos</th>
								<th style='text-align:center'> Habilitar / Deshabilitar	    </th>".
						"</tr></thead><tbody>";				
				for($j=0 ; is_array($datos) && $j<count($datos) ; $j++){
					$cur = $datos[$j];
					
					if($modf == '1') {	$mdf_= '<td style="text-align:center"><a data-toggle="modal" role="button" data-target="#modal_edit_perfil" class="btn btn-link btn-icon" data-id="'.$cur['id'].'" data-perfil="'.utf8_encode($cur['perfil']).'" data-nbre="'.utf8_encode($cur['nbre_c']).'" ><IMG src="images/editar.png" title="modificar perfil para el usuario."></a>'."</td>\n";		}
					else				$mdf_= '<td style="text-align:center">' . '' . "</td>\n";
						
					if($baja == '1') {	$del_= '<td style="text-align:center"><a href="./funciones/usuario_del.php?id='.$cur['id'].'" ><IMG src="./images/x.gif" title="eliminar el usuario"></a>'."</td>\n";					}
					else				$del_= '<td style="text-align:center">' . '' . "</td>\n"; 
										
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
					
					$mdf_permisos = '<a data-toggle="modal" role="button" href="#modal_mdf_modulos" class="btn btn-link btn-icon"><button type="button" class="btn btn-icon btn-success" title="Cambiar permisos" style="padding: 0rem;"><i class="bi bi-door-open" style="font-size: 1.7rem;"></i></button></a>';
					$knt_user_creados = 0;

					if($cur['estado_user'] == 1)	$mdf_estado = '<a data-toggle="modal" role="button" href="#modal_deshabilitar_user" class="btn btn-link btn-icon"><button type="button" class="btn btn-icon btn-danger" title="Deshabilitar Usuario (y todos los creados por él)" style="padding: 0rem;"><i class="bi bi-lock" style="font-size: 1.7rem;"></i></button></a>';
					else							$mdf_estado = '<a data-toggle="modal" role="button" href="#modal_habilitar_user" class="btn btn-link btn-icon"><button type="button" class="btn btn-icon btn-success" title="Habilitar Usuario (y todos los creados por él)" style="padding: 0rem;"><i class="bi bi-unlock" style="font-size: 1.7rem;"></i></button></a>';			
					
					echo "<tr class=\"cellColor" . ($j%2) . "\" align=\"center\" id=\"tr$j\">\n"
						. '<td style="text-align:center">' . $estado                     . "</td>\n"
						. '<td style="text-align:center">' . $nbre                       . "</td>\n"
						. '<td style="text-align:center">' . utf8_encode($cur['cli_nom']). "</td>\n"
						. '<td style="text-align:center">' . utf8_encode($cur['perfil']) . "</td>\n"
						. '<td style="text-align:center">' . utf8_encode($cur['login'])  . "</td>\n"
						. '<td style="text-align:center">' . $knt_user_creados . "</td>\n"
						. '<td style="text-align:center">' . $mdf_permisos . "</td>\n"
						// . '<td style="text-align:center"><a href="./_admin_usuarios_permisos_perfil.php?idperfil='.$cur['idperfil'].'" ><IMG src="./images/opc_edit.png" title="modificar permisos de un perfil"></a>'."</td>\n"
						// . $mdf_
						. '<td style="text-align:center">' . $mdf_estado . "</td>\n" 
						. "</tr>\n";						
				}// for
								
				echo "</tbody></table></div></div>";
			}
      		
      }     
?>