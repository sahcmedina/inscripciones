<!-- MOSTRAR Y OCULTAR CAMPOS SEGUN LO QUE SE SELECCIONE -->	
<script language="javascript">

	function en_q_hs_trabaja(selectTag){      
	 	if(selectTag.value != 'desem' ){
			document.getElementById('mostrar_hs_trabajo_actual').hidden = false;
		}else{
			document.getElementById('mostrar_hs_trabajo_actual').hidden = true;
		}	 		
	}	
	function ult_nivel_alcanzado(selectTag){
	 	if(selectTag.value=='5'){
			document.getElementById('mostrar_campo_titulo').hidden = false;
		}else{
			if(selectTag.value=='6'){
				document.getElementById('mostrar_campo_titulo').hidden = false;
			}else{
				if(selectTag.value=='7'){
					document.getElementById('mostrar_campo_titulo').hidden = false;
				}else{
					if(selectTag.value=='8'){
						document.getElementById('mostrar_campo_titulo').hidden = false;
					}else{
						document.getElementById('mostrar_campo_titulo').hidden = true;
					}
				}
			}
		}	 		
	}	 
	function hay_capacit_anterior(selectTag){
	 	if(selectTag.value == '1' ){
			document.getElementById('mostrar_campo_capacit_ant').hidden = false;
		}else{
			document.getElementById('mostrar_campo_capacit_ant').hidden = true;
		}	 		
	}

</script>
<?php
date_default_timezone_set('America/Argentina/San_Juan');
// recibo los datos dni curso y usuario.

if (isset($_POST["d"]))  { $dni  = $_POST["d"];  } else { $dni  = ''; }
if (isset($_POST["id"])) { $id   = $_POST["id"]; } else { $id   = ''; }
if (isset($_POST["u"]))  { $user = $_POST["u"];  } else { $user = ''; }

// $dni  = $_POST['d'];
// $id   = $_POST['id'];
// $user = $_POST['u'];



include('capacitaciones.php');	$Cap  = new Capacitaciones();
include('inscriptos.php');	    $Ins  = new Inscriptos();

$datos_dep = $Cap->gets_departamentos();

if($dni <= '999999' or $dni >= '100000000'){ // valido el DNI que sea al menos de 7 cifras y maximo de 8 cifras   ?> 
<div class="col-md-10"> 
	<div class="alert alert-success fade in block-inner">
		<i class="icon-user-minus"></i> <?php echo 'Por favor ingrese un DNI válido'; ?>
	</div>
</div>
<?php }else{	// Aparenta ser un DNI Váñido - es de 7 u 8 cifras. Busco los datos de la persona

$datos_gen =  array(
	array("id"=>"m", "descripcion"=>"Hombre"),
	array("id"=>"f", "descripcion"=>"Mujer"),
	array("id"=>"i", "descripcion"=>"Otro")
);

$datos_educ = array(
	array("id"=>'1', "nivel"=>"Primario (incompleto)"),
	array("id"=>'2', "nivel"=>"Primario (completo)"),
	array("id"=>'3', "nivel"=>"Secundario (incompleto)"),
	array("id"=>'4', "nivel"=>"Secundario (completo)"),
	array("id"=>'5', "nivel"=>"Terciario (incompleto)"),
	array("id"=>'6', "nivel"=>"Terciario (completo)"),
	array("id"=>'7', "nivel"=>"Universitario (incompleto)"),
	array("id"=>'8', "nivel"=>"Universitario (completo)")
);
$datos_trab = array(
	array("id"=>"desemp","trabajo"=>"Desempleado"),
	array("id"=>"indep","trabajo"=>"De Forma Independiente"),
	array("id"=>"depen","trabajo"=>"De Forma Dependiente")
);	

// Si está vigente y hay cupo recien voy a buscar los datos de la persona si alguna vez se inscribio o no.
$datos_persona = array();
$datos_educacion=array();
$existe = $Ins->tf_existeInscripto($dni);
if($existe){
	$penalizado = $Cap->get_tiene_penalizacion($dni); // si existe busco si esta penalizado (en lista negra)
	if(count($penalizado) > 0){
		?><div class="col-md-10"> 
				<div class="alert alert-success fade in block-inner">
					<i class="icon-user-minus"></i> <?php echo 'La persona esta penalizada hasta el día: '.$penalizado[0]['f_fin']; ?>
				</div>
		  </div><?php
	}else{
		// si existe y no está penalizado, busco si esta inscripta en algun curso vigente.
		$inscriptoEnCapacitVigente = $Ins->tf_inscriptoEnCapacitVigente($dni);
		if ($inscriptoEnCapacitVigente){ // si está inscripta en un curso vigente mando mensaje que no se puede reinscribir
		?><div class="col-md-10"> 
				<div class="alert alert-success fade in block-inner">
					<i class="icon-user-minus"></i> <?php echo 'La persona esta inscripta en un curso Vigente'; ?>
				</div>
		  </div><?php
		// sino está inscripta en algun curso vigente pero alguna vez se inscribio busco todos sus datos y puedo llenar el formulario 
		}else{
			$datos_persona  = $Ins->gets_datsPersInscripto($dni);
			$datos_educacion= $Ins->gets_datsPersInscriptoEducacion($dni)  // mustro todos los input completos con la posibilidad de editarlos. ?>
			<form name="form_actualizar" id="form_actualizar" class="form-horizontal validate" method="post" action="./funciones/admin_inscriptos_add.php"  enctype="multipart/form-data" >
				<div class="block-inner text-danger">
					<h6 class="heading-hr">2 - Tipo de Inscripción <small class="display-block">Por favor seleccione el tipo de Inscripción.</small></h6>
				</div>
				<div class="row">
					<div class="col-sm-3"></div>
					<label class="col-sm-2 control-label"><b>Seleccione Tipo de Inscripción: </b></label>
					<div class="col-sm-4">
						<div class="radio">
							<label>
								<input type="radio" id="tipo_ins" name="tipo_ins" value="n" class="styled" required><b>No Visto</b>
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" id="tipo_ins" name="tipo_ins" value="t" class="styled" required><b>Titular</b>
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" id="tipo_ins" name="tipo_ins" value="s" class="styled" required><b>Suplente</b>
							</label>
						</div>
					</div>
				</div> <br>
				<div class="block-inner text-danger">
					<h6 class="heading-hr">3 - Datos Personales <small class="display-block">Por favor ingrese sus datos personales.</small></h6>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label>DNI</label>
						<input type="number" id="dni" name="dni" placeholder="ingrese su DNI.." value="<?php echo $datos_persona[0]['dni'] ?>" class="form-control" tabindex="2" >
						<input type="hidden" name="btnInscA" id="btnInscA" value="actualizar">
					</div>
					<div class="col-md-3">
						<label>Email</label>
						<input type="email"   id="email"     name="email" placeholder="ingrese su email.." value="<?php echo $datos_persona[0]['correo'] ?>" class="form-control" tabindex="3" >
						<input type="hidden" id="idCapacit" name="idCapacit" value="<?php echo $id ?>" >
						<input type="hidden" id="usuario" name="usuario" value="<?php echo $user ?>" >
					</div>									
					<div class="col-md-2">
						<label>Apellido</label>
						<input type="text" id="apellido" name="apellido" placeholder="ingrese su apellido.." value="<?php echo $datos_persona[0]['apellido'] ?>" class="form-control" tabindex="4" required>
					</div>
					<div class="col-md-2">
						<label>Nombre</label>
						<input type="text" id="nombre" name="nombre" placeholder="ingrese su nombre.." value="<?php echo $datos_persona[0]['nombre'] ?>" class="form-control" tabindex="5" required>
					</div>									
					<div class="col-md-2" >
						<label>Género</label> 
						<select id="sexo" name="sexo" class="form-control" tabindex="6" ><?php
							for ($j=0; $j<count($datos_gen); $j++)
								echo '<option value="' . $datos_gen[$j]['id'] . '"' . (isset($datos_persona[0]['sexo']) && $datos_gen[$j]['id'] == $datos_persona[0]['sexo'] ? ' selected="selected"' : '') . '>' .$datos_gen[$j]['descripcion']. "</option>\n";
							?>	
						</select>
					</div>
				</div>	<br>
				<div class="row">
					<div class="col-md-2">
						<label>F. Nacimiento </label>
						<input type="date" id="f_nac" name="f_nac" value="<?php echo $datos_persona[0]['f_nacimiento'] ?>" class="form-control" tabindex="7" required>
					</div>
					<div class="col-md-2">
						<label>Telefono</label>
						<input type="text" id="tel" name="tel" placeholder="ingrese su telefono.." value="<?php echo $datos_persona[0]['telefono'] ?>" class="form-control" tabindex="8" required>
					</div>
					<div class="col-md-2">
						<label>Departamento</label>
						<select id="dpto" name="dpto" class="form-control" tabindex="9" required><?php
							for ($i=0; $i<count($datos_dep); $i++)
								echo '<option value="' . $datos_dep[$i]['id'] . '"' . (isset($datos_persona[0]['fk_departamentos']) && $datos_dep[$i]['id'] == $datos_persona[0]['fk_departamentos'] ? ' selected="selected"' : '') . '>' .$datos_dep[$i]['nombre']. "</option>\n";
							?>	
						</select>
					</div>
					<div class="col-md-3">
						<label>Calle</label>
						<input type="text" id="calle" name="calle" placeholder="ingrese su calle.." value="<?php echo $datos_persona[0]['dir_calle'] ?>" class="form-control" tabindex="10" required>
					</div>
					<div class="col-md-1">
						<label>Nro</label>
						<input type="text" id="nro" name="nro" placeholder="ingrese su número.." value="<?php echo $datos_persona[0]['dir_nro'] ?>" class="form-control" tabindex="11" required>
					</div>
				</div> <br>	
				<div class="row">
					<div class="col-md-3"></div> 
					<div class="col-md-6">
						<label>Subir Certificación Negativa de ANSES: (pdf o una captura de pantalla del mensaje que te brinde ANSES) </label>
						<input type="file" id="url_certif_neg" name="url_certif_neg" accept="application/pdf, image/png, image/jpeg, image/jpg" class="form-control" required></div>
					</div>
				</div><br/>	
				<div class="block-inner text-danger">
					<h6 class="heading-hr">4 - Datos Educativos <small class="display-block">Por favor complete todos los datos:</small></h6>
				</div>
				<div class="row"> <?php	// existen datos educativos
					if(count($datos_educacion) > 0){ ?> 
						<div class="col-md-4">
							<label>¿Último Nivel Educativo alcanzado?</label>
							<select id="nivel_alcanzado" name="nivel_alcanzado" class="form-control" onchange="ult_nivel_alcanzado(this)" tabindex="12" ><?php
								for ($j=0; $j<count($datos_educ); $j++)
									echo '<option value="' . $datos_educ[$j]['id'] . '"' . (isset($datos_educacion[0]['nivel_alcanzado']) && $datos_educ[$j]['id'] == $datos_educacion[0]['nivel_alcanzado'] ? ' selected="selected"' : '') . '>' .$datos_educ[$j]['nivel']. "</option>\n";
								?>	
							</select>
						</div>
					<?php
						if ($datos_educacion[0]['nivel_alcanzado'] >= 5 ) { ?>
							<div class="col-md-4" >
								<label>Titulo / Especialidad</label>
								<input type="text" id="titulo" name="titulo" value="<?php echo $datos_educacion[0]['titulo_especialidad'] ?>" class="form-control" tabindex="13">
							</div>
						<?php } else { ?>
							<div id="mostrar_campo_titulo" class="col-md-4" hidden="true" >
								<label>Titulo / Especialidad</label>
								<input type="text" id="titulo" name="titulo" class="form-control" tabindex="13">
							</div>
						<?php } ?>
				</div><br>
						<!-- Datos Laborales -->
							<div class="block-inner text-danger">
								<h6 class="heading-hr">5 - Datos Laborales <small class="display-block">Por favor complete todos los datos:</small></h6>
							</div>
							<div class="row">								
								<div class="col-md-4">
									<label>Ocupación</label>
									<input type="text" id="ocupacion" name="ocupacion" value="<?php echo $datos_educacion[0]['ocupacion'] ?>" class="form-control" tabindex="14">
								</div>
								<div class="col-md-4">
									<label>Trabajo actual</label>  
									<select id="trabajo_actual" name="trabajo_actual" class="form-control" onchange="en_q_hs_trabaja(this)" tabindex="12" ><?php
										for ($j=0; $j<count($datos_trab); $j++)
											echo '<option value="' . $datos_trab[$j]['id'] . '"' . (isset($datos_educacion[0]['trabajo_actual']) && $datos_trab[$j]['id'] == $datos_educacion[0]['trabajo_actual'] ? ' selected="selected"' : '') . '>' .$datos_trab[$j]['trabajo']. "</option>\n";
										?>	
									</select>
								</div>																
								<div id="mostrar_hs_trabajo_actual" class="col-md-4" hidden="true">
									<label>En que hs trabaja</label>   
									<input id="hs_trabajo" name="hs_trabajo" class="required form-control" value="sin información.."><span class="help-block" tabindex="16"></span>
								</div>
							</div><br />
							<!-- Capacitaciones -->
							<div class="block-inner text-danger">
								<h6 class="heading-hr"> 6 - Capacitaciones previas <small class="display-block">Por favor complete todos los datos:</small></h6>
							</div>					
							<div class="row">
								<div class="col-md-4">
									<label>¿Posee conocimientos en el rubro?</label>
									<select id="posee_conocim_rubro" name="posee_conocim_rubro" class="form-control" tabindex="17" >
										<?php
											echo '<option value="0">'  .'No'.    "</option>\n";
											echo '<option value="1">'  .'Si'.    "</option>\n";
										?>	
									</select>
								</div>
								<div class="col-md-4">
									<label>¿Ha tomado otra capacitación de esta Dirección?</label>
									<select id="capacit_ant" name="capacit_ant" class="form-control" onchange="hay_capacit_anterior(this)" tabindex="18" >
										<?php
											echo '<option value="0">'  .'No'.    "</option>\n";
											echo '<option value="1">'  .'Si'.    "</option>\n";
										?>	
									</select>
								</div>
								<div id="mostrar_campo_capacit_ant" class="col-md-4" hidden="true"> 
									<label>¿Cuál?</label>
									<input type="text" id="capacit_ant_cual" name="capacit_ant_cual" placeholder="ingrese cual.." value="sin información.." class="form-control" tabindex="19">
								</div>
							</div><br/>	
						<?php }else{ ?>
							<div class="row">
								<div class="col-md-4">
									<label>¿Último Nivel Educativo alcanzado?</label>
									<select id="nivel_alcanzado" name="nivel_alcanzado" class="form-control" onchange="ult_nivel_alcanzado(this)" tabindex="12" >
										<?php
										echo '<option value="1">'  .'Primario (incompleto)'.       "</option>\n";
										echo '<option value="2">'  .'Primario (completo)'.         "</option>\n";
										echo '<option value="3">'  .'Secundario (incompleto)'.     "</option>\n";
										echo '<option value="4">'  .'Secundario (completo)'.       "</option>\n";
										echo '<option value="5">'  .'Terciario (incompleto)'.      "</option>\n";
										echo '<option value="6">'  .'Terciario (completo)'.        "</option>\n";
										echo '<option value="7">'  .'Universitario (incompleto)'.  "</option>\n";
										echo '<option value="8">'  .'Universitario (completo)'.    "</option>\n";
										?>	
									</select>
									<input type="hidden" id="datos_edu_upd" name="datos_edu_upd" value="actualizar" tabindex="13">
								</div>
								<div id="mostrar_campo_titulo" class="col-md-4" hidden="true">
									<label>Titulo / Especialidad </label>
									<input type="text" id="titulo" name="titulo" placeholder="ingrese su titulo / especialidad.." value="sin información.." class="form-control" tabindex="13">
								</div>
							</div><br>
							<!-- Datos Laborales -->
							<div class="block-inner text-danger">
								<h6 class="heading-hr">5 - Datos Laborales <small class="display-block">Por favor complete todos los datos:</small></h6>
							</div>
							<div class="row">								
								<div class="col-md-4">
									<label>Ocupación</label>
									<input type="text" id="ocupacion" name="ocupacion" placeholder="por ej: estudiante, desocupado, ama de casa, docente, emprendedor, jubilado, otro.." class="form-control" tabindex="14">
								</div>
								<div class="col-md-4">
									<label>Trabajo actual</label>  
									<select id="trabajo_actual" name="trabajo_actual" class="form-control" onchange="en_q_hs_trabaja(this)" tabindex="15" >
									<?php
										echo '<option value="desem">'.' Desempleado'.            "</option>\n";
										echo '<option value="indep">'.' De forma Independiente'. "</option>\n";
										echo '<option value="depen">'.' De forma Dependiente'.   "</option>\n";
									?>	
									</select>
								</div>																
								<div id="mostrar_hs_trabajo_actual" class="col-md-4" hidden="true">
									<label>En que hs trabaja</label>   
									<input id="hs_trabajo" name="hs_trabajo" class="required form-control" value="sin información.."><span class="help-block" tabindex="16"></span>
								</div>
							</div><br />
							<!-- Capacitaciones -->
							<div class="block-inner text-danger">
								<h6 class="heading-hr"> 6 - Capacitaciones previas <small class="display-block">Por favor complete todos los datos:</small></h6>
							</div>					
							<div class="row">
								<div class="col-md-4">
									<label>¿Posee conocimientos en el rubro?</label>
									<select id="posee_conocim_rubro" name="posee_conocim_rubro" class="form-control" tabindex="17" >
									<?php
										echo '<option value="0">'  .'No'.    "</option>\n";
										echo '<option value="1">'  .'Si'.    "</option>\n";
									?>	
									</select>
								</div>
								<div class="col-md-4">
									<label>¿Ha tomado otra capacitación de esta Dirección?</label>
									<select id="capacit_ant" name="capacit_ant" class="form-control" onchange="hay_capacit_anterior(this)" tabindex="18" >
									<?php
										echo '<option value="0">'  .'No'.    "</option>\n";
										echo '<option value="1">'  .'Si'.    "</option>\n";
									?>	
									</select>
								</div>
								<div id="mostrar_campo_capacit_ant" class="col-md-4" hidden="true"> 
									<label>¿Cuál?</label>
									<input type="text" id="capacit_ant_cual" name="capacit_ant_cual" placeholder="ingrese cual.." value="sin información.." class="form-control" tabindex="19">
								</div>
							</div><br/>
						<?php }?>
					</div><br/>
					<hr>
					<div class="form-actions text-center">
						<center><button type="submit" class="btn btn-primary" title="Presione el boton para agregar la inscripción"> Inscribir </button></center>
					</div>
			</form>
		<?php } // fin del else de que no esta inscripta en un curso actual o vigente 
	} // fin del else de No esta penalizado (lista negra)
}else{ 	// muestro todos los input vacios. 	?>
	<form name="form_insertar" id="form_insertar" class="form-horizontal validate" role="form" method="post" action="./funciones/admin_inscriptos_add.php"  enctype="multipart/form-data" >
		<div class="block-inner text-danger">
			<h6 class="heading-hr">2 - Tipo de Inscripción <small class="display-block">Por favor seleccione el tipo de Inscripción.</small></h6>
		</div>
		<div class="row">
			<div class="col-sm-3"></div>
			<label class="col-sm-2 control-label"><b>Seleccione Tipo de Inscripción: </b></label>
			<div class="col-sm-4">
				<div class="radio">
					<label>
						<input type="radio" id="tipo_ins" name="tipo_ins" value="n" class="styled" required><b>No Visto</b>
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" id="tipo_ins" name="tipo_ins" value="t" class="styled" required><b>Titular</b>
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" id="tipo_ins" name="tipo_ins" value="s" class="styled" required><b>Suplente</b>
					</label>
				</div>
			</div>
		</div> <br>
		<div class="block-inner text-danger">
			<h6 class="heading-hr">3 - Datos Personales <small class="display-block">Por favor ingrese sus datos personales.</small></h6>
		</div>
		<div class="row"> 
			<div class="col-md-2">
				<label>DNI</label>
				<input type="number" id="dni" name="dni" value="<?php echo $dni; ?>" class="form-control" tabindex="2" readonly >
				<input type="hidden" name="btnInscI" id="btnInscI" value="insertar">
			</div>
			<div class="col-md-3">
				<label>Email</label>
				<input type="email"   id="email" name="email" placeholder="ingrese su email.." class="form-control" tabindex="3" required >
				<input type="hidden" id="idCapacit" name="idCapacit" value="<?php echo $id ?>" >
				<input type="hidden" id="usuario" name="usuario" value="<?php echo $user ?>" >
			</div>									
			<div class="col-md-2">
				<label>Apellido</label>
				<input type="text" id="apellido" name="apellido" placeholder="ingrese su apellido.." class="form-control" tabindex="4" required>
			</div>
			<div class="col-md-2">
				<label>Nombre</label>
				<input type="text" id="nombre" name="nombre" placeholder="ingrese su nombre.." class="form-control" tabindex="5" required>
			</div>									
			<div class="col-md-2" >
				<label>Género</label>
				<select id="sexo" name="sexo" class="form-control" tabindex="6" required><?php
					for ($i=0; $i<count($datos_gen); $i++)
						echo '<option value="'.$datos_gen[$i]['id'].'">' .$datos_gen[$i]['descripcion']. "</option>\n";
					?>	
				</select>
			</div>
		</div>	<br/>
		<div class="row">
			<div class="col-md-2">
				<label>F. Nacimiento </label>
				<input type="date" id="f_nac" name="f_nac" class="form-control" tabindex="7" required>
			</div>
			<div class="col-md-2">
				<label>Telefono</label>
				<input type="text" id="tel" name="tel" placeholder="ingrese su telefono.." class="form-control" tabindex="8" required>
			</div>
			<div class="col-md-2">
				<label>Departamento</label>
				<select id="dpto" name="dpto" class="form-control" tabindex="9" required><?php
					for ($i=0; $i<count($datos_dep); $i++)
						echo '<option value="'.$datos_dep[$i]['id'].'">' .$datos_dep[$i]['nombre']. "</option>\n";
					?>	
				</select>
			</div>
			<div class="col-md-3">
				<label>Calle</label>
				<input type="text" id="calle" name="calle" placeholder="ingrese su calle.." class="form-control" tabindex="10" required>
			</div>
			<div class="col-md-1">
				<label>Nro</label>
				<input type="text" id="nro" name="nro" placeholder="ingrese su número.." class="form-control" tabindex="11" required>
			</div>
		</div><br/>
		<div class="row"> 
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<label>Subir Certificación Negativa de ANSES: (pdf o una captura de pantalla del mensaje que te brinde ANSES) </label>
				<input type="file" id="url_certif_neg" name="url_certif_neg" accept="application/pdf, image/png, image/jpeg, image/jpg" class="form-control" required></div>
			</div>
		</div><br/>
		<div class="block-inner text-danger">
			<h6 class="heading-hr">4 - Datos Educativos <small class="display-block">Por favor complete todos los datos:</small></h6>
		</div>
			<div class="row">
				<div class="col-md-4">
					<label>¿Último Nivel Educativo alcanzado?</label>
					<select id="nivel_alcanzado" name="nivel_alcanzado" class="form-control" onchange="ult_nivel_alcanzado(this)" tabindex="12" required>
					<?php
						echo '<option value="1">'  .'Primario (incompleto)'.       "</option>\n";
						echo '<option value="2">'  .'Primario (completo)'.         "</option>\n";
						echo '<option value="3">'  .'Secundario (incompleto)'.     "</option>\n";
						echo '<option value="4">'  .'Secundario (completo)'.       "</option>\n";
						echo '<option value="5">'  .'Terciario (incompleto)'.      "</option>\n";
						echo '<option value="6">'  .'Terciario (completo)'.        "</option>\n";
						echo '<option value="7">'  .'Universitario (incompleto)'.  "</option>\n";
						echo '<option value="8">'  .'Universitario (completo)'.    "</option>\n";
					?>	
					</select>
				</div>
				<div id="mostrar_campo_titulo" class="col-md-4" hidden="true">
					<label>Titulo / Especialidad</label>
					<input type="text" id="titulo" name="titulo" placeholder="ingrese su titulo / especialidad.." value="sin información.." class="form-control" tabindex="13">
				</div>
			</div><br/>
			<!-- Datos Laborales -->
			<div class="block-inner text-danger">
				<h6 class="heading-hr">5 - Datos Laborales <small class="display-block">Por favor complete todos los datos:</small></h6>
			</div>
			<div class="row">								
				<div class="col-md-4">
					<label>Ocupación</label>
					<input type="text" id="ocupacion" name="ocupacion" placeholder="por ej: estudiante, desocupado, ama de casa, docente, emprendedor, jubilado, otro.." class="form-control" tabindex="14">
				</div>
				<div class="col-md-4">
					<label>Trabajo actual</label>  
					<select id="trabajo_actual" name="trabajo_actual" class="form-control" onchange="en_q_hs_trabaja(this)" tabindex="15" >
					<?php
						echo '<option value="desem">'.' Desempleado'.            "</option>\n";
						echo '<option value="indep">'.' De forma Independiente'. "</option>\n";
						echo '<option value="depen">'.' De forma Dependiente'.   "</option>\n";
					?>	
					</select>
				</div>																
				<div id="mostrar_hs_trabajo_actual" class="col-md-4" hidden="true">
					<label>En que hs trabaja</label>   
					<input id="hs_trabajo" name="hs_trabajo" class="required form-control" value="sin información.."><span class="help-block" tabindex="16"></span>
				</div>
			</div><br />
			<!-- Capacitaciones -->
			<div class="block-inner text-danger">
				<h6 class="heading-hr"> 6 - Capacitaciones Previas <small class="display-block">Por favor complete todos los datos:</small></h6>
			</div>					
			<div class="row">
				<div class="col-md-4">
					<label>¿Posee conocimientos en el rubro?</label>
					<select id="posee_conocim_rubro" name="posee_conocim_rubro" class="form-control" tabindex="17" >
					<?php
						echo '<option value="0">'  .'No'.    "</option>\n";
						echo '<option value="1">'  .'Si'.    "</option>\n";
					?>	
					</select>
				</div>
				<div class="col-md-4">
					<label>¿Ha tomado otra capacitación de esta Dirección?</label>
					<select id="capacit_ant" name="capacit_ant" class="form-control" onchange="hay_capacit_anterior(this)" tabindex="18" >
					<?php
						echo '<option value="0">'  .'No'.    "</option>\n";
						echo '<option value="1">'  .'Si'.    "</option>\n";
					?>	
					</select>
				</div>
				<div id="mostrar_campo_capacit_ant" class="col-md-4" hidden="true"> 
					<label>¿Cuál?</label>
					<input type="text" id="capacit_ant_cual" name="capacit_ant_cual" placeholder="ingrese cual.." value="sin información.." class="form-control" tabindex="19">
				</div>
			</div><br/>
			<hr>
		<div class="form-actions">
			<center><button type="submit" class="btn btn-primary" title="Presione el boton para agregar la inscripción"> Inscribir </button></center> 
		</div>
	</form> 
<?php } 

}
?>